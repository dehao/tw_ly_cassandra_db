<?php 
$content = file_get_contents("php://stdin");
$content = preg_replace("/\t/smu", "  ", $content);
echo $content;
?>
