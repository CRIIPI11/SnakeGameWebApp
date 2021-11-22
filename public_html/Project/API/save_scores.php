<?php
require_once(__DIR__ . "/../../../lib/functions.php");
session_start();

$response = ["message" => "There was a problem saving your score"];
http_response_code(400);
$contentType = $_SERVER["CONTENT_TYPE"];
error_log($contentType);

if ($contentType === "application/json") {
    $json = file_get_contents('php://input');
    $score = json_decode($json, true)["score"];
    error_log(var_export($json, true));
    error_log($score);
}

if (isset($score)) {
    $reject = false;
    $user_id = get_user_id();
    if ($user_id <= 0) {
        $reject = true;
        error_log("User not logged in");
        http_response_code(403);
        $response["message"] = "You must be logged in to save your score";
        flash($response["message"], "warning");
    }
    if (!$reject) {
        $scores = (int)se($score, "score", 0, false);
        http_response_code(200);
        save_score($user_id, $scores, true);
        error_log("Score of $score saved successfully for $user_id");
        $response["message"] = "score saved";
    }
}
echo json_encode($response);
