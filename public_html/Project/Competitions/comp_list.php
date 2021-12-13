<?php
require_once(__DIR__ . "/../../../partials/nav.php");
require_once(__DIR__ . "/../../../partials/flash.php");

is_logged_in(true);

if (isset($_POST["join"])) {
    $user_id = get_user_id();
    $comp_id = se($_POST, "comp_id", 0, false);
    join_competition($comp_id, $user_id);
}

$db = getDB();
$query = "SELECT id, name, expires, current_reward, join_fee, current_participants, min_participants, paid_out, min_score, first_place_per, second_place_per, third_place_per from Competitions WHERE paid_out <= 0 AND expires > current_timestamp() ORDER BY expires asc LIMIT 10";
$stmt = $db->prepare($query);
$data = [];
try {
    $stmt->execute();
    $d = $stmt->fetchAll();
    if ($d) {
        $data = $d;
    }
} catch (PDOException $e) {
    flash("erro", "danger");
    error_log("List competitions error: " . var_export($e, true));
}

require(__DIR__ . "/../../../partials/flash.php");
?>

<div class="container-fluid">
    <h1>Active Competitions</h1>
    <table class="table text-light">
        <thead>
            <th>Name</th>
            <th>Participants</th>
            <th>Reward</th>
            <th>Min Score</th>
            <th>Expires</th>
            <th>Join Fee</th>
        </thead>
        <tbody>
            <?php if (count($data) > 0) : ?>
                <?php foreach ($data as $row) : ?>
                    <tr>
                        <td><?php se($row, "name"); ?></td>
                        <td><?php se($row, "current_participants"); ?><br>(min: <?php se($row, "min_participants"); ?>)</td>
                        <td><?php se($row, "current_reward"); ?><br>Payout: <?php se($row, "paid_out", "-"); ?></td>
                        <td><?php se($row, "min_score"); ?></td>
                        <td><?php se($row, "expires", "-"); ?></td>
                        <td><?php se($row, "join_fee") ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="comp_id" value="<?php se($row, "id"); ?>" />
                                <input type="submit" name="join" class="btn btn-primary" value="Join" />
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php else : ?>
                <tr>
                    <td colspan="100%">No active competitions</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
</div>