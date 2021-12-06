<?php
require_once(__DIR__ . "/../../../lib/functions.php");
session_start();

$response = ["message" => "No Points Saved"];
http_response_code(400);
$contentType = $_SERVER["CONTENT_TYPE"];

if ($contentType === "application/json") {
    $json = file_get_contents('php://input');
    $points = json_decode($json, true)["point"];
}

if (isset($points)) {
    $reject = false;
    $user_id = get_user_id();
    if ($user_id <= 0) {
        $reject = true;
        error_log("User not logged in");
        http_response_code(403);
        $response["message"] = "You must be logged in";
        flash($response["message"], "warning");
    }
    if (!$reject) {
        $points = (int)se($points, "points", 0, false);
        http_response_code(200);
        save_points($user_id, $points);
        update_points($user_id);
        error_log("Points of $points saved successfully for $user_id");
        $response["message"] = "Points saved";
    }
}
echo json_encode($response);
