<?php
header('Content-Type: text/html; charset=utf-8');

$fileName = $_POST['notepad__fileName'];
$content = $_POST['editor'];

if($content){
	if (file_exists($fileName)) {
		$handle = @fopen($fileName,"w");
		fwrite($handle,$content); fclose($handle);
		echo json_encode(1, JSON_UNESCAPED_UNICODE);
		return false;
	}
};
