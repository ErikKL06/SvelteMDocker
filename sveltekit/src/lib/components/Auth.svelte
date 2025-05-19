<script>
  import { user } from "$lib/stores/user.svelte.js";
  import { goto } from "$app/navigation"; // Import goto

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
      console.log(
        "Auth.svelte - user store updated:",
        JSON.parse(JSON.stringify(user))
      ); // For debugging
      await goto("/"); // Use goto instead of window.location.href
    } else {
      alert("Inloggning misslyckades");
    }
  }
</script>

<form onsubmit={handleAuth}>
  <label for="user">Username:</label>
  <input
    type="text"
    bind:value={form.username}
    name="user"
    required
    size="50"
  />

  <label for="password">Password:</label>
  <input
    type="password"
    bind:value={form.password}
    name="password"
    required
    size="50"
  />

  <input type="submit" value="Logga in" />
</form>

<style>
  form {
    background: #b7c7a3;
    border-radius: 12px;
    box-shadow: 2px 2px 8px #3a5a40;
    max-width: 400px;
    margin: 30px auto;
    padding: 32px 28px 24px 28px;
    display: flex;
    flex-direction: column;
    gap: 16px;
  }
  label {
    font-size: 1.1em;
    margin-bottom: 2px;
    color: #222;
  }
  input[type="text"],
  input[type="password"] {
    border: 1px solid #3a5a40;
    border-radius: 6px;
    padding: 10px;
    font-size: 1em;
    background: #e9f5db;
    margin-bottom: 10px;
  }
  input[type="submit"] {
    background: #588157;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px 24px;
    font-size: 1em;
    font-family: "Georgia", serif;
    font-weight: bold;
    box-shadow: 1px 1px 4px #3a5a40;
    cursor: pointer;
    transition:
      background 0.2s,
      transform 0.1s;
    margin-top: 10px;
  }
  input[type="submit"]:hover {
    background: #3a5a40;
    transform: translateY(-2px) scale(1.03);
  }
</style>
