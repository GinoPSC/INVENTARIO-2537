<?php
	//Redireccionador
	session_start();
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
		header("location: my_login.php");
		exit;
	}
	
	$_SESSION["step_num"] = 0;
	header("location: my_welcome.php");
?>