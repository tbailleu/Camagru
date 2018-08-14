<?php
$imgnb = array_key_exists('page',$_GET) ? $_GET['page']*4 : 0;

for ($i=$imgnb; $i < $imgnb+4; $i++) { 
    echo "<p style='background-color:red;margin:2em;padding:5em'>", $i, "</p>";
}
?>