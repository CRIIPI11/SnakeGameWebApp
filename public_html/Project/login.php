<?php
require(__DIR__ . "/../../partials/nav.php"); ?>
<div class="container h-100">
    <div class="row d-flex justify-content-center align-items-center h-100">
        <div class="col-12 col-md-9 col-lg-7 col-xl-6">
            <div class="card bg-dark text-white" style="border-radius: 1rem;">
                <div class="card-body p-5">
                    <h1 class="fw-bold mb-2 text-uppercase">Login</h1>
                    <div class="mb-md-5 mt-md-4 pb-5">
                        <form onsubmit="return validate(this)" method="POST">
                            <div class="form-outline form-white mb-4">
                                <input class="form-control form-control-lg" placeholder="Username/Email" type="text" id="email" name="email" required />
                            </div>
                            <div class="form-outline form-white mb-4">
                                <input class="form-control form-control-lg" placeholder="Password" type="password" id="pw" name="password" required minlength="8" />
                            </div>
                            <input type="submit" class="btn btn-light" value="Login" />
                        </form>
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
    if (is_logged_in()) {
        die(header("Location: home.php"));
    }

    log_in();

    ?>
    <?php
    require(__DIR__ . "/../../partials/footer.php");
    require(__DIR__ . "/../../partials/flash.php");
    ?>