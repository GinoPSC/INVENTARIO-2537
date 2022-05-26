<?php
	//Redireccionador
	session_start();
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
		header("location: my_login.php");
		exit;
	}
	require_once "my_config.php";
	$new_password = $confirm_password = "";
	$new_password_err = $confirm_password_err = "";
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		//Validar cambio de contraseña
		if(empty(trim($_POST["new_password"]))){
			$new_password_err = "Porfavor ingrese una contraseña";     
		}elseif(strlen(trim($_POST["new_password"])) < 6){
			$new_password_err = "La contraseña debe tener minimo 6 caracteres";
		}else{
			$new_password = trim($_POST["new_password"]);
		}
		if(empty(trim($_POST["confirm_password"]))){
			$confirm_password_err = "Porfavor reingrese la contraseña";
		}else{
			$confirm_password = trim($_POST["confirm_password"]);
			if(empty($new_password_err) && ($new_password != $confirm_password)){
				$confirm_password_err = "Las contraseñas no coinciden";
			}
		}
		if(empty($new_password_err) && empty($confirm_password_err)){
			$sql = "UPDATE Usuario SET Clave = ? WHERE Usua_ID = ?";
			if($stmt = mysqli_prepare($link, $sql)){
				mysqli_stmt_bind_param($stmt, "si", $param_password, $param_id);
				$param_password = password_hash($new_password, PASSWORD_DEFAULT);
				$param_id = $_SESSION["Usua_ID"];
				if(mysqli_stmt_execute($stmt)){
					//Redireccionador
					session_destroy();
					header("location: my_login.php");
					exit();
				}else{
					echo "Ha ocurrido un error, porfavor intente mas tarde";
				}
				mysqli_stmt_close($stmt);
			}
		}
		mysqli_close($link);
	}
?>

<!doctype html>
<html lang="en" class="h-100">
	<head>
		<meta charset="UTF-8">
		<title>Inventario #2537</title>
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<meta name="description" content="">
		<meta name="author" content="Mark Otto, Jacob Thornton, and Bootstrap contributors">
		<meta name="generator" content="Hugo 0.84.0">
		<link rel="canonical" href="https://getbootstrap.com/docs/5.0/examples/cover/">
		<link href="assets/dist/css/bootstrap.min.css" rel="stylesheet">

		<style>
			.bd-placeholder-img {
				font-size: 1.125rem;
				text-anchor: middle;
				-webkit-user-select: none;
				-moz-user-select: none;
				user-select: none;
			}

			@media (min-width: 768px) {
				.bd-placeholder-img-lg {
				  font-size: 3.5rem;
				}
			}
		</style>
		<style type="text/css">
			
			.wrapper{ width: 350px; padding: 20px; margin: auto;}
		</style>
		<link href="cover.css" rel="stylesheet">
	</head>

	<body class="d-flex h-100 text-center text-white bg-dark">
		<div class="cover-container d-flex w-100 h-100 p-3 mx-auto flex-column">
			<header class="mb-auto">
				<div>
					<h3 class="float-md-start mb-0">Hola <b><?php echo htmlspecialchars($_SESSION["Nombre"]); ?></b></h3>
					<nav class="nav nav-masthead justify-content-center float-md-end">
						<a class="nav-link active" aria-current="page" href="#">Inicio</a>
						<a class="nav-link" href="my_welcome_A.php">Empleados</a>
						<a class="nav-link" href="my_welcome_B.php">Productos</a>
						<a class="nav-link" href="my_logout.php">Cerrar</a>
					</nav>
				</div>
			</header>

			<main class="px-3">
				<div class="wrapper">
					<h2>Cambiar contraseña</h2>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post"> 
						<div class="form-group <?php echo (!empty($new_password_err)) ? 'has-error' : ''; ?>">
							<label>Contraseña nueva</label>
							<input type="Clave" name="new_password" class="form-control" value="<?php echo $new_password; ?>">
							<span class="help-block"><?php echo $new_password_err; ?></span>
						</div>
						
						<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
							<label>Reingrese Contraseña</label>
							<input type="Clave" name="confirm_password" class="form-control">
							<span class="help-block"><?php echo $confirm_password_err; ?></span>
						</div><br>
						
						<div class="form-group">
							<input type="submit" class="btn btn-primary" value="Restablecer">
							<a class="btn btn-danger" href="my_welcome.php">Cancelar</a>
						</div>
					</form>
				</div>
			</main>

			<footer class="mt-auto text-white-50">
				<p>Diseño de pagina proporcionado por <a href="https://getbootstrap.com/" class="text-white">Bootstrap</a>, y diseñado por <a href="https://twitter.com/mdo" class="text-white">@mdo</a>.</p>
				<p>Motor de pagina por Gino Sciaraffia</p>
			</footer>
		</div>
	</body>
</html>