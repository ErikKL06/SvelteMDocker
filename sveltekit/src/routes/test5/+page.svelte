<script>
  const students = ["Henrik", "Jennifer", "Elisabeth", "Karl"];
  let isClicked = $state(false);
  let count = $state(0);

  async function getStudents2() {
    return ["ida", "erik", "ture", "victor"];
  }
</script>

<ul>
  {#await getStudents2()}
    <p>laddar</p>
  {:then students2}
    {#each students2 as student2}
      <li>{student2}</li>
    {/each}
  {/await}
</ul>

<ul>
  {#each students as student}
    <li>{student}</li>
  {/each}
</ul>

{#if isClicked}
  <p>KNAPPEN ÄR KLICKAD, värde = {isClicked}</p>
{:else}
  <p>Knappen ej klickad</p>
{/if}

{#key count}
  // Körs när variabeln, count, ändras
  <p>KNAPPEN ÄR KLICKAD, Antal ggr = {count}</p>
{/key}

<button
  type="button"
  onclick={() => {
    isClicked = true;
    count++;
  }}>Knapp</button
>
