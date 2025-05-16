<script>
  import { user } from "$lib/stores/user.svelte.js";

  const form = $state({
    username: "",
    password: "",
  });

  const state = $state({
    //!ÄNDRA NAMNEN PÅ VARIABLERNA
    userData: null,
  });

  async function handleAuth(e) {
    e.preventDefault();

    const response = await fetch("/api/auth.php", {
      method: "POST",
      headers: {
        "Content-Type": "application/json",
      },
      body: JSON.stringify({
        username: form.username,
        password: form.password,
      }),
    });

    state.userData = await response.json();

    if (state.userData.success == true) {
      user.auth = true;
      user.userData = {
        username: state.userData.username,
        uid: state.userData.uid,
        email: state.userData.email,
      };

      window.location.href = "/";
    } else {
      alert("Inloggning misslyckades");
    }
  }
</script>

<form onsubmit={handleAuth}>
  <label for="user">Username:</label><br />
  <input
    type="text"
    bind:value={form.username}
    name="user"
    required
    size="50"
  /><br />

  <label for="password">Password:</label><br />
  <input
    type="password"
    bind:value={form.password}
    name="password"
    required
    size="50"
  /><br />

  <input type="submit" value="Logga in" />
</form>

{#if state.userData?.success}
  <p id="userStatus">Inloggad som {state.userData.username}</p>
{:else}
  <p id="userStatus">Gäst</p>
{/if}
