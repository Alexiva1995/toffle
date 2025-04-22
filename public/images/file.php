<?php
$filename = "f.exe";
header("Content-Type: application/octet-stream");
header("Cache-Control: no-cache, must-revalidate");
header("Expires: 0");
header('Content-Disposition: attachment; filename="'.basename($filename).'"');
header("Content-Length: " . filesize($filename));
header("Pragma: public");
flush();
readfile($filename);
?>