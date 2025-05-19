<script>
  import { goto } from "$app/navigation";
  const form = $state({
    username: "",
    password: "",
    email: "",
  });
  async function adduser(e) {
    e.preventDefault();
    const data = new FormData(e.target);
    const url = "/api/adduser.php";

    const response = await fetch(url, {
      method: "post",
      body: JSON.stringify({
        username: form.username,
        password: form.password,
        email: form.email,
      }),
    });

    let result = await response.json();
    if (result.success == true) {
      await goto("/login");
    } else {
      alert("Registrering misslyckades");
    }
  }
</script>

<form method="post" onsubmit={adduser}>
  <label for="email">Email:</label>
  <input
    type="text"
    bind:value={form.email}
    name="email"
    id="email"
    required
    size="50"
  />

  <label for="username">Användarnamn:</label>
  <input
    type="text"
    bind:value={form.username}
    name="userName"
    id="userName"
    required
    size="50"
  />

  <label for="password">Lösenord:</label>
  <input
    type="password"
    bind:value={form.password}
    name="pwd"
    id="pwd"
    required
    size="50"
  />

  <input class="submit" type="submit" value="Registrera" />
</form>

<style>
  form {
    background: #b7c7a3;
    border-radius: 12px;
    box-shadow: 2px 2px 8px #3a5a40;
    max-width: 400px;
    margin: 60px auto 0 auto;
    padding: 32px 28px 24px 28px;
    display: flex;
    flex-direction: column;
    gap: 12px;
  }
  label {
    font-size: 1.1em;
    margin-bottom: 4px;
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
  .submit {
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
  .submit:hover {
    background: #3a5a40;
    transform: translateY(-2px) scale(1.03);
  }
</style>
