export async function load() {

      const response = await fetch("http://localhost/api/getAllHighscores.php");
  
      const list = await response.json();
      return { list };
  }