<?php
	//Redireccionador
	session_start();
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
		header("location: my_welcome.php");
		exit;
	}
	require_once "my_config.php";
	$username = $password = "";
	$username_err = $password_err = "";

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		//Usuario
		if(empty(trim($_POST["username"]))){
			$username_err = "Porfavor ingrese un nombre";
		}else{
			$username = trim($_POST["username"]);
		}
		
		//Contraseña
		if(empty(trim($_POST["password"]))){
			$password_err = "Porfavor ingrese una contraseña";
		}else{
			$password = trim($_POST["password"]);
		}
		if(empty($username_err) && empty($password_err)){
			$sql = "SELECT id, username, password FROM users WHERE username = ?";
			if($stmt = mysqli_prepare($link, $sql)){
				mysqli_stmt_bind_param($stmt, "s", $param_username);
				$param_username = $username;
				if(mysqli_stmt_execute($stmt)){
					mysqli_stmt_store_result($stmt);
					//Verificacion de cuenta
					if(mysqli_stmt_num_rows($stmt) == 1){
						mysqli_stmt_bind_result($stmt, $id, $username, $hashed_password);
						if(mysqli_stmt_fetch($stmt)){
							if(password_verify($password, $hashed_password)){
								session_start();
								$_SESSION["loggedin"] = true;
								$_SESSION["id"] = $id;
								$_SESSION["username"] = $username;                            
								
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
 
<!DOCTYPE html>
<html lang="en">
	<head>
	
		<meta charset="UTF-8">
		<title>Vitrineo Facil</title>
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.css">
		<style type="text/css">
			body{ font: 14px sans-serif; }
			.wrapper{ width: 350px; padding: 20px; }
		</style>
		
	</head>
	<body>
	
		<div class="wrapper">
			<h2>Inicio de sesion</h2>
			<p>Ingrese los datos de su cuenta</p>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="form-group <?php echo (!empty($username_err)) ? 'has-error' : ''; ?>">
					<label>Usuario</label>
					<input type="text" name="username" class="form-control" value="<?php echo $username; ?>">
					<span class="help-block"><?php echo $username_err; ?></span>
				</div>    
				<div class="form-group <?php echo (!empty($password_err)) ? 'has-error' : ''; ?>">
					<label>Contraseña</label>
					<input type="password" name="password" class="form-control">
					<span class="help-block"><?php echo $password_err; ?></span>
				</div>
				<div class="form-group">
					<input type="submit" class="btn btn-primary" value="Iniciar Sesion">
				</div>
				<p>¿No tienes cuenta? <a href="my_register.php">Crea una cuenta aqui</a>.</p>
			</form>
		</div>
		
	</body>
</html>