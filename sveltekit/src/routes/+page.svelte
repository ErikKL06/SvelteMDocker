<script>
  import Highscore from "$lib/components/Highscore.svelte";
  let { data } = $props();
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
      {#each data.list as userData}
        <Highscore HighscoresData={userData} />
      {/each}
    </tbody>
  </table>
</section>
<section id="loginStatus">
  <p id="userStatus">Gäst</p>
</section>
