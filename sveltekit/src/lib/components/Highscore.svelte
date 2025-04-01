<script>
  let { highscoreData } = $props();
</script>

<section id="highscore">
  <table id="highscoreTable">
    <tbody>
      <tr>
        <td>{highscoreData.username}</td>
        <td>{highscoreData.highscore}</td>
      </tr>
    </tbody>
  </table>
</section>
