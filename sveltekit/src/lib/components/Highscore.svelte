<script>
  let { HighscoresData } = $props();
</script>

<tr>
  <td>{HighscoresData.username}</td>
  <td>{HighscoresData.highscore}</td>
</tr>

<style>
  tr {
    background: #b7c7a3;
    transition: background 0.2s;
  }
  tr:hover {
    background: #a3b18a;
  }
  td {
    color: #222;
    font-size: 1em;
    padding: 6px 12px;
  }
</style>
