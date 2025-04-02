<script>
  import Game from "$lib/components/Game.svelte";
  import Highscore from "$lib/components/Highscore.svelte";

  let { data } = $props();
</script>

<section id="game-container">
  <Game />
</section>

<section id="highscore">
  <table id="highscoreTable">
    <thead>
      <tr>
        <th>Username</th>
        <th>Score</th>
      </tr>
    </thead>
    <tbody>
      {#each data.list as userData}
        <Highscore HighscoresData={userData} />
      {/each}
    </tbody>
  </table>
  <section id="scores">
    <p>Score:</p>
    <p>AvgScore</p>
    <h1>Highscore:</h1>
  </section>
</section>
<section id="loginStatus">
  <p id="userStatus">Gäst</p>
</section>
