<script>
  import Signup from "$lib/components/Signup.svelte";
  import { goto } from "$app/navigation";
</script>
<Signup />

<button class="nav-btn" onclick={() => goto('/login')}>Logga in</button>
<button class="nav-btn" onclick={() => goto('/')}>Hem</button>

<style>
  .nav-btn {
    display: block;
    margin: 18px auto 0 auto;
    background: #588157;
    color: #fff;
    border: none;
    border-radius: 8px;
    padding: 10px 24px;
    font-size: 1em;
    font-family: 'Georgia', serif;
    font-weight: bold;
    box-shadow: 1px 1px 4px #3a5a40;
    cursor: pointer;
    transition: background 0.2s, transform 0.1s;
  }
  .nav-btn:hover {
    background: #3a5a40;
    transform: translateY(-2px) scale(1.03);
  }
</style>
