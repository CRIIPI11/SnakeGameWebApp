<?php
require(__DIR__ . "/../../partials/nav.php");
?>
<div class="container-fluid">
    <h1>Register</h1>
    <form onsubmit="return validate(this)" method="POST">
        <div class="mb-3">
            <label class="form-label" for="email">Email</label>
            <input class="form-control" type="email" id="email" name="email" required />
        </div>
        <div class="mb-3">
            <label class="form-label" for="username">Username</label>
            <input class="form-control" type="text" name="username" required maxlength="30" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="pw">Password</label>
            <input class="form-control" type="password" id="pw" name="password" required minlength="8" />
        </div>
        <div class="mb-3">
            <label class="form-label" for="confirm">Confirm</label>
            <input class="form-control" type="password" name="confirm" required minlength="8" />
        </div>
        <input type="submit" class="mt-3 btn btn-primary" value="Register" />
    </form>
</div>
<script>
    function validate(form) {
        //TODO 1: implement JavaScript validation
        //ensure it returns false for an error and true for success

        return true;
    }
</script>
<?php
//TODO 2: add PHP Code
if (isset($_POST["email"]) && isset($_POST["password"]) && isset($_POST["confirm"])) {
    $email = se($_POST, "email", "", false);
    $password = se($_POST, "password", "", false);
    $confirm = se($_POST, "confirm", "", false);
    $username = se($_POST, "username", "", false);
    //TODO 3


    //$errors = [];
    $hasError = false;
    if (empty($email)) {
        flash("Email must not be empty");
        $hasError = true;
    }
    //$email = filter_var($email, FILTER_SANITIZE_EMAIL);
    $email = sanitize_email($email);
    //validate
    //if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
    if (!is_valid_email($email)) {
        flash("Invalid email");
        $hasError = true;
    }
    if (!preg_match('/^[a-z0-9_-]{3,16}$/', $username)) {
        flash("Username must only be alphanumeric and can only contain - or _");
        $hasError = true;
    }
    if (empty($password)) {
        flash("password must not be empty");
        $hasError = true;
    }
    if (empty($confirm)) {
        flash("Confirm password must not be empty");
        $hasError = true;
    }
    if (strlen($password) < 8) {
        flash("Password too short");
        $hasError = true;
    }
    if (strlen($password) > 0 && $password !== $confirm) {
        flash("Passwords must match");
        $hasError = true;
    }
    if ($hasError) {
        //flash("<pre>" . var_export($errors, true) . "</pre>");
    } else {
        //flash("Welcome, $email"); //will show on home.php
        $hash = password_hash($password, PASSWORD_BCRYPT);
        $db = getDB();
        $stmt = $db->prepare("INSERT INTO Users (email, password, username) VALUES(:email, :password, :username)");
        try {
            $stmt->execute([":email" => $email, ":password" => $hash, ":username" => $username]);
            flash("You've registered, yay...");
        } catch (Exception $e) {
            /* flash("There was a problem registering");
            flash("<pre>" . var_export($e, true) . "</pre>");*/
            users_check_duplicate($e->errorInfo);
        }
    }
}
?>
<?php
require(__DIR__ . "/../../partials/flash.php");
?>