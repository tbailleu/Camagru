<?php
if ($_SERVER["PHP_SELF"] == "/index.php") require_once("config/database.php");
else require_once("../config/database.php");

$imgnb = array_key_exists('page',$_GET) ? intval($_GET['page'])*6 : 0;
$imgnb = $imgnb > 0 ? $imgnb : 0;

if ($imgnb > 2147483646) { echo "Well done, you won this game !!!"; die(); }

$imglist = $pdo->query("SELECT * from `image` ORDER BY `id` DESC LIMIT 6 OFFSET ".$imgnb);
if (!$imglist) { echo "Database error"; die(); }
$imglist = $imglist->fetchAll();

?><style>
  * {
    font-family: -apple-system, BlinkMacSystemFont, 'Segoe UI', Roboto, Oxygen, Ubuntu, Cantarell, 'Open Sans', 'Helvetica Neue', sans-serif !important;
    border-spacing: 0;
    margin: 0;
    padding: 0;
    border: none;
    box-sizing: border-box;
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
</style><?php foreach ($imglist as $img):?>
    <div data-imageid="<?=$img["id"]?>" class="image">
        <img src="<?=$img["path"]?>" alt="photo">
        <div class="username"><?php
    
    $user = $pdo->query("SELECT `username` from `users` WHERE `id`=".intval($img["user_id"]));
    if (!$user) { die(); }
    $user = $user->fetch();
    echo $user["username"];
    ?></div>
        <div class="action">
            <div class="like">Like <?=$img["nblike"]?></div>
            <div>Comment</div>
        </div>
    </div>
    <script>
        document.querySelector(".imagelist .image[data-imageid='<?=$img["id"]?>'] .like").onclick = function (e) {
            e.preventDefault();
            var xhr  = new XMLHttpRequest()
            xhr.open('POST', "utils/like.php", true)
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            var self = this;
            xhr.onload = function () {
                var response = xhr.responseText;
                if (xhr.readyState == 4 && xhr.status == "200") {
                    self.innerHTML = "Like " + response;
                } else {
                    console.error(response);
                }
            }
            var tab = {imageid: <?=intval($img["id"])?>};
            xhr.send("json="+encodeURI(JSON.stringify(tab)));
        }
    </script>
<?php endforeach;