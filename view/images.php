<?php
$imgnb = array_key_exists('page',$_GET) ? $_GET['page']*6 : 0;
$imgnb = $imgnb > 0 ? $imgnb : 0;
for ($i=$imgnb; $i < $imgnb+6; $i++) { 
    echo "<p style='background-color:red;margin:2em;padding:5em'>", $i, "</p>";
}
?>