<?php
	require_once "my_config.php";
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		
		$sql = "INSERT INTO articles_rescued (art_hldr,art_id) VALUES (?, ?)";
		if($stmt = mysqli_prepare($link, $sql)){
			mysqli_stmt_bind_param(
				$stmt, 
				"ss", 
				$param_art_hldr, 
				$param_art_id
			);
			$param_art_hldr = $sub_nm;
			$param_art_id = $sub_id;
			if(mysqli_stmt_execute($stmt)){
				//Redireccionador header("location: my_welcome.php");
			}else{
				echo "Usted ya guardo este articulo <br>";
			}
			mysqli_stmt_close($stmt);
		}
	}
?>