<script>
  import Country from "$lib/components/Country.svelte";

  async function getCountries() {
    const url = "https://data.egyweb.se/api/world/getcountries.php";
    const response = await fetch(url);
    return response.json();
  }
</script>

<svelte:head>
  <title>Länder i Europa</title>
</svelte:head>

<h1>Länder i Europa</h1>
<section>
  {#await getCountries() then dataList}
    {#each dataList as country}
      <Country countryData={country} />
    {/each}
  {:catch error}
    <p class="error">Fel: {error.message}</p>
  {/await}
</section>
