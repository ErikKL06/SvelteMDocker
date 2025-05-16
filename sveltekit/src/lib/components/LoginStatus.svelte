<script>
  import { user } from "$lib/stores/user.svelte.js";
</script>

<p id="userStatus">
  {user.auth ? "Logged in" : "Not logged in"}
  {user.userData ? user.userData.username : ""}
</p>
