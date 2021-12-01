<?php
require_once(__DIR__ . "/db.php");
$BASE_PATH = '/Project/'; //This is going to be a helper for redirecting to our base project path since it's nested in another folder
function se($v, $k = null, $default = "", $isEcho = true)
{
    if (is_array($v) && isset($k) && isset($v[$k])) {
        $returnValue = $v[$k];
    } else if (is_object($v) && isset($k) && isset($v->$k)) {
        $returnValue = $v->$k;
    } else {
        $returnValue = $v;
        //added 07-05-2021 to fix case where $k of $v isn't set
        //this is to kep htmlspecialchars happy
        if (is_array($returnValue) || is_object($returnValue)) {
            $returnValue = $default;
        }
    }
    if (!isset($returnValue)) {
        $returnValue = $default;
    }
    if ($isEcho) {
        //https://www.php.net/manual/en/function.htmlspecialchars.php
        echo htmlspecialchars($returnValue, ENT_QUOTES);
    } else {
        //https://www.php.net/manual/en/function.htmlspecialchars.php
        return htmlspecialchars($returnValue, ENT_QUOTES);
    }
}
//TODO 2: filter helpers
function sanitize_email($email = "")
{
    return filter_var(trim($email), FILTER_SANITIZE_EMAIL);
}
function is_valid_email($email = "")
{
    return filter_var(trim($email), FILTER_VALIDATE_EMAIL);
}
//TODO 3: User Helpers
function is_logged_in($redirect = false, $destination = "login.php")
{
    $isLoggedIn = isset($_SESSION["user"]);
    if ($redirect && !$isLoggedIn) {
        flash("You must be logged in to view this page", "warning");
        die(header("Location: $destination"));
    }
    return $isLoggedIn; //se($_SESSION, "user", false, false);
}
function has_role($role)
{
    if (is_logged_in() && isset($_SESSION["user"]["roles"])) {
        foreach ($_SESSION["user"]["roles"] as $r) {
            if ($r["name"] === $role) {
                return true;
            }
        }
    }
    return false;
}
function get_username()
{
    if (is_logged_in()) { //we need to check for login first because "user" key may not exist
        return se($_SESSION["user"], "username", "", false);
    }
    return "";
}
function get_user_email()
{
    if (is_logged_in()) { //we need to check for login first because "user" key may not exist
        return se($_SESSION["user"], "email", "", false);
    }
    return "";
}
function get_user_id()
{
    if (is_logged_in()) { //we need to check for login first because "user" key may not exist
        return se($_SESSION["user"], "id", false, false);
    }
    return false;
}
//TODO 4: Flash Message Helpers
function flash($msg = "", $color = "info")
{
    $message = ["text" => $msg, "color" => $color];
    if (isset($_SESSION['flash'])) {
        array_push($_SESSION['flash'], $message);
    } else {
        $_SESSION['flash'] = array();
        array_push($_SESSION['flash'], $message);
    }
}

function getMessages()
{
    if (isset($_SESSION['flash'])) {
        $flashes = $_SESSION['flash'];
        $_SESSION['flash'] = array();
        return $flashes;
    }
    return array();
}
//TODO generic helpers
function reset_session()
{
    session_unset();
    session_destroy();
    session_start();
}
function users_check_duplicate($errorInfo)
{
    if ($errorInfo[1] === 1062) {
        //https://www.php.net/manual/en/function.preg-match.php
        preg_match("/Users.(\w+)/", $errorInfo[2], $matches);
        if (isset($matches[1])) {
            flash("The chosen " . $matches[1] . " is not available.", "warning");
        } else {
            //TODO come up with a nice error message
            flash("<pre>" . var_export($errorInfo, true) . "</pre>");
        }
    } else {
        //TODO come up with a nice error message
        flash("<pre>" . var_export($errorInfo, true) . "</pre>");
    }
}
function get_url($dest)
{
    global $BASE_PATH;
    if (str_starts_with($dest, "/")) {
        //handle absolute path
        return $dest;
    }
    //handle relative path
    return $BASE_PATH . $dest;
}

function save_score($user_id, $score, $showflash = true)
{

    if ($user_id < 1) {
        flash("not login", "warning");
        return;
    }

    if ($score <= 0) {
        flash("zero score not valid", "warning");
        return;
    }

    $db = getDB();
    $stmt = $db->prepare("INSERT INTO Scores(user_id, score) VALUES (:userid, :score)");
    try {
        $stmt->execute([":userid" => $user_id, ":score" => $score]);
        if ($showflash) {
            flash("Saved score of $score", "success");
        }
    } catch (PDOException $e) {
        flash("Error saving score: " . var_export($e->errorInfo, true), "danger");
    }
}

function get_user_scores($user_id, $min)
{
    if (!isset($min)) {
        $min = 10;
    }
    $db = getDB();
    $db->setAttribute(PDO::ATTR_EMULATE_PREPARES, false);
    $stmt = $db->prepare("SELECT score, created from Scores where user_id = :id ORDER BY created desc LIMIT :min");
    try {
        $stmt->execute([":id" => $user_id, ":min" => $min]);
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($r) {
            return $r;
        }
    } catch (PDOException $e) {
        error_log("Error getting latest $min scores for user $user_id: " . var_export($e->errorInfo, true));
    }
    return [];
}

function get_top_week()
{
    $db = getDB();
    $query = "SELECT user_id, username, score, Scores.created from Scores join Users on Scores.user_id = Users.id";
    $query .= " WHERE Scores.created >= DATE_SUB(NOW(), INTERVAL 1 DAY)";
    $query .= " ORDER BY score Desc, Scores.created desc LIMIT 10";
    $stmt = $db->prepare($query);
    $results = [];
    try {
        $stmt->execute();
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($r) {
            $results = $r;
        }
    } catch (PDOException $e) {
        error_log("Error fetching scores for weak: " . var_export($e->errorInfo, true));
    }
    return $results;
}

function get_top_month()
{
    $db = getDB();
    $query = "SELECT user_id, username, score, Scores.created from Scores join Users on Scores.user_id = Users.id";
    $query .= " WHERE Scores.created >= DATE_SUB(NOW(), INTERVAL 1 WEEK)";
    $query .= " ORDER BY score Desc, Scores.created desc LIMIT 10";
    $stmt = $db->prepare($query);
    $results = [];
    try {
        $stmt->execute();
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($r) {
            $results = $r;
        }
    } catch (PDOException $e) {
        error_log("Error fetching scores for weak: " . var_export($e->errorInfo, true));
    }
    return $results;
}

function get_top_lifetime()
{
    $db = getDB();
    $query = "SELECT user_id, username, score, Scores.created from Scores join Users on Scores.user_id = Users.id";
    $query .= " ORDER BY score Desc, Scores.created desc LIMIT 10";
    $stmt = $db->prepare($query);
    $results = [];
    try {
        $stmt->execute();
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($r) {
            $results = $r;
        }
    } catch (PDOException $e) {
        error_log("Error fetching scores for weak: " . var_export($e->errorInfo, true));
    }
    return $results;
}

function user_points($user_id)
{

    $db = getDB();
    $stmt = $db->prepare("SELECT points, created from Users where id = :id");
    try {
        $stmt->execute([":id" => $user_id]);
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($r) {
            return $r;
        }
    } catch (PDOException $e) {
        error_log("Error getting points for user $user_id: " . var_export($e->errorInfo, true));
    }
    return $r;
}
