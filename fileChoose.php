<?php
header('Content-Type: text/html; charset=utf-8');

$fileList = $_POST['fileList'];

if($fileList){
	if (file_exists($fileList)) {
		$content = file_get_contents($fileList);
		$response = [$content, $fileList];
		echo json_encode($response, JSON_UNESCAPED_UNICODE);
		return false;
	}
};
