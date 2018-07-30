<?php
$a = file_get_contents("php://input");

file_put_contents("./log.txt",date('Y-m-d H:i:s').json_encode($a).PHP_EOL,FILE_APPEND);


?>
