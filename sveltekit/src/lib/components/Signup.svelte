<script>
  async function adduser(e) {
    e.preventDefault();
    const data = new FormData(e.target);
    const url = "/api/adduser.php";

    const response = await fetch(url, {
      method: "post",
      body: data,
    });

    let result = await response.json();
    if (result == true) {
      window.location.href = "/login";
    } else {
      alert("Registrering misslyckades");
    }
  }
</script>

<form method="post" onsubmit={adduser}>
  <label for="email">Email:</label>
  <br />
  <input type="text" name="email" id="email" required size="50" />
  <br />
  <label for="username">Användarnamn:</label>
  <br />
  <input type="text" name="userName" id="userName" required size="50" />
  <br />
  <label for="password">Lösenord:</label>
  <br />
  <input type="password" name="pwd" id="pwd" required size="50" />
  <br />

  <input class="submit" type="submit" value="Registrera" />
</form>
