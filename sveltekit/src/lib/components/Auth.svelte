<script>
  import { user } from "$lib/stores/user.svelte.js";
  let userData = $state({});

  async function auth(e) {
    e.preventDefault();
    const data = new FormData(e.target);
    const url = "/api/auth.php";

    const response = await fetch(url, {
      method: "post",
      body: data,
    });

    userData = await response.json();
    if (userData["success"] == true) {
      //spara i storen
      window.location.href = "/";
    } else {
      alert("Inloggning misslyckades");
    }
  }
</script>

<form method="post" onsubmit={auth}>
  <label for="user">Username:</label>
  <br />
  <input type="text" name="user" required size="50" />
  <br />
  <label for="password">Password:</label>
  <br />
  <input type="password" name="password" required size="50" /><br />
  <input type="submit" value="Logga in" />
</form>
{#if userData["success"] == true}
  <p id="userStatus">Inloggad som {userData["username"]}</p>
{:else}
  <p id="userStatus">Gäst</p>
{/if}
