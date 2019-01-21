<?php
header('Content-Type: text/html; charset=utf-8');

$login = 'momiamadminnow';
$password = '1';

$filesList = "index.html,example.html,another.html";

$userLogin = htmlentities($_POST['login']);
$userPassword = htmlentities($_POST['password']);

if($login === $userLogin && $password === $userPassword){
	setcookie("auth", $login, time()+3600);
	setcookie("filesList", $filesList, time()+3600);
	echo json_encode(1, JSON_UNESCAPED_UNICODE);
} else {
	echo json_encode(0, JSON_UNESCAPED_UNICODE);
};
