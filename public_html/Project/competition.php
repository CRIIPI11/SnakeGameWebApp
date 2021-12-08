<?php
require_once(__DIR__ . "/../../partials/nav.php");
is_logged_in(true);
$user_id = get_user_id();

if (isset($_POST["name"]) && !empty($_POST["name"])) {
    $name = se($_POST, "name", "N/A", false);
    $SR = (int)se($_POST, "starting_reward", "1", false);
    $ms = (int)se($_POST, "min_score", "1", false);
    $mp = (int)se($_POST, "min_particpitants", "4", false);
    $jf = (int)se($_POST, "join_fee", "1", false);
    $duration = (int)se($_POST, "duration", "5", false);
    $first = (int)se($_POST, "first_place_per", "70", false);
    $second = (int)se($_POST, "second_place_per", "20", false);
    $third = (int)se($_POST, "third_place_per", "10", false);
    $cost = (int)se($_POST, "starting_reward", 0, false);
    $cost++;
    $cost += (int)se($_POST, "join_cost", 0, false);

    if ($cost > get_points()) {
        $db = getDB();
        $db->beginTransaction();
        if (save_points($user_id, -$cost, "created competition")) {
            $query = "INSERT INTO Competitions(name, duration, starting_reward, join_fee, min_participants, min_score, first_place_per, second_place_per, third_place_per, cost_to_create) VALUES(:name, :duration, :startingr, :joinfee, :mp, :ms, :fp, :sp, :tp, :cost)";

            $comp_id = $db->lastInsertId();
            if ($comp_id > 0) {
                flash("competition created", "success");
                $db->commit();
            } else {
                $db->rollback();
            }
        } else {
            flash("There was a problem deducting points", "warning");
            $db->rollback();
        }
    } else {
        flash("no points", "warning");
    }
}

?>

<div class="container-fluid">
    <h1>Create Competition</h1>
    <form method="POST">
        <div class="mb-3">
            <label for="name" class="form-label">Competition Name</label>
            <input id="name" name="name" />
        </div>
        <div class="mb-3">
            <label for="Sreward" class="form-label">Starting Reward</label>
            <input id="Sreward" type="number" name="starting_reward" oninput="updateCost()" min="1" />
        </div>
        <div class="mb-3">
            <label for="ms" class="form-label">Min. Score</label>
            <input id="ms" name="min_score" type="number" min="1" />
        </div>
        <div class="mb-3">
            <label for="mp" class="form-label">Min. Participants</label>
            <input id="mp" name="min_participants" type="number" min="3" />
        </div>
        <div class="mb-3">
            <label for="jc" class="form-label">Join Fee</label>
            <input id="jc" name="join_fee" type="number" oninput="updateCost()" min="0" />
        </div>
        <div class="mb-3">
            <label for="duration" class="form-label">Duration (in Days)</label>
            <input id="duration" name="duration" type="number" min="3" />
        </div>
        <div class="mb-3">
            <label for="po1" class="form-label">Frist PLace (%)</label>
            <input id="po1" name="first_place_per" type="number">
        </div>
        <div class="mb-3">
            <label for="po2" class="form-label">Second Place (%)</label>
            <input id="po" name="second_place_per" type="number">
        </div>
        <div class="mb-3">
            <label for="po3" class="form-label">Third Place (%)</label>
            <input id="po3" name="third_place_per" type="number">
        </div>
        <div class="mb-3">
            <input type="submit" value="Create Competition (Cost: 2)" class="btn btn-primary" />
        </div>
    </form>
    <!--updates number on button-->
    <script>
        function updateCost() {
            let starting = parseInt(document.getElementById("Sreward").value || 0) + 1;
            let join = parseInt(document.getElementById("jc").value || 0);
            if (join < 0) {
                join = 1;
            }
            let cost = starting + join;
            document.querySelector("[type=submit]").value = `Create Competition (Cost: ${cost})`;
        }
    </script>
</div>