<?php
	require_once "my_config.php";
	
	//Redireccionador
	session_start();
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
		header("location: my_login.php");
		exit;
	}
	
	$Nombre = $E_Mail = $Clave = $confirm_password = "";
	$username_err = $email_err = $password_err = $confirm_password_err = "";

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(empty(trim($_POST["Nombre"]))){
			$username_err = "Porfavor ingrese un nombre";
		}else{
			$sql = "SELECT Usua_ID FROM Usuario WHERE Nombre = ?";
			//Usuario
			if($stmt = mysqli_prepare($link, $sql)){
				mysqli_stmt_bind_param($stmt, "s", $param_username);
				$param_username = trim($_POST["Nombre"]);
				if(mysqli_stmt_execute($stmt)){
					mysqli_stmt_store_result($stmt);
					if(mysqli_stmt_num_rows($stmt) == 1){
						$username_err = "Este nombre ya se encuentra en uso";
					}else{
						$Nombre = trim($_POST["Nombre"]);
					}
				}else{
					echo "Ha ocurrido un error, porfavor intente mas tarde";
				}
				mysqli_stmt_close($stmt);
			}
		}
		
		if(empty(trim($_POST["E_Mail"]))){
			$email_err = "Porfavor ingrese un correo";
		}else{
			$sql = "SELECT Usua_ID FROM Usuario WHERE E_Mail = ?";
			//Correo
			if($stmt = mysqli_prepare($link, $sql)){
				mysqli_stmt_bind_param($stmt, "s", $param_email);
				$param_email = trim($_POST["E_Mail"]);
				if(mysqli_stmt_execute($stmt)){
					mysqli_stmt_store_result($stmt);
					if(mysqli_stmt_num_rows($stmt) == 1){
						$email_err = "Este correo ya se encuentra en uso";
					}else{
						$E_Mail = trim($_POST["E_Mail"]);
					}
				}else{
					echo "Ha ocurrido un error, porfavor intente mas tarde";
				}
				mysqli_stmt_close($stmt);
			}
		}
		
		//Contraseña
		if(empty(trim($_POST["Clave"]))){
			$password_err = "Porfavor ingrese una contraseña";     
		}elseif(strlen(trim($_POST["Clave"])) < 6){
			$password_err = "La contraseña debe tener minimo 6 caracteres";
		}else{
			$Clave = trim($_POST["Clave"]);
		}
		if(empty(trim($_POST["confirm_password"]))){
			$confirm_password_err = "Porfavor reingrese la contraseña";     
		}else{
			$confirm_password = trim($_POST["confirm_password"]);
			if(empty($password_err) && ($Clave != $confirm_password)){
				$confirm_password_err = "Las contraseñas no coinciden";
			}
		}
		
		if(empty($username_err) && empty($email_err) && empty($password_err) && empty($confirm_password_err)){
			$sql = "INSERT INTO Usuario (Nombre, E_Mail, Clave, Rol_ID, Loc_ID) VALUES (?, ?, ?, ?, ?)";
			if($stmt = mysqli_prepare($link, $sql)){
				mysqli_stmt_bind_param($stmt, "sssii", $param_username, $param_email, $param_password, $param_RID, $param_LID);
				$param_username = $Nombre;
				$param_email = $E_Mail;
				$param_password = password_hash($Clave, PASSWORD_DEFAULT);
				$param_RID = 2;
				$param_LID = 1;
				if(mysqli_stmt_execute($stmt)){
					//Redireccionador
					header("location: my_login.php");
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
						<a class="nav-link" href="my_welcome.php">Inicio</a>
						<a class="nav-link active" href="#">Empleados</a>
						<a class="nav-link" href="my_welcome_B.php">Productos</a>
						<a class="nav-link" href="my_logout.php">Cerrar</a>
					</nav>
				</div>
			</header>

			<main class="px-3">
				<div class="wrapper">
					<h2>Nuevo empleado</h2>
					<p>Indique los datos del usuario nuevo</p>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
							<label>Nombre</label>
							<input type="text" name="Nombre" class="form-control" value="<?php echo $Nombre; ?>">
							<span class="help-block"><?php echo $username_err; ?></span>
						</div>
						
						<div class="form-group <?php echo (!empty($email_err)) ? 'has-error' : ''; ?>">
							<label>Correo</label>
							<input type="text" name="E_Mail" class="form-control" value="<?php echo $E_Mail; ?>">
							<span class="help-block"><?php echo $email_err; ?></span>
						</div> 
						
						<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
							<label>Contraseña</label>
							<input type="Clave" name="Clave" class="form-control" value="<?php echo $Clave; ?>">
							<span class="help-block"><?php echo $password_err; ?></span>
						</div>
						
						<div class="form-group <?php echo (!empty($confirm_password_err)) ? 'has-error' : ''; ?>">
							<label>Reingrese Contraseña</label>
							<input type="Clave" name="confirm_password" class="form-control" value="<?php echo $confirm_password; ?>">
							<span class="help-block"><?php echo $confirm_password_err; ?></span>
						</div><br>
						
						<div class="form-group">
							<input type="submit" class="btn btn-primary" value="Crear Cuenta">
							<a href="my_welcome_A.php" class="btn btn-danger">Cancelar</a>
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