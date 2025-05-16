<script>
  import Game from "$lib/components/Game.svelte";
  import { user } from "$lib/stores/user.svelte.js";
  import Highscore from "$lib/components/Highscore.svelte";
  import { goto, afterNavigate } from "$app/navigation";
  import { auth } from "$lib/shared/auth.js";
  import { onMount } from "svelte";
  import LoginStatus from "$lib/components/LoginStatus.svelte";
  import LoginButtons from "$lib/components/LoginButtons.svelte";

  async function highscores() {
    // If PHP is on the host machine, use host.docker.internal
    const url = "/api/getAllHighscores.php";
    // Alternative: If PHP is in another container, use the container name
    //const url = "http://php-container/api/getAllHighscores.php";

    const response = await fetch(url);

    return await response.json();
  }

  afterNavigate(async () => {
    const response = await auth();
    user.auth = response.auth;
    user.userData = response.userData;
  });
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
<section id="loginStatus">
  <LoginStatus />
  <LoginButtons />
</section>
