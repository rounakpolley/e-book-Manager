<?php
$file = $_GET["file_path"];
$file2 = "../".$file;
echo $file2;
if (file_exists($file2)) {
    header('Content-Description: File Transfer');
    header('Content-Type: application/octet-stream');
    header('Content-Disposition: attachment; filename="'.basename($file2).'"');
    header('Expires: 0');
    header('Cache-Control: must-revalidate');
    header('Pragma: public');
    header('Content-Length: ' . filesize($file2));
    readfile($file2);
    exit;
}
?>
