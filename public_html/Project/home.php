<?php
require(__DIR__ . "/../../partials/nav.php");
?>
<div class="mb-3">
    <h1 class="fw-bold mb-2 text-uppercase">Home</h1>
</div>
<?php
if (is_logged_in()) {

    //echo "Welcome home, " . get_username();
    //comment this out if you don't want to see the session variables
    //echo "<pre>" . var_export($_SESSION, true) . "</pre>";
}
?>

<div class="row align-items-start">
    <div class="col">
        <?php $scoresw = get_top_week(); ?>
        <div class="w-25 p-3">

            <div class="container">
                <div class="row">
                    <div class="span5">
                        <h3>Top Week Scores</h3>
                        <table class="table table-success">
                            <thead>
                                <th>Username</th>
                                <th>Score</th>
                                <th>Time</th>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($scoresw as $score) : ?>
                                    <tr>
                                        <td><a href="<?php echo get_url("profile.php?id=");
                                                        se($score, "user_id"); ?>"><?php se($score, "username"); ?></a></td>
                                        <td><?php se($score, "score", 0); ?></td>
                                        <td><?php se($score, "created", "-"); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="col">
        <?php $scoresm = get_top_month(); ?>

        <div class="w-25 p-3">
            <div class="container">
                <div class="row">
                    <div class="span5">
                        <h3>Top Month Scores</h3>
                        <table class="table table-success">
                            <thead>
                                <th>Username</th>
                                <th>Score</th>
                                <th>Time</th>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($scoresm as $score) : ?>
                                    <tr>
                                        <td><a href="<?php echo get_url("profile.php?id=");
                                                        se($score, "user_id"); ?>"><?php se($score, "username"); ?></a></td>
                                        <td><?php se($score, "score", 0); ?></td>
                                        <td><?php se($score, "created", "-"); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="col">
        <?php $scoresl = get_top_lifetime(); ?>
        <div class="w-25 p-3">
            <div class="container">
                <div class="row">
                    <div class="span5">
                        <h3>Lifetime Scores</h3>
                        <table class="table table-success">
                            <thead>
                                <th>Username</th>
                                <th>Score</th>
                                <th>Time</th>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($scoresl as $score) : ?>
                                    <tr>
                                        <td><a href="<?php echo get_url("profile.php?id=");
                                                        se($score, "user_id"); ?>"><?php se($score, "username"); ?></a></td>
                                        <td><?php se($score, "score", 0); ?></td>
                                        <td><?php se($score, "created", "-"); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>


<style>
    h3 {
        text-decoration: underline;
    }
</style>
<?php
require(__DIR__ . "/../../partials/flash.php");
?>