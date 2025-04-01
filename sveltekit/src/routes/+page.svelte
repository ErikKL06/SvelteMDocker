<script>
  import Highscore from "$lib/components/Highscore.svelte";
  let { data } = $props();
</script>

<body>
  <section>
    {#each data.list as highscore}
      <Highscore highscoreData={highscore} />
    {/each}
  </section>
  <section id="loginStatus">
    <p id="userStatus">Gäst</p>
  </section>
</body>
