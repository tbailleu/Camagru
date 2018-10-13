<?php
if ($_SERVER["PHP_SELF"] == "/index.php") require_once("config/database.php");
else require_once("../config/database.php");

$imgnb = array_key_exists('page',$_GET) ? intval($_GET['page'])*6 : 0;
$imgnb = $imgnb > 0 ? $imgnb : 0;

if ($imgnb > 2147483646) { echo "Well done, you won this game !!!"; die(); }

$imglist = $pdo->query("SELECT * from `image` ORDER BY `id` DESC LIMIT 6 OFFSET ".$imgnb);
if (!$imglist) { echo "Database error"; die(); }
$imglist = $imglist->fetchAll();

foreach ($imglist as $img):?>
    <div data-imageid="<?=$img["id"]?>" class="image">
        <img src="<?=$img["path"]?>" alt="photo">
        <div class="username"><?php
          $user = $pdo->query("SELECT `username` from `users` WHERE `id`=".intval($img["user_id"]));
          if (!$user) { die(); }
          $user = $user->fetch();
          echo $user["username"];?>
        </div>
        <div class="action">
            <div class="like">Like <?=$img["nblike"]?></div>
            <div class="comment">Comment</div>
        </div>
    </div>
    <script>
        document.querySelector(".imagelist .image[data-imageid='<?=$img["id"]?>'] .like").onclick = function (e) {
            e.preventDefault();
            e.target.onclick = null;
            e.target.style.cursor = "default";
            var xhr  = new XMLHttpRequest()
            xhr.open('POST', "utils/like.php", true)
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            var self = this;
            xhr.onload = function () {
                var response = xhr.responseText;
                if (xhr.readyState == 4 && xhr.status == "200") {
                    self.innerHTML = "Like " + response;
                } else {
                    //console.error(response);
                }
            }
            var tab = {imageid: <?=intval($img["id"])?>};
            xhr.send("json="+encodeURI(JSON.stringify(tab)));
        }
        document.querySelector(".imagelist .image[data-imageid='<?=$img["id"]?>'] .comment").onclick = function (e) {
            e.preventDefault();
            e.target.onclick = null;
            e.target.style.cursor = "default";
            var xhr  = new XMLHttpRequest()
            xhr.open('POST', "utils/comment.php", true)
            xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
            var self = this;
            xhr.onload = function () {
                var response = xhr.responseText;
                if (!(xhr.readyState == 4 && xhr.status == "200")) console.error(response);
            }
            comment = prompt("Saisir votre commentaire içi\n\nvotre commentaire doit valider la regex suivante:\n[a-zA-Z0-9 ]{1,250}");
            var tab = {imageid: <?=intval($img["id"])?>, message: comment};
            xhr.send("json="+encodeURI(JSON.stringify(tab)));
        }
    </script>
<?php endforeach;