<?php
require(__DIR__ . "/../../../partials/nav.php"); ?>

<link rel="stylesheet" href="Gstyles.css">
<h1>Snake Game</h1>
<canvas id="table" width="400px" height="400px"> </canvas>
<script>
    const canvas = document.getElementById("table");
    const context = canvas.getContext("2d");

    class SnakePart {
        constructor(x, y) {
            this.x = x;
            this.y = y;
        }
    }

    let speed = 7;

    let titleCount = 20;
    let titleSize = canvas.width / titleCount - 2;
    let headX = 10;
    let headY = 10;
    const snakeParts = [];
    let taillength = 2;

    let appleX = 5;
    let appleY = 5;

    let xVelocity = 0;
    let yvelocity = 0;

    let score = 0;
    let points = 0;

    function erase() {
        context.fillStyle = 'black';
        context.fillRect(0, 0, canvas.width, canvas.height);
    }

    function Snake() {

        context.fillStyle = 'orange';
        for (let i = 0; i < snakeParts.length; i++) {
            let part = snakeParts[i];
            context.fillRect(part.x * titleCount, part.y * titleCount, titleSize, titleSize);
        }

        snakeParts.push(new SnakePart(headX, headY));
        if (snakeParts.length > taillength) {
            snakeParts.shift();
        }

        context.fillStyle = 'green';
        context.fillRect(headX * titleCount, headY * titleCount, titleSize, titleSize);
    }

    function Apple() {
        context.fillStyle = 'red';
        context.fillRect(appleX * titleCount, appleY * titleCount, titleSize, titleSize);

    }

    function collision() {
        if (appleX === headX && appleY == headY) {
            appleX = Math.floor(Math.random() * titleCount);
            appleY = Math.floor(Math.random() * titleCount);
            taillength++;
            score++;

            if (score > 0 && score % 20 == 0) {
                points++;
            }
        }
    }

    function changeposition() {
        headX = headX + xVelocity;
        headY = headY + yvelocity;
    }

    function dScore() {
        context.fillStyle = "white";
        context.font = "15px Verdana";
        context.fillText("Score: " + score, canvas.width - 80, 15);
    }

    function gameover() {
        let gameOver = false;

        if (yvelocity === 0 && xVelocity === 0) {
            return false;
        }

        //walls
        if (headX < 0) {
            gameOver = true;
        } else if (headX >= titleCount) {
            gameOver = true;
        } else if (headY < 0) {
            gameOver = true;
        } else if (headY >= titleCount) {
            gameOver = true;
        }

        for (let i = 0; i < snakeParts.length; i++) {
            let part = snakeParts[i];
            if (part.x === headX && part.y === headY) {
                gameOver = true;
                break;
            }
        }

        if (gameOver) {
            context.fillStyle = 'white';
            context.font = '50px Verdana'
            context.fillText("Game Over!", canvas.width / 6.5, canvas.height / 2);
            console.log(score);
        }

        return gameOver;
    }

    function sscore() {

        fetch("../API/save_scores.php", {
            method: "POST",
            headers: {
                "Content-type": "application/json"
            },
            body: JSON.stringify({
                "score": score
            })
        }).then(async res => {
            let score = await res.json();
        })
    }

    function spoints() {

        fetch("../API/save_points.php", {
            method: "POST",
            headers: {
                "Content-type": "application/json"
            },
            body: JSON.stringify({
                "point": points
            })
        }).then(async res => {
            let score = await res.json();
        })

    }

    function Draw() {

        changeposition();

        if (gameover()) {
            console.log(score);
            sscore();
            spoints();
            return;
        }
        erase();
        collision();
        Apple();
        Snake();
        dScore();

        if (score > 2) {
            speed = 11;
        }
        setTimeout(Draw, 1000 / speed)
    }

    document.body.addEventListener('keydown', keyDown);

    function keyDown(event) {
        if (event.keyCode === 40) {
            //Down
            if (yvelocity == -1)
                return;
            yvelocity = 1;
            xVelocity = 0;
        }
        if (event.keyCode === 38) {
            //Up
            if (yvelocity == 1)
                return;
            yvelocity = -1;
            xVelocity = 0;
        }
        if (event.keyCode === 37) {
            // LEFT
            if (xVelocity == 1)
                return;
            yvelocity = 0;
            xVelocity = -1;
        }
        if (event.keyCode === 39) {
            // RIGHT
            if (xVelocity == -1)
                return;
            yvelocity = 0;
            xVelocity = 1;
        }
    }

    Draw();
</script>