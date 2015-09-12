<?php
header("Content-type: application/vnd.ms-word");
header("Content-Disposition: attachment;Filename=Editor.doc");

echo "<html>";
echo "<meta http-equiv=\"Content-Type\" content=\"text/html; charset=utf-8\">";
echo "<body>";
echo $_REQUEST['editortext'];
echo "</body>";
echo "</html>";
?>