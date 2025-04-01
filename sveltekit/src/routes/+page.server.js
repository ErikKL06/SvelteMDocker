export async function load() {
  const url = "http://localhost/api/getAllHighscores.php";

    const response = await fetch(url);
  
    const list = await response.json();
    return { list };
  }