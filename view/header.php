<style>
nav {
    grid-template-columns: 1fr 4fr;
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

