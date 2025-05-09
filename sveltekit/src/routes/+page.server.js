export async function load() {
    // If PHP is on the host machine, use host.docker.internal
    const url = "/api/getAllHighscores.php";
    // Alternative: If PHP is in another container, use the container name
    //const url = "http://php-container/api/getAllHighscores.php";
    
    
    const response = await fetch(url);
    
    const list = await response.json();
    
    return { list };

}