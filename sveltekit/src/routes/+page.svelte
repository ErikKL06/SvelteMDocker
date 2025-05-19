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
  <div id="game-wrapper">
    <Game />
  </div>
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
</section>

<section id="loginStatus">
  <LoginStatus />
  <LoginButtons />
</section>

<style>
  :global(html), :global(body) {
    min-height: 100vh;
    height: 100%;
    margin: 0;
    padding: 0;
    background: #b7c7a3;
    font-family: 'Georgia', serif;
    width: 100%;
    max-width: 100vw;
    overflow: hidden;
  }
  #game-container {
    display: flex;
    justify-content: center;
    align-items: flex-start;
    gap: 20px;
    height: 80vh;
    margin-top: 40px;
    width: 100%;
    max-width: 100vw;
    box-sizing: border-box;
    padding: 0 20px;
  }
  #game-wrapper {
    flex: 1;
    max-width: 800px;
  }
  #highscore {
    width: 300px;
    background: none;
    padding: 0;
  }
  #highscoreTable {
    border-collapse: separate;
    border-spacing: 0;
    background: #b7c7a3;
    box-shadow: 2px 2px 8px #3a5a40;
    border-radius: 12px;
    width: 100%;
    max-width: 100%;
    margin-left: 0;
    border: 3px solid #3a5a40;
    overflow: hidden;
  }
  #highscoreTable th, #highscoreTable td {
    padding: 8px 16px;
    border-bottom: 1px solid #3a5a40;
    text-align: left;
  }
  #highscoreTable th {
    background: #b7c7a3;
    color: #222;
    font-size: 1.1em;
    font-weight: bold;
  }
  #highscoreTable tr:last-child td {
    border-bottom: none;
  }
  #loginStatus {
    position: fixed;
    right: 2vw;
    bottom: 2vh;
    display: flex;
    flex-direction: column;
    align-items: flex-end;
    gap: 10px;
    z-index: 10;
  }
</style>
