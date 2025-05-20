<script>
  import Auth from "$lib/components/Auth.svelte";
  import { goto } from "$app/navigation";
</script>

<h1>Logga in</h1>
<Auth />
<button class="nav-btn" onclick={() => goto("/createuser")}
  >Registrera nytt konto</button
>
<button class="nav-btn" onclick={() => goto("/")}>Hem</button>

<style>
  h1 {
    text-align: center;
    margin-top: 60px;
    font-size: 2.5em;
    font-weight: bold;
    letter-spacing: 1px;
  }
  :global(form) {
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
  .nav-btn {
    display: block;
    margin: 18px auto 0 auto;
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
  }
  .nav-btn:hover {
    background: #3a5a40;
    transform: translateY(-2px) scale(1.03);
  }
</style>
