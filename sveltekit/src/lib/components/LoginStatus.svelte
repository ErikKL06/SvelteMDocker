<script>
  import { user } from "$lib/stores/user.svelte.js";
</script>

<p id="userStatus">
  {user.auth ? "Logged in:" : "Not logged in"}
  {user.userData ? user.userData.username : ""}
</p>

<style>
  #userStatus {
    font-size: 1.1em;
    font-weight: bold;
    color: #222;
    background: #b7c7a3;
    border-radius: 6px;
    padding: 6px 14px;
    box-shadow: 1px 1px 4px #3a5a40;
    margin-bottom: 8px;
  }
</style>
