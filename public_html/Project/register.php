<?php
require(__DIR__ . "/../../partials/nav.php");
?>

<div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
            <div class="card bg-dark text-white" style="border-radius: 1rem;">
                <div class="card-body p-5">
                    <h1 class="fw-bold mb-2 text-uppercase">Create Account</h1>
                    <div class="mb-md-5 mt-md-4 pb-5">
                        <form onsubmit="return validate(this)" method="POST">
                            <div class="form-outline mb-4">
                                <input class="form-control form-control-lg" placeholder="Email" type="email" id="email" name="email" required />
                            </div>
                            <div class="form-outline mb-4">
                                <input class="form-control form-control-lg" placeholder="Username" type="text" name="username" required maxlength="30" />
                            </div>
                            <div class="form-outline mb-4">
                                <input class="form-control form-control-lg" placeholder="Password" type="password" id="pw" name="password" required minlength="8" />
                            </div>
                            <div class="form-outline mb-4">
                                <input class="form-control form-control-lg" placeholder="Confirm" type="password" name="confirm" required minlength="8" />
                            </div>
                            <input type="submit" class="btn btn-secondary" value="Register" />
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>
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
            sleep(1);
            log_in();
        } catch (Exception $e) {
            /* flash("There was a problem registering");
            flash("<pre>" . var_export($e, true) . "</pre>");*/
            users_check_duplicate($e->errorInfo);
        }
    }
}
?>
<?php
require(__DIR__ . "/../../partials/footer.php");
require(__DIR__ . "/../../partials/flash.php");
?>