<script>
  import { auth } from "$lib/shared/auth.js";
  import { goto } from "$app/navigation";
  import { afterNavigate } from "$app/navigation";

  let isLoggedIn = $state(false);

  afterNavigate(async () => {
    const response = await auth();

    isLoggedIn = response.auth;
  });
</script>

{#if isLoggedIn === true}
  <button
    onclick={() => {
      fetch("/api/logout.php", { method: "POST" }).then(() => goto("/"));
    }}>Logout</button
  >
{:else}
  <button onclick={goto("/login")}>Login</button>
  <button onclick={goto("/createuser")}>Register</button>
{/if}

<style>
  button {
    background: #588157;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px 24px;
    margin: 4px 0;
    font-size: 1em;
    font-family: 'Georgia', serif;
    font-weight: bold;
    box-shadow: 1px 1px 4px #3a5a40;
    cursor: pointer;
    transition: background 0.2s, transform 0.1s;
  }
  button:hover {
    background: #3a5a40;
    transform: translateY(-2px) scale(1.03);
  }
</style>
