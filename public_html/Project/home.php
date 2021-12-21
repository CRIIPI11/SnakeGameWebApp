<?php
require(__DIR__ . "/../../partials/nav.php");
?>

<h1>Home</h1>
<?php
if (is_logged_in()) {

    echo "Welcome home, " . get_username();
    //comment this out if you don't want to see the session variables
    //echo "<pre>" . var_export($_SESSION, true) . "</pre>";
}
?>

<div>
    <?php $scoresw = get_top_week(); ?>
    <h3>Top Week Scores</h3>
    <table class="table text-light">
        <thead>
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

<div>
    <?php $scoresm = get_top_month(); ?>
    <h3>Top Month Scores</h3>
    <table class="table text-light">
        <thead>
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

<div>
    <?php $scoresl = get_top_lifetime(); ?>
    <h3>Lifetime Scores</h3>
    <table class="table text-light">
        <thead>
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


<?php
require(__DIR__ . "/../../partials/flash.php");
?>