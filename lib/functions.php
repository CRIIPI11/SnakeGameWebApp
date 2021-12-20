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

function get_user_scores($user_id, $min = 10)
{

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

function save_points($user_id, $points, $reason = null)
{

    if ($user_id < 1) {
        return;
    }

    /*if ($points <= 0) {
        return;
    }*/

    $db = getDB();
    $stmt = $db->prepare("INSERT INTO PointsHistory(user_id, point_change, reason) VALUES (:userid, :points, :reason)");
    try {
        $stmt->execute([":userid" => $user_id, ":points" => $points, ":reason" => $reason]);
        update_points($user_id);
    } catch (PDOException $e) {
        flash("Error saving score: " . var_export($e->errorInfo, true), "danger");
    }
}

function update_points($user_id)
{
    $db = getDB();
    $query = "UPDATE Users set points = (SELECT IFNULL(SUM(point_change), 0) from PointsHistory WHERE user_id = :id) where id = :id";
    $stmt = $db->prepare($query);
    try {
        $stmt->execute([":id" => $user_id]);
    } catch (PDOException $e) {
        error_log("Error " . var_export($e->errorInfo, true));
    }
}


function get_points()
{
    if (is_logged_in()) {
        return se($_SESSION["user"], "points", "", false);
    }
    return "";
}

function join_competition($comp_id, $user_id)
{
    $points = get_points();
    if ($comp_id > 0) {
        $db = getDB();
        $query = "SELECT name, join_fee, current_participants from Competitions where id = :cid";
        $stmt = $db->prepare($query);
        try {
            $stmt->execute([":cid" => $comp_id]);
            $d = $stmt->fetch(PDO::FETCH_ASSOC);
            if ($d) {
                $cost = (int)se($d, "join_fee", 0, false);
                $participants = (int)se($d, "current_participants");
                if ($participants <= 0) {
                    competition_attach($comp_id, $user_id);
                } else if ($points >= $cost) {
                    if (competition_attach($comp_id, $user_id)) {
                        save_points($user_id, -$cost, "joined competition");
                        $name = se($d, "name", "", false);
                        flash("Successfully joined $name", "success");
                    } else {
                        flash("Already in Competition", "warning");
                    }
                } else {
                    flash("You can't afford to join this competition", "warning");
                }
            }
        } catch (PDOException $e) {
            error_log("error " . var_export($e, true));
        }
    } else {
        flash("Invalid competition, please try again", "danger");
    }
}
function competition_attach($comp_id, $user_id)
{
    $db = getDB();
    $query = "INSERT INTO CompetitionParticipants (comp_id, user_id) VALUES (:cid, :uid)";
    $stmt = $db->prepare($query);
    try {
        $stmt->execute([":cid" => $comp_id, ":uid" => $user_id]);
        update_participants($comp_id);
        return true;
    } catch (PDOException $e) {
        error_log("error: " . var_export($e, true));
    }
    return false;
}
function update_participants($comp_id)
{
    $db = getDB();
    $query = "UPDATE Competitions set current_participants = (SELECT IFNULL(COUNT(1),0) FROM CompetitionParticipants WHERE comp_id = :cid), current_reward = IF(join_fee > 0, current_reward + CEILING(join_fee * 0.5), current_reward) WHERE id = :cid";
    $stmt = $db->prepare($query);
    try {
        $stmt->execute([":cid" => $comp_id]);
        return true;
    } catch (PDOException $e) {
        error_log("error: " . var_export($e, true));
    }
    return false;
}

function top_comp_scores($comp_id, $limit = 10)
{
    $db = getDB();
    //below if a user can win more than one place
    /*$stmt = $db->prepare(
        "SELECT score, s.created, username, u.id as user_id FROM BGD_Scores s 
    JOIN BGD_UserComps uc on uc.user_id = s.user_id 
    JOIN BGD_Competitions c on c.id = uc.competition_id
    JOIN Users u on u.id = s.user_id WHERE c.id = :cid AND s.score >= c.min_score AND s.created 
    BETWEEN uc.created AND c.expires ORDER BY s.score desc LIMIT :limit"
    );*/
    //Below if a user can't win more than one place
    $stmt = $db->prepare("SELECT * FROM (SELECT s.user_id, s.score, s.created, a.id as account_id, DENSE_RANK() OVER (PARTITION BY s.user_id ORDER BY s.score desc) as `rank` FROM Scores s
    JOIN CompetitionParticipants uc on uc.user_id = s.user_id
    JOIN Competitions c on uc.competition_id = c.id
    JOIN Users a on a.user_id = s.user_id
    WHERE c.id = :cid AND s.created BETWEEN uc.created AND c.expires
    )as t where `rank` = 1 ORDER BY score desc LIMIT :limit");
    $scores = [];
    try {
        $stmt->bindValue(":cid", $comp_id, PDO::PARAM_INT);
        $stmt->bindValue(":limit", $limit, PDO::PARAM_INT);
        $stmt->execute();
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($r) {
            $scores = $r;
        }
    } catch (PDOException $e) {
        flash("There was a problem fetching scores, please try again later", "danger");
        error_log("List competition scores error: " . var_export($e, true));
    }
    return $scores;
}

function calc_win()
{

    $db = getDB();
    $calced_comps = [];
    $stmt = $db->prepare("SELECT id, name, first_place_per, second_place_per, third_place_per, current_reward, from Competitions where expires <= CURRENT_TIMESTAMP() AND paid_out = 0 AND current_participants >= min_participants LIMIT 10");

    try {
        $stmt->execute();
        $r = $stmt->fetchAll(PDO::FETCH_ASSOC);
        if ($r) {
            $rc = $stmt->rowCount();
            //elog("Validating $rc comps");
            foreach ($r as $row) {
                $fp = floatval(se($row, "first_place_per", 0, false) / 100);
                $sp = floatval(se($row, "second_place_per", 0, false) / 100);
                $tp = floatval(se($row, "third_place_per", 0, false) / 100);
                $reward = (int)se($row, "current_reward", 0, false);
                $title = se($row, "name", "-", false);
                $fpr = ceil($reward * $fp);
                $spr = ceil($reward * $sp);
                $tpr = ceil($reward * $tp);
                $comp_id = se($row, "id", -1, false);

                try {
                    $r = top_comp_scores($comp_id, 3);
                    if ($r) {
                        $atleastOne = false;
                        foreach ($r as $index => $row) {
                            $aid = se($row, "account_id", -1, false);
                            $score = se($row, "score", 0, false);
                            $user_id = se($row, "user_id", -1, false);
                            if ($index == 0) {
                                if (save_points($user_id, $fpr, "First place in $title with score of $score")) {
                                    $atleastOne = true;
                                }
                                //elog("User $user_id First place in $title with score of $score");
                            } else if ($index == 1) {
                                if (save_points($user_id, $spr, "Second place in $title with score of $score")) {
                                    $atleastOne = true;
                                }
                                //elog("User $user_id Second place in $title with score of $score");
                            } else if ($index == 2) {
                                if (save_points($user_id, $tpr, "Third place in $title with score of $score")) {
                                    $atleastOne = true;
                                }
                                //elog("User $user_id Third place in $title with score of $score");
                            }
                        }
                        if ($atleastOne) {
                            array_push($calced_comps, $comp_id);
                        }
                    } else {
                        //elog("No eligible scores");
                    }
                } catch (PDOException $e) {
                    error_log("Getting winners error: " . var_export($e, true));
                }
            }
        } else {
            //elog("No competitions ready");
        }
    } catch (PDOException $e) {
        error_log("Getting Expired Comps error: " . var_export($e, true));
    }
    //closing calced comps
    if (count($calced_comps) > 0) {
        $query = "UPDATE Competitions set paid_out = 1 WHERE id in ";
        $query .= "(" . str_repeat("?,", count($calced_comps) - 1) . "?)";
        //elog("Close query: $query");
        $stmt = $db->prepare($query);
        try {
            $stmt->execute($calced_comps);
            $updated = $stmt->rowCount();
            //elog("Marked $updated comps complete and calced");
        } catch (PDOException $e) {
            error_log("Closing valid comps error: " . var_export($e, true));
        }
    } else {
        //elog("No competitions to calc");
    }
    //close invalid comps
    $stmt = $db->prepare("UPDATE Competitions set paid_out = 1 WHERE expires <= CURRENT_TIMESTAMP() AND current_participants < min_participants");
    try {
        $stmt->execute();
        $rows = $stmt->rowCount();
        //elog("Closed $rows invalid competitions");
    } catch (PDOException $e) {
        error_log("Closing invalid comps error: " . var_export($e, true));
    }
    //elog("Done calc winners");
}
