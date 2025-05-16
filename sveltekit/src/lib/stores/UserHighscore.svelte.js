//!LÖS SÅ ATT FUNKTIONEN LIGGER I ANNAN FIL
let UserHighscore = $state({value: null});

async function fetchHighscore() {
  try {
    const response = await fetch("http://host.docker.internal/api/getHighscore.php");
    if (!response.ok) {
      throw new Error(`Response status: ${response.status}`);
    }

    const result = await response.json();
    UserHighscore.value = result;
  } catch (error) {
    console.error(error.message);
  }
}

fetchHighscore();

export { UserHighscore };