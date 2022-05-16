<?php
	//Redireccionador
	session_start();
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
		header("location: my_login.php");
		exit;
	}
	$sub_nm = $_SESSION["username"];
?>
 
<!DOCTYPE html>
<html lang="en">
	<head>
	
		<meta charset="UTF-8">
		<title>Vitrineo Facil</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
		<style type="text/css">
			body{ font: 14px sans-serif; text-align: center; }
		</style>
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
		
	</head>
	<body>

		<div class="page-header">
			<h1>Hola <b><?php echo htmlspecialchars($_SESSION["username"]); ?></b>. Bienvenido a Vitrineo Facil</h1>
		</div>
		
		<div id="Vitrina_A">
			<h2>¡Empieza a cureosear los articulos YA!</h2>
		</div>
		
		<button type="button" onclick="Code_B()">Mostrar Vitrina</button>
		<button type="button" onclick="Code_C()">Mostrar Mis Articulos</button>
		<button type="button" onclick="Code_D()">Mostrar Articulos Guardados</button>
		<br><br>
		
		<script>
			function Code_A() {
				$.ajax({
					type: 'GET',
					url: 'VF_Codigo_A.php',
					success: function (data) {
						document.getElementById("Vitrina_A").innerHTML = data; 
					}
				});
			}
			
			function Code_B() {
				$.ajax({
					type: 'GET',
					url: 'VF_Codigo_B.php',
					success: function (data) {
						document.getElementById("Vitrina_A").innerHTML = data; 
					}
				});
			}
			
			function Code_C() {
				$.ajax({
					type: 'GET',
					url: 'VF_Codigo_C.php',
					success: function (data) {
						document.getElementById("Vitrina_A").innerHTML = data; 
					}
				});
			}
			
			
			
			function Code_D() {
				$.ajax({
					type: 'GET',
					url: 'VF_Codigo_D.php',
					success: function (data) {
						document.getElementById("Vitrina_A").innerHTML = data; 
					}
				});
			}
		</script>
		
		<p>
			<a href="my_article_register.php" class="btn btn-primary">Añadir Articulo</a>
			<a href="my_reset_password.php" class="btn btn-warning">Restablecer contraseña</a>
			<a href="my_logout.php" class="btn btn-danger">Cerrar sesion</a>
		</p>
		
		<?php 
			if (isset($_POST["art_save"])){
				$sub_id = $_POST["art_save"];
				require_once "my_article_rescuer.php";
			}
		?>
		
	</body>
</html>