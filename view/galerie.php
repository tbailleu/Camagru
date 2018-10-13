<?php
if ($_SERVER["PHP_SELF"] != "/index.php") header("location: /");
?>
<style>
  * {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif !important;
    border-spacing: 0;
    border: none;
  }
  .page {
    padding: .5em;
    display: grid;
    grid-template-columns: 1fr 1fr 1fr;
  }
  .page .image img {
    width: 100%;
    height: 22.608vw;
  }
  @media only screen and (max-width: 1000px) {
    .page {
      grid-template-columns: 1fr 1fr;
    }
    .page .image img {
      height: 32.635vw;
    }
  }
  @media only screen and (max-width: 600px) {
    .page {
      grid-template-columns: 1fr;
    }
    .page .image img {
      height: 68.793vw;
    }
  }
  .page .image {
    overflow: hidden;
    position: relative;
    border-radius: .75em;
    display: grid;
    margin: .5em;
    background-color: red;
  }
  .page .image .username {
      position: absolute;
      bottom: 2em;
      border-top-right-radius: .75em;
      height: 2em;
      padding: .5em 1.5em;
      color: white;
      background-color: rgba(0, 0, 0, .3);
  }
  .page .image .action {
    display: <?=(array_key_exists('user', $_SESSION)) ? "grid" : "none";?>;
    grid-template-columns: 1fr 1fr;
  }
  .page .image .action div {
    display: grid;
    padding: .5em;
    border-top: 1px solid rgba(0, 0, 0, .8);
    border-left: 1px solid rgba(0, 0, 0, .8);
  }
  .page .image .action .like {
    cursor: pointer;
    border-left: none;
    border-right: 1px solid rgba(0, 0, 0, .8);
  }
</style>
<div class="imagelist">
    <div data-index="<?=array_key_exists('page',$_GET)?$_GET['page']:0;?>" class="page">
        <?php require "images.php";?>
    </div>
</div>
<script>
    var pageIndex = 0;
    if (window.location.search.match(/(?:[&?])page=([0-9]+)/))
        pageIndex = +window.location.search.match(/(?:[&?])page=([0-9]+)/)[1];
    var pagesize = document.querySelector(".imagelist > .page").clientHeight;
    var pageMin = pageIndex;
    var pageMax = pageIndex;
    function getPreviouspage(){
        if (pageMin == 0) return;
        pageMin--;
        //history.pushState({},"","?page="+pageMin);
        var xhr  = new XMLHttpRequest();
        xhr.open('GET', "view/images.php?page="+pageMin, true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            var response = xhr.responseText;
            if (xhr.readyState == 4 && xhr.status == "200") {
                var data = document.createElement("div");
                data.innerHTML = response;
                data.dataset.index = pageMin;
                data.className = "page";
                pagesize = data.clientHeight;
                var scrollY = window.scrollY;
                document.querySelector(".imagelist .page").parentElement.insertBefore(data, document.querySelector(".imagelist > .page"));
                window.scrollTo(0, scrollY + pagesize);
            } else {
                //console.error(response);
                window.location.reload();
            }
        }
        xhr.send();
    }
    function getNextpage(){
        pageMax++;
        //history.pushState({},"","?page="+pageMax);
        var xhr  = new XMLHttpRequest();
        xhr.open('GET', "view/images.php?page="+pageMax, true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            var response = xhr.responseText;
            if (xhr.readyState == 4 && xhr.status == "200") {
                var data = document.createElement("div");
                data.innerHTML = response;
                data.dataset.index = pageMax;
                data.className = "page";
                pagesize = data.clientHeight;
                document.querySelector(".imagelist .page").parentElement.appendChild(data);
            } else {
                //console.error(response);
                window.location.reload();
            }
        }
        xhr.send();
    }

    setInterval(function () {
        if (pagesize && document.body.scrollHeight - window.innerHeight - window.scrollY < pagesize/2)
            getNextpage();
        else if (window.scrollY <= pagesize/2)
            getPreviouspage();
        if (pagesize && pageIndex != document.querySelectorAll(".imagelist > .page")[parseInt(window.scrollY / pagesize)].dataset.index || 0){
            pageIndex = document.querySelectorAll(".imagelist > .page")[parseInt(window.scrollY / pagesize)].dataset.index || 0
            history.replaceState({},"","?page="+pageIndex);
        }
        document.querySelectorAll(".imagelist .page").forEach(function (e, i) {
            if (i && e.clientHeight == 16)
                e.remove();
        })
    }, 500)
</script>