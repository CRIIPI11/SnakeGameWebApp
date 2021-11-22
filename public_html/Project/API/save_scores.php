<?php
//remember, API endpoints should only echo/output precisely what you want returned
//any other unexpected characters can break the handling of the response
$response = ["message" => "There was a problem saving your score"];
http_response_code(400);
$contentType = $_SERVER["CONTENT_TYPE"];

if ($contentType === "application/json") {
    $json = file_get_contents('php://input');
    $score = json_decode($json, true)["score"];
}

error_log(var_export($score, true));
if (isset($score["score"])) {
    session_start();
    $reject = false;

    require_once(__DIR__ . "/../../../lib/functions.php");
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
    }
}
echo json_encode($response);
