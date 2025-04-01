export async function load() {

      const response = await fetch("localhost/api/getAllHighscores.php");
      if (!response.ok) {
        throw new Error(`Response status: ${response.status}`);
      }
  
      const list = await response.json();
      return list;
  }