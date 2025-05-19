<script>
  import { onMount } from "svelte";

  //spelplan
  let blockSize = 30;
  let rows = 15;
  let cols = 15;
  let board;
  let context;
  //ormens huvud
  let snakeX = blockSize * 5;
  let snakeY = blockSize * 5;

  // Bashastigheter
  let velocityX = 0;
  let velocityY = 0;

  // Array för att spara positionen av ormen
  let snakeBody = [];

  //matens positionsvariabler
  let foodX;
  let foodY;

  //bilder
  let snakeHead;
  let foodImage;
  let snakeBodyImage;

  //boolean för att kolla om spelet är över
  let gameOver = false;

  //variabel för att vrida huvudet
  let rotationVinkel = 0;

  //variabel för att kolla om du har ändrat position redan på samma ruta
  let directionChanged = false;

  // Variabler för requestAnimationFrame timing
  let lastTime = 0;
  let frameInterval = 1000 / 6; // Samma som setInterval timing (6 FPS)
  let accumulator = 0;

  let highscore = $state();
  let gamescore = $state(0);

  // Function to change direction
  function changeDirection(e) {
    if (directionChanged) return; //hindrar att kunna ändra håll på samma ruta

    if ((e.code === "ArrowUp" || e.code === "KeyW") && velocityY !== 1) {
      velocityX = 0;
      velocityY = -1;
      rotationVinkel = 0;
      directionChanged = true;
    } else if (
      (e.code === "ArrowDown" || e.code === "KeyS") &&
      velocityY !== -1
    ) {
      velocityX = 0;
      velocityY = 1;
      rotationVinkel = 180;
      directionChanged = true;
    } else if (
      (e.code === "ArrowLeft" || e.code === "KeyA") &&
      velocityX !== 1
    ) {
      velocityX = -1;
      velocityY = 0;
      rotationVinkel = 270;
      directionChanged = true;
    } else if (
      (e.code === "ArrowRight" || e.code === "KeyD") &&
      velocityX !== -1
    ) {
      velocityX = 1;
      velocityY = 0;
      rotationVinkel = 90;
      directionChanged = true;
    }
  }

  function loadimages() {
    snakeHead = new Image();
    foodImage = new Image();
    snakeBodyImage = new Image();
    snakeHead.src = "/head.png";
    foodImage.src = "/IdasApple.png";
    snakeBodyImage.src = "/Sbody.png";
  }

  onMount(async () => {
    // Make onMount async
    // Variabel till spelplanen
    try {
      highscore = await fetchHighscore(); // Await the promise
    } catch (error) {
      console.error("Failed to fetch highscore:", error);
      highscore = 0; // Set a default value on error
    }

    context = board.getContext("2d");

    //lägger in maten
    placeFood();

    // Initialize the game with a blank board until images load
    rensaBoard();
    renderGrid();
    loadimages();

    // Note: No need to add event listener here since you're using <svelte:window>

    requestAnimationFrame(gameLoop);
    return () => {
      // Any cleanup needed when component is destroyed
    };
  });

  // Define other functions here
  function placeFood() {
    let validPosition = false;
    while (!validPosition) {
      foodX = Math.floor(Math.random() * cols) * blockSize;
      foodY = Math.floor(Math.random() * rows) * blockSize;
      validPosition = true;
      for (let i = 0; i < snakeBody.length; i++) {
        if (foodX === snakeBody[i][0] && foodY === snakeBody[i][1]) {
          validPosition = false;
          break;
        }
      }
    }
  }

  function gameLoop(timestamp) {
    if (!lastTime) lastTime = timestamp;
    const deltaTime = timestamp - lastTime;
    lastTime = timestamp;
    accumulator += deltaTime;

    if (accumulator >= frameInterval) {
      update();
      accumulator -= frameInterval;
    }

    requestAnimationFrame(gameLoop);
  }

  function update() {
    if (gameOver) return;

    rensaBoard();
    context.drawImage(foodImage, foodX, foodY, blockSize, blockSize);
    renderGrid();
    checkFood();
    flyttaOrm();
    updateraOrmPos();
    ritaOrm();
    kollaGameOver();
    directionChanged = false; // Återställer riktningsändringsflaggan
  }

  function rensaBoard() {
    context.fillStyle = "#588157";
    context.fillRect(0, 0, board.width, board.height);
  }

  function renderGrid() {
    const xMax = board.width;
    const yMax = board.height;
    context.beginPath();
    context.strokeStyle = "#3A5A40";
    for (let x = 0; x <= xMax; x += blockSize) {
      context.moveTo(x, 0);
      context.lineTo(x, yMax);
    }
    for (let y = 0; y <= yMax; y += blockSize) {
      context.moveTo(0, y);
      context.lineTo(xMax, y);
    }
    context.stroke();
  }

  function checkFood() {
    if (snakeX === foodX && snakeY === foodY) {
      snakeBody.push([foodX, foodY]);
      gamescore++;
      placeFood();
    }
  }

  function flyttaOrm() {
    for (let i = snakeBody.length - 1; i > 0; i--) {
      snakeBody[i] = snakeBody[i - 1];
    }
    if (snakeBody.length) {
      snakeBody[0] = [snakeX, snakeY];
    }
  }

  function updateraOrmPos() {
    snakeX += velocityX * blockSize;
    snakeY += velocityY * blockSize;
  }

  function ritaOrm() {
    context.save();
    context.translate(snakeX + blockSize / 2, snakeY + blockSize / 2);
    context.rotate((rotationVinkel * Math.PI) / 180);
    context.drawImage(
      snakeHead,
      -blockSize / 2,
      -blockSize / 2,
      blockSize,
      blockSize
    );
    context.restore();

    for (let i = 0; i < snakeBody.length; i++) {
      context.drawImage(
        snakeBodyImage,
        snakeBody[i][0],
        snakeBody[i][1],
        blockSize,
        blockSize
      );
    }
  }

  function kollaGameOver() {
    if (
      snakeX < 0 ||
      snakeX >= cols * blockSize ||
      snakeY < 0 ||
      snakeY >= rows * blockSize
    ) {
      gameOver = true;
      if (gamescore > highscore) {
        highscore = gamescore;
      }
      highscoreupdate();
      alert("Game Over");
      restart();
    }
    for (let i = 0; i < snakeBody.length; i++) {
      if (snakeX === snakeBody[i][0] && snakeY === snakeBody[i][1]) {
        gameOver = true;
        if (gamescore > highscore) {
          highscore = gamescore;
        }
        highscoreupdate();
        alert("Game Over");
        restart();
      }
    }
  }

  function restart() {
    snakeX = blockSize * 5;
    snakeY = blockSize * 5;
    velocityX = 0;
    velocityY = 0;
    snakeBody = [];
    gameOver = false;
    placeFood();
    gamescore = 0; // Corrected: Direct assignment for Svelte 5 rune
  }

  async function fetchHighscore() {
    const response = await fetch("/api/getHighscore.php");
    const result = await response.json();

    return result;
  }

  async function highscoreupdate() {
    const response = await fetch("/api/setHighscore.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        highscore: gamescore,
      }),
    });
    const result = await response.json();
    return result;
  }
</script>

<svelte:window on:keyup={changeDirection} />

<canvas id="board" width="450" height="450" bind:this={board} class="game-board">
  Din webbläsare stödjer inte HTML5 canvas tag.
</canvas>
<section id="scores">
  <p>Score: {gamescore}</p>
  <p>AvgScore:</p>
  <h1>Highscore: {highscore}</h1>
</section>

<style>
  .game-board {
    background: #588157;
    border: 3px solid #3a5a40;
    border-radius: 10px;
    box-shadow: 2px 2px 8px #3a5a40;
    margin: 0 auto;
    display: block;
  }
</style>
