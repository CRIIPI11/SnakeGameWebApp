<?php
require_once(__DIR__ . "/../../../partials/nav.php");
is_logged_in(true);
$db = getDB();

$id = se($_GET, "id", -1, false);
if ($id < 1) {
    flash("Invalid competition", "danger");
}

$stmt = $db->prepare("SELECT Users.id, username from Users join CompetitionParticipants on Users.id = CompetitionParticipants.user_id where CompetitionParticipants.comp_id = :cid");

try {
    $stmt->execute([":cid" => $id]);
    $r = $stmt->fetch();
    if ($r) {
        $row = $r;
    }
} catch (PDOException $e) {
    flash("There was a problem fetching competitions, please try again later", "danger");
    error_log("List competitions error: " . var_export($e, true));
}
$scores = top_comp_scores($id);
?>
<div class="container-fluid">
    <div>
        <h1>Competition Info</h1>
        <div>
            <table class="table text-light">
                <thead>
                    <th>Participants</th>
                </thead>
                <tbody>
                    <?php if (count($row) > 0) : ?>
                        <tr>
                            <td><a href="<?php echo get_url("profile.php?id=");
                                            se($row, "id"); ?>"><?php se($row, "username"); ?></a></td>
                        </tr>
                    <?php else : ?>
                        <tr>
                            <td colspan="100%">No Current Participants</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
        <div>
            <table class="table text-light">
                <thead>
                    <th>Top Scores</th>
                </thead>
                <tbody>
                    <?php if (count($scores) > 0) : ?>
                        <?php foreach ($scores as $score) : ?>
                            <tr>
                                <td><?php se($score, "id", ""); ?></td>
                                <td><?php se($score, "score", ""); ?></td>
                            </tr>
                        <?php endforeach; ?>
                    <?php else : ?>
                        <tr>
                            <td colspan="100%">No Current Scores</td>
                        </tr>
                    <?php endif; ?>
                </tbody>
            </table>
        </div>
    </div>
    <div class="mb-3">
        <a class="btn btn-primary" href="comp_list.php">Back</a>
    </div>
</div>