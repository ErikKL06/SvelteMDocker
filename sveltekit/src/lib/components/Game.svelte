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

  //laddar in basvärden för poäng och startar async funktion till api
</script>

<canvas id="board" width="450rem" height="450rem">
  Din webbläsare stödjer inte HTML5 canvas tag.
</canvas>
<section id="scores">
  <p>Score: {gamescore}</p>
  <p>AvgScore:</p>
  <h1>Highscore: {UserHighscore.value}</h1>
</section>
