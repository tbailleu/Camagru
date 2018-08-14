<style>
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
    grid-template-columns: 1fr 1fr 1fr 1fr;
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
        logo
    </div>
    <ul>
        <a href=""><li>account</li></a>
        <a href=""><li>capture</li></a>
        <a href=""><li>signin</li></a>
        <a href=""><li>logout</li></a>
    </ul>
</nav>
<span class="space">&nbsp;</span>
