<script>
  import Highscore from "$lib/components/Highscore.svelte";
  async function getAllHighscores() {
    const url = "http://localhost/api/getAllHighscores.php";

    const response = await fetch(url);

    const list = await response.json();
    return { list };
  }
  let highscores = getAllHighscores();
</script>

<section id="highscore">
  <table id="highscoreTable">
    <thead>
      <tr>
        <th>Username</th>
        <th>Score</th>
      </tr>
    </thead>
    <tbody>
      {#await highscores then highscoreList}
        {#each highscoreList.list as userData}
          <Highscore HighscoresData={userData} />
        {/each}
      {/await}
    </tbody>
  </table>
</section>
<section id="loginStatus">
  <p id="userStatus">Gäst</p>
</section>
