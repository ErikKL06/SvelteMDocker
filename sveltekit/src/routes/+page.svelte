<script>
  import Game from "$lib/components/Game.svelte";
  import Highscore from "$lib/components/Highscore.svelte";

  let currentUser = $state(getUser());
  async function highscores() {
    // If PHP is on the host machine, use host.docker.internal
    const url = "/api/getAllHighscores.php";
    // Alternative: If PHP is in another container, use the container name
    //const url = "http://php-container/api/getAllHighscores.php";

    const response = await fetch(url);

    return await response.json();
  }

  async function getUser() {
    const url = "/api/currentUserAPI.php";
    const response = await fetch(url);
    //currentUser = await response.json();
    return await response.json();
  }
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
      {#await highscores() then userData}
        {#each userData as userData}
          <Highscore HighscoresData={userData} />
        {/each}
      {:catch error}
        <tr>
          <td colspan="2">Error: {error.message}</td>
        </tr>
      {/await}
    </tbody>
  </table>
</section>
{#await getUser() then currentUser}
  <section id="loginStatus">
    <p id="userStatus">{currentUser}</p>
  </section>
{/await}
