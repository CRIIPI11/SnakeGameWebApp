<?php
require_once(__DIR__ . "/../../../partials/nav.php");
require_once(__DIR__ . "/../../../partials/flash.php");

is_logged_in(true);
$db = getDB();
$edit = !!se($_GET, "edit", false, false);

if (isset($_POST["join"])) {
    $user_id = get_user_id();
    $comp_id = se($_POST, "comp_id", 0, false);
    join_competition($comp_id, $user_id);
}

if (isset($_POST["edit"])) {
    $comp_id = se($_POST, "comp_id", 0, false);
    $name = se($_POST, "name", "N/A", false);
    $reward = (int)se($_POST, "reward", null, false);
    $score = (int)se($_POST, "minscore", null, false);
    $mp = (int)se($_POST, "minpart", null, false);
    $fee = (int)se($_POST, "fee", null, false);
    $first = (int)se($_POST, "firstp", null, false);
    $second = (int)se($_POST, "secondp", null, false);
    $third = (int)se($_POST, "thirdp", null, false);
    $query = "UPDATE Competitions set name = :n, current_reward = :cr, join_fee = :jf, min_participants = :mp, min_score = :ms, first_place_per = :fp, second_place_per = :sp, third_place_per = :tp where id=:cid";
    $stmt = $db->prepare($query);
    try {
        $stmt->execute([":n" => $name, ":cr" => $reward, ":jf" => $fee, ":mp" => $mp, ":ms" => $score, ":fp" => $first, ":sp" => $second, ":tp" => $third, ":cid" => $comp_id]);
        flash("Competition Updated", "success");
    } catch (PDOException $e) {

        error_log("List competitions error: " . var_export($e, true));
    }
}
$per_page = 5;
paginate("SELECT count(1) as total FROM Competitions WHERE expires > current_timestamp() AND pay_out < 1");

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
                        <td><?php se($row, "join_fee"); ?></td>
                        <td>
                            <form method="POST">
                                <input type="hidden" name="comp_id" value="<?php se($row, "id"); ?>" />
                                <input type="submit" name="join" class="btn btn-primary" value="Join" />
                            </form>
                        </td>
                        <?php if (has_role("Admin")) : ?>
                            <td>
                                <a class="btn btn-primary" href="?edit=true">Edit</a>
                            </td>
                        <?php endif; ?>
                        <td>
                            <a class="btn btn-secondary" href="view_competition.php?id=<?php se($row, 'id'); ?>">View</a>
                        </td>
                    </tr>
                <?php endforeach; ?>

                <?php if ($edit) : ?>
                    <form method="POST" onsubmit="return validate(this);">
                        <div class="mb-3">
                            <label class="form-label" for="name">Name</label>
                            <input class="form-control" type="name" name="name" id="name" value="<?php se($row, "name"); ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="minpart">Min. Participants</label>
                            <input class="form-control" type="text" name="minpart" id="minpart" value="<?php se($row, "min_participants"); ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="reward">Reward</label>
                            <input class="form-control" type="text" name="reward" id="reward" value="<?php se($row, "current_reward"); ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="minscore">Min. Score</label>
                            <input class="form-control" type="text" name="minscore" id="minscore" value="<?php se($row, "min_score"); ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="fee">Join Fee</label>
                            <input class="form-control" type="text" name="fee" id="fee" value="<?php se($row, "join_fee") ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="firstp">First Place (%)</label>
                            <input class="form-control" type="text" name="firstp" id="firstp" value="<?php se($row, "first_place_per") ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="secondp">Second Place (%)</label>
                            <input class="form-control" type="text" name="secondp" id="secondp" value="<?php se($row, "second_place_per") ?>" />
                        </div>
                        <div class="mb-3">
                            <label class="form-label" for="thirdp">Third Place (%)</label>
                            <input class="form-control" type="text" name="thirdp" id="thirdp" value="<?php se($row, "third_place_per") ?>" />
                        </div>
                        <div>
                            <input type="hidden" name="comp_id" value="<?php se($row, "id"); ?>" />
                            <input type="submit" name="edit" class="btn btn-primary" value="Edit" />
                            <a class="btn btn-primary" href="?">Cancel</a>
                        </div>
                    </form>
                <?php endif; ?>
            <?php else : ?>
                <tr>
                    <td colspan="100%">No active competitions</td>
                </tr>
            <?php endif; ?>
        </tbody>
    </table>
    <?php include(__DIR__ . "/../../../partials/pagination.php"); ?>
</div>