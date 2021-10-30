<?php
session_start();

//don't require flash.php, this will cause messages
//to not appear on login and be hidden by the logout transition
require(__DIR__ . "/../../lib/functions.php");

reset_session();

flash("Successfully logged out", "success");
header("Location: login.php");
