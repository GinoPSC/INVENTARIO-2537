<?php
	//Base de datos
	define('DB_SERVER', 'localhost');
	define('DB_USERNAME', 'root');
	define('DB_PASSWORD', '');
	define('DB_NAME', 'inv_schema');

	$link = mysqli_connect(DB_SERVER, DB_USERNAME, DB_PASSWORD, DB_NAME);

	if($link === false){
		die("ERROR: Coneccion fallida. " . mysqli_connect_error());
	}
?>