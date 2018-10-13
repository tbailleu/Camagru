<?php
if ($_SERVER["PHP_SELF"] != "/index.php") header("location: /");
?>
<style>
* {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif !important;
    border-spacing: 0;
    margin: 0;
    padding: 0;
    border: none;
    box-sizing: border-box;
  }
nav {
    position: fixed;
    top: 0;
    left: 0;
    right: 0;
    grid-template-columns: 1fr 4fr;
    border-bottom: 1px solid grey;
    padding: .8em;

    z-index: 100;
    background-color: white;
}
nav > ul {
    grid-template-columns: 1fr 1fr 1fr;
}
nav > ul > a > li {
    align-content: center;
    align-items: center;
    align-self: center;
    text-align: center;
    text-align-last: center;
}
nav,
nav > ul,
nav > ul a > li {
    display: grid;
}
span.space {
    display: block;
    padding: .8em;
}
</style>
<nav>
    <div>
        <a href="/">Camagru</a>
    </div>
    <ul>
        <?php if (array_key_exists('user', $_SESSION)):?>
        <a href="?capture"><li>capture</li></a>
        <a href="?account"><li>account</li></a>
        <a href="/utils/logout.php"><li>logout</li></a>
        <?php else:?>
        <li>&nbsp;</li>
        <a href="?signup"><li>signup</li></a>
        <a href="?login"><li>login</li></a>
        <?php endif;?>
    </ul>
</nav>
<span class="space">&nbsp;</span>
