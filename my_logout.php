<?php
	//Redireccionador
	session_start();
	$_SESSION = array();
	session_destroy();
	header("location: my_login.php");
	exit;
?>
