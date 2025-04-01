export async function load({ fetch }) {
  try {
    // If PHP is on the host machine, use host.docker.internal
    const url = "http://host.docker.internal/api/getAllHighscores.php";
    // Alternative: If PHP is in another container, use the container name
    // const url = "http://php-container/api/getAllHighscores.php";
    
    console.log(`Fetching from: ${url}`);
    
    const response = await fetch(url);
    
    const list = await response.json();
    console.log('Data received:', list);
    

    
    return { list };
  } catch (error) {
    console.error('Failed to fetch highscores:', error);
    return { list: [], error: error.message };
  }
}