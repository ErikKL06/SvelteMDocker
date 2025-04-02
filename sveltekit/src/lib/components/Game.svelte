<script>
  import { onMount } from "svelte";
  import { gamescore } from "/src/lib/stores/gamescore.svelte.js";
  import { UserHighscore } from "/src/lib/stores/UserHighscore.svelte.js";

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

  //boolean för att kolla om spelet är över
  let gameOver = false;

  //variabel för att kolla vem som är inloggad
  let userLoggedIn = "";

  //variabel för att vrida huvudet
  let rotationVinkel = 0;

  // Variabler för requestAnimationFrame timing
  let lastTime = 0;
  let frameInterval = 1000 / 6; // Samma som setInterval timing (6 FPS)
  let accumulator = 0;

  // Function to change direction
  function changeDirection(e) {
    if ((e.code === "ArrowUp" || e.code === "KeyW") && velocityY !== 1) {
      velocityX = 0;
      velocityY = -1;
      rotationVinkel = 0;
    } else if (
      (e.code === "ArrowDown" || e.code === "KeyS") &&
      velocityY !== -1
    ) {
      velocityX = 0;
      velocityY = 1;
      rotationVinkel = 180;
    } else if (
      (e.code === "ArrowLeft" || e.code === "KeyA") &&
      velocityX !== 1
    ) {
      velocityX = -1;
      velocityY = 0;
      rotationVinkel = 270;
    } else if (
      (e.code === "ArrowRight" || e.code === "KeyD") &&
      velocityX !== -1
    ) {
      velocityX = 1;
      velocityY = 0;
      rotationVinkel = 90;
    }
  }

  function loadimages() {
    snakeHead.src = "head.png";
    foodImage.src = "IdasApple.png";
    snakeBodyImage.src = "Sbody.png";
  }

  onMount(() => {
    snakeHead = new Image();
    foodImage = new Image();
    snakeBodyImage = new Image();
    // Variabel till spelplanen

    context = board.getContext("2d");

    getUsername();
    fetchAllHighscores();

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

  function getUsername() {
    // Logic to get username
    console.log("Username fetched");
  }

  function fetchAllHighscores() {
    // Logic to fetch highscores
    console.log("Highscores fetched");
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
      gamescore.value++;
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
      alert("Game Over");
      restart();
    }
    for (let i = 0; i < snakeBody.length; i++) {
      if (snakeX === snakeBody[i][0] && snakeY === snakeBody[i][1]) {
        gameOver = true;
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
    gamescore.value = 0;
  }
</script>

<svelte:window on:keyup={changeDirection} />

<canvas id="board" width="450" height="450" bind:this={board}>
  Din webbläsare stödjer inte HTML5 canvas tag.
</canvas>
<section id="scores">
  <p>Score: {gamescore.value}</p>
  <p>AvgScore:</p>
  <h1>Highscore: {UserHighscore.value}</h1>
</section>
