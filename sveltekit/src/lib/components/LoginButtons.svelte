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
