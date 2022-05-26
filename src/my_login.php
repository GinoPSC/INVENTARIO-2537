<?php
	//Redireccionador
	session_start();
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
		header("location: my_welcome.php");
		exit;
	}
	require_once "my_config.php";
	$Nombre = $Clave = "";
	$username_err = $password_err = "";

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		//Usuario
		if(empty(trim($_POST["Nombre"]))){
			$username_err = "Porfavor ingrese un nombre";
		}else{
			$Nombre = trim($_POST["Nombre"]);
		}
		
		//Contraseña
		if(empty(trim($_POST["Clave"]))){
			$password_err = "Porfavor ingrese una contraseña";
		}else{
			$Clave = trim($_POST["Clave"]);
		}
		if(empty($username_err) && empty($password_err)){
			$sql = "SELECT Usua_ID, Nombre, Clave FROM Usuario WHERE Nombre = ?";
			if($stmt = mysqli_prepare($link, $sql)){
				mysqli_stmt_bind_param($stmt, "s", $param_username);
				$param_username = $Nombre;
				if(mysqli_stmt_execute($stmt)){
					mysqli_stmt_store_result($stmt);
					//Verificacion de cuenta
					if(mysqli_stmt_num_rows($stmt) == 1){
						mysqli_stmt_bind_result($stmt, $Usua_ID, $Nombre, $hashed_password);
						if(mysqli_stmt_fetch($stmt)){
							if(password_verify($Clave, $hashed_password)){
								session_start();
								$_SESSION["loggedin"] = true;
								$_SESSION["Usua_ID"] = $Usua_ID;
								$_SESSION["Nombre"] = $Nombre;                            
								
								//Redireccionador
								header("location: my_welcome.php");
							}else{
								$password_err = "Contraseña invalida";
							}
						}
					}else{
						$username_err = "Esta cuenta no existe";
					}
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
					<h3 class="float-md-start mb-0">INVENTARIO #2537</h3>
					<nav class="nav nav-masthead justify-content-center float-md-end">
						<a class="nav-link" href="my_start.php">Inicio</a>
						<a class="nav-link" href="my_explorer.php">Explora</a>
						<a class="nav-link" href="my_contact.php">Contacto</a>
						<a class="nav-link active" aria-current="page" href="#">Sesion</a>
					</nav>
				</div>
			</header>

			<main class="px-3">
				<div class="wrapper">
					<h2>Inicio de sesion</h2>
					<p>Ingrese los datos de su cuenta</p>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
							<label>Usuario</label>
							<input type="text" name="Nombre" class="form-control" value="<?php echo $Nombre; ?>">
							<span class="help-block"><?php echo $username_err; ?></span>
						</div>    
						<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
							<label>Contraseña</label>
							<input type="Clave" name="Clave" class="form-control">
							<span class="help-block"><?php echo $password_err; ?></span>
						</div><br>
						<div class="form-group">
							<input type="submit" class="btn btn-primary" value="Iniciar Sesion">
						</div><br>
						<p>¿No tienes cuenta? <a href="my_register.php">Crea una cuenta aqui</a>.</p>
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