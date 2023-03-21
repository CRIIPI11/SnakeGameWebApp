<?php
require(__DIR__ . "/../../partials/nav.php");

?>
<div class="container">
    <div class="row justify-content-center">
        <div class="col-6">
            <h1 class="fw-bold mb-2 text-uppercase" id="title">The Snake Game</h1>
        </div>
    </div>
</div>
<?php
if (is_logged_in()) {

    //echo "Welcome home, " . get_username();
    //comment this out if you don't want to see the session variables
    //echo "<pre>" . var_export($_SESSION, true) . "</pre>";
}

?>

<div class="container-fluid">

    <div class="row">
        <div class="col-sm-3 ">
            <?php
            $user_id = se($_GET, "id", get_user_id(), false);
            if (is_logged_in()) : ?>
                <?php $scores = get_user_scores($user_id, 20); ?>
                <div class="card bg-secondary m-5">
                    <div class="card-header">
                        <h3 class="tabletitle">Score History</h3>
                    </div>
                    <div class="panel-body table-responsive" style="max-height:500px;">
                        <table class="table table-dark table-striped table-bordered">
                            <thead>
                                <th>Score</th>
                                <th>Time</th>
                            </thead>
                            <tbody>
                                <?php
                                foreach ($scores as $score) : ?>
                                    <tr>
                                        <td><?php se($score, "score", 0); ?></td>
                                        <td><?php se($score, "created", "-"); ?></td>
                                    </tr>
                                <?php endforeach; ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            <?php endif; ?>
        </div>
        <div class="col-sm-6">
            <div class="row">
                <div class="col-sm"></div>
                <div class="col-sm"><?php require(__DIR__ . "/Game/game.html"); ?></div>
                <div class="col-sm"></div>
            </div>
        </div>

        <div class="col">
            <div class="row m-2">
                <div class="col">
                    <?php $scoresm = get_top_month(); ?>
                    <div class="card bg-secondary mb-3">
                        <div class="card-header">
                            <h3 class="tabletitle">Top Month Scores</h3>
                        </div>
                        <div class="panel-body table-responsive">
                            <table class="table table-dark table-striped">
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
                                                            se($score, "user_id"); ?>" class="text-light "><?php se($score, "username"); ?></a></td>
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
            <div class="row m-2">
                <div class="col">
                    <?php $scoresl = get_top_lifetime(); ?>

                    <div class="card bg-secondary mb-3">
                        <div class="card-header">
                            <h3 class="tabletitle">Lifetime Scores</h3>
                        </div>
                        <div class="panel-body table-responsive">
                            <table class="table table-dark table-striped">
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
                                                            se($score, "user_id"); ?>" class="text-light "><?php se($score, "username"); ?></a></td>
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
</div>


<?php
require(__DIR__ . "/../../partials/flash.php");
require(__DIR__ . "/../../partials/footer.php");
?>