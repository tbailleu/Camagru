<?php
if ($_SERVER["PHP_SELF"] != "/index.php") header("location: /");
require_once("config/database.php");
if (!array_key_exists('user', $_SESSION)) header("location: /");
?><style>

  .container {
    display: grid;
    grid-template-columns: 3fr 3fr;
    height: 550px;
  }
  .container div {
    width: 100%;
  }
  .sketch {
    text-align: center;
  }
  .sketch video, .sketch canvas {
    max-height: 550px;
    width: 100%;
    max-width: 733.33px;
  }
  .sidebar {
    overflow-y: scroll;
    display: grid;
    padding: .5em;
    grid-gap: .5em;
    grid-template-columns: 1fr 1fr 1fr 1fr;
    justify-content: space-between
  }
  .sidebar .img {
    height: 8.827vw;
    position: relative;
  }
  .sidebar .img span {
    position: absolute;
    width: 1em;
    text-align: center;
    font-size: 2em;
    color: white;
    background-color: red;
    border-bottom-right-radius: 25%;
    cursor: pointer;
  }
  .sidebar .img img {
    height: 100%;
  }
  @media only screen and (max-width: 2000px) {
		.sidebar {
      grid-template-columns: 1fr 1fr 1fr;
    }
    .sidebar .img {
      height: 11.807vw;
    }
  }
  @media only screen and (max-width: 1600px) {
    .sidebar {
      grid-template-columns: 1fr 1fr;
    }
    .sidebar .img {
      height: 17.656vw;
    }
  }
	@media only screen and (max-width: 1300px) {
		.container {
			grid-template-columns: 3fr 2fr;
    }
    .sidebar .img {
      height: 13.52vw;
    }
  }
  @media only screen and (max-width: 1115px) {
		.container {
			grid-template-columns: 3fr 1fr;
    }
    .sidebar {
      grid-template-columns: 1fr;
    }
    .sidebar .img {
      height: 16.304vw;
    }
  }
  @media only screen and (max-width: 800px) {
    .container {
      /* grid-template-columns: 1fr; */
    }
  }
  .stickers .list {
    display: grid;
    grid-template-columns: 1fr 1fr 1fr 1fr 1fr 1fr;
    max-width: 733px;
    margin: auto;
  }
  .stickers .list li {
    height: 12.5vw;
    max-height: 150px;
    width: 100%;
    text-align: center;
  }
  .stickers .list li.active {
    border: 2px solid red;
  }
  .stickers .list li img {
    height: 100%;
  }
  .sketch button {
    padding: 0.5em 1em;
    background-color: red;
    border-radius: 1em;
    min-width: 7em;
    color: white;
    font-size: small;
  }
  .sketch button#send {
    display: none;
  }
  #camera {
    display: none;
  }
</style>
<div class="container">
	<div class="sketch">
    <video id="camera"></video>
    <canvas id="visual"></canvas>
    <div class="stickers">
      <ul class="list">
        <?php for ($i=0; $i < 6; $i++):?>
          <li data-id="<?=$i;?>"><img src="utils/stickers/<?=$i;?>.png" alt="sticker<?=$i;?>"></li>
        <?php endfor;?>
      </ul>
    </div>
    <button id="capture">Capture</button>
    <button id="send">Send</button>
  </div>
  <div 
    <?php
      $imglist = $pdo->prepare("SELECT * from `image` WHERE `user_id` = :userid ORDER BY `id` DESC LIMIT 30");
      $imglist->execute(array('userid' => $_SESSION["user"]["id"]));
      $imglist = $imglist->fetchAll();
      if (!$imglist) { echo "style ='padding:1em;'>You can place a sticker of your choise in the view and then click capture you can choise after if you want to save it or destroy your horible picture<br"; }
      else echo 'class="sidebar"';
    ?>>
    <?php foreach ($imglist as $img):?>
      <div class="img" data-index="<?=$img["id"];?>">
        <span onclick="deleteimg(<?=intval($img["id"]);?>)">X</span>
        <img src="<?=$img["path"];?>" alt="image<?=$img["id"];?>">
      </div>
    <?php endforeach;?>
  </div>
</div>
<script>
  function deleteimg(imgid) {
    if (confirm('Are you sure you want to delete this picture?')) {
      var xhr = new XMLHttpRequest();
      xhr.open('POST', "utils/deleteimg.php", true)
      xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
      xhr.onload = function () {
        var response = xhr.responseText;
        if (xhr.readyState == 4 && xhr.status == "200") {
          document.querySelector('.sidebar  [data-index="'+imgid+'"]').remove();
        } else {
          //console.error(response);
        }
      }
      xhr.send("json="+encodeURI(JSON.stringify({imageid: imgid})));
    }
  }


  var stickers = [].slice.call(document.querySelectorAll("body > div > div.sketch > div > ul > li"));
  var stickerdata = {
    img: null,
    sid: 0,
    x: Math.random()>.5?20:540,
    y: parseInt(Math.random()*240+40),
    sx: 80,
    sy: 200
  };
  var stickerimg = null;


  stickers.forEach(function(elem, index){
    elem.onclick = function() {
      stickers.forEach(function(elem) {elem.className = "";});
      elem.className = "active";
      stickerdata.sid = index;
      stickerimg = new Image();
      stickerimg.src = "utils/stickers/" + index + ".png"
      stickerdata.sy = 200;
      stickerdata.sx = 200 / stickerimg.height * stickerimg.width;
    }
  });
  stickers[0].click();
  var stickermove = true;
  
  var camera = document.getElementById('camera');
  var visual = document.getElementById('visual');
  var hascamera = false;
  camera.isRunning = false;

  var context = visual.getContext('2d');
  visual.width = 640;
  visual.height = 480;

  visual.onclick = function () {
    stickermove = !stickermove;
  }

  visual.onmousemove = function (e) {
    if (stickermove) {
      stickerdata.x = e.offsetX * 640 / visual.clientWidth - stickerdata.sx / 2;
      stickerdata.y = e.offsetY * 480 / visual.clientHeight - stickerdata.sy / 2;
    }
  }

  function draw() {
    //if(camera.paused || camera.ended) return false;
    context.drawImage(camera, 0, 0, 640, 480);
    context.drawImage(stickerimg, stickerdata.x, stickerdata.y, stickerdata.sx, stickerdata.sy);
    setTimeout(draw, 42, 640, 480);
  }

  navigator.getUserMedia({ video: { width: 640, height: 480 } }, function(stream) {
		camera.srcObject = stream;
    camera.addEventListener('play', draw, false);
		camera.onloadedmetadata = function () { this.isRunning = true; hascamera = true; camera.play() };
	}, function (err) {
    hascamera = false;
		console.log(err.name + ": " + err.message);
	});

	var capture = document.getElementById('capture');
	var send = document.getElementById('send');

	var postIMG = function (data) {
		var xhr = new XMLHttpRequest();
		xhr.open('POST', "utils/convertimg.php", true)
		xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
		xhr.onload = function () {
			var response = xhr.responseText;
			if (xhr.readyState == 4 && xhr.status == "200") {
				location.reload();
			} else {
				//console.error(response);
			}
		}
		xhr.send("json="+encodeURI(JSON.stringify(stickerdata)));
  }
  
  capture.onclick = function () {
    if (hascamera) {
      if (camera.isRunning) {
        camera.pause();
        send.style.display = "inline-block";
      } else {
        camera.play();
        send.style.display = "none";
      }
      camera.isRunning = !camera.isRunning;
    }
  }
	send.onclick = function () {
    if (hascamera && !camera.isRunning) {
      var canvas = document.createElement('canvas');
      canvas.width = 640;
      canvas.height = 480;
      var ctx = canvas.getContext('2d');
      ctx.drawImage(camera, 0, 0, 640, 480);
      stickerdata.img = canvas.toDataURL('image/png');
      postIMG();
    }
	};

</script>
