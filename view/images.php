<div class="imagelist">
    <div class="page">
        <?php
        $imgnb = array_key_exists('page',$_GET) ? $_GET['page']*4 : 0;

        for ($i=$imgnb; $i < $imgnb+4; $i++) { 
            echo $i, "<br>";
        }
        ?>
    </div>
</div>
<script>
    function getpage(pagenb){
        history.pushState({},"","?page="+pagenb);
        var xhr  = new XMLHttpRequest();
        xhr.open('GET', "view/images.php?page="+pagenb, true);
        xhr.setRequestHeader('Content-type', 'application/x-www-form-urlencoded');
        xhr.onload = function () {
            var response = xhr.responseText;
            if (xhr.readyState == 4 && xhr.status == "200") {
                var data = document.createElement("div");
                data.innerHTML = response;
                document.querySelector(".imagelist .page").parentElement.appendChild(data);
            } else {
                console.error(response);
                window.location.reload();
            }
        }
        xhr.send();
    }
</script>