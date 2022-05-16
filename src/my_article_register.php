<?php
	require_once "my_config.php";
	
	//Redireccionador
	session_start();
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
		header("location: my_login.php");
		exit;
	}
	
	$article_name = $article_type = $article_user = $article_goal = "";
	$article_price = $article_amount = $article_state = 0;
	
	$article_name_err = $article_type_err = $article_user_err = $article_goal_err = "";
	$article_price_err = $article_amount_err = $article_state_err = "";

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(empty(trim($_POST["article_name"]))){
			$article_name_err = "Porfavor ingrese un nombre para su articulo";
		}else{
			$sql = "SELECT id FROM articles WHERE art_name = ?";
			//nombre
			if($stmt = mysqli_prepare($link, $sql)){
				mysqli_stmt_bind_param($stmt, "s", $param_art_name);
				$param_art_name = trim($_POST["article_name"]);
				if(mysqli_stmt_execute($stmt)){
					mysqli_stmt_store_result($stmt);
					if(mysqli_stmt_num_rows($stmt) == 1){
						$article_name_err = "Este nombre ya lo usa otro articulo";
					}else{
						$article_name = trim($_POST["article_name"]);
					}
				}else{
					echo "Ha ocurrido un error, porfavor intente mas tarde";
				}
				mysqli_stmt_close($stmt);
			}
		}
		
		if(empty(trim($_POST["article_type"]))){
			$article_type_err = "Porfavor ingrese el tipo de articulo a añadir";
		}else{
			$sql = "SELECT id FROM articles WHERE art_type = ?";
			//tipo
			if($stmt = mysqli_prepare($link, $sql)){
				mysqli_stmt_bind_param($stmt, "s", $param_art_type);
				$param_art_type = trim($_POST["article_type"]);
				if(mysqli_stmt_execute($stmt)){
					mysqli_stmt_store_result($stmt);
					$article_type = trim($_POST["article_type"]);
				}else{
					echo "Ha ocurrido un error, porfavor intente mas tarde";
				}
				mysqli_stmt_close($stmt);
			}
		}
		
		if(empty(trim($_POST["article_goal"]))){
			$article_goal_err = "Porfavor ingrese el proposito de su articulo";
		}else{
			$sql = "SELECT id FROM articles WHERE art_goal = ?";
			//proposito
			if($stmt = mysqli_prepare($link, $sql)){
				mysqli_stmt_bind_param($stmt, "s", $param_art_goal);
				$param_art_goal = trim($_POST["article_goal"]);
				if(mysqli_stmt_execute($stmt)){
					mysqli_stmt_store_result($stmt);
					$article_goal = trim($_POST["article_goal"]);
				}else{
					echo "Ha ocurrido un error, porfavor intente mas tarde";
				}
				mysqli_stmt_close($stmt);
			}
		}
		
		$sql = "SELECT id FROM articles WHERE art_user = ?";
		//usuario
		if($stmt = mysqli_prepare($link, $sql)){
			mysqli_stmt_bind_param($stmt, "s", $param_art_user);
			$param_art_user = trim($_SESSION["username"]);
			if(mysqli_stmt_execute($stmt)){
				mysqli_stmt_store_result($stmt);
				$article_user = trim($_SESSION["username"]);
			}else{
				echo "Ha ocurrido un error, porfavor intente mas tarde";
			}
			mysqli_stmt_close($stmt);
		}
		
		if(empty(trim($_POST["article_price"]))){
			$article_price_err = "Porfavor ingrese un precio distinto";
		}else if(trim($_POST["article_price"] <= 0)){
			$article_price_err = "Porfavor ingrese una cantidad mayor a CERO";
		}else{
			$sql = "SELECT id FROM articles WHERE art_prce = ?";
			//precio
			if($stmt = mysqli_prepare($link, $sql)){
				mysqli_stmt_bind_param($stmt, "i", $param_art_prce);
				$param_art_prce = trim($_POST["article_price"]);
				if(mysqli_stmt_execute($stmt)){
					mysqli_stmt_store_result($stmt);
					$article_price = trim($_POST["article_price"]);
				}else{
					echo "Ha ocurrido un error, porfavor intente mas tarde";
				}
				mysqli_stmt_close($stmt);
			}
		}
		
		if(empty(trim($_POST["article_amount"]))){
			$article_amount_err = "Porfavor ingrese una cantidad";
		}else if(trim($_POST["article_amount"] <= 0)){
			$article_amount_err = "Porfavor ingrese una cantidad mayor a CERO";
		}else{
			$sql = "SELECT id FROM articles WHERE art_cant = ?";
			//cantidad
			if($stmt = mysqli_prepare($link, $sql)){
				mysqli_stmt_bind_param($stmt, "i", $param_art_cant);
				$param_art_cant = trim($_POST["article_amount"]);
				if(mysqli_stmt_execute($stmt)){
					mysqli_stmt_store_result($stmt);
					$article_amount = trim($_POST["article_amount"]);
				}else{
					echo "Ha ocurrido un error, porfavor intente mas tarde";
				}
				mysqli_stmt_close($stmt);
			}
		}
		
		if(empty(trim($_POST["article_goal"]))){
			$article_goal_err = "Porfavor ingrese el proposito de su articulo";
		}else{
			$sql = "SELECT id FROM articles WHERE art_goal = ?";
			//proposito
			if($stmt = mysqli_prepare($link, $sql)){
				mysqli_stmt_bind_param($stmt, "s", $param_art_goal);
				$param_art_goal = trim($_POST["article_goal"]);
				if(mysqli_stmt_execute($stmt)){
					mysqli_stmt_store_result($stmt);
					$article_goal = trim($_POST["article_goal"]);
				}else{
					echo "Ha ocurrido un error, porfavor intente mas tarde";
				}
				mysqli_stmt_close($stmt);
			}
		}
		
		$sql = "SELECT id FROM articles WHERE art_stat = ?";
		//estado
		if($stmt = mysqli_prepare($link, $sql)){
			mysqli_stmt_bind_param($stmt, "i", $param_art_stat);
			$param_art_stat = trim(1);
			if(mysqli_stmt_execute($stmt)){
				mysqli_stmt_store_result($stmt);
				$article_state = trim(1);
			}else{
				echo "Ha ocurrido un error, porfavor intente mas tarde";
			}
			mysqli_stmt_close($stmt);
		}
		
		if(
			empty($article_name_err) &&
			empty($article_type_err) && 
			empty($article_user_err) && 
			empty($article_price_err) &&
			empty($article_amount_err) &&
			empty($article_goal_err) &&
			empty($article_state_err)
		){
			$sql = "INSERT INTO articles (
				art_name,
				art_type,
				art_user,
				art_prce,
				art_cant,
				art_goal,
				art_stat
			) VALUES (?, ?, ?, ?, ?, ?, ?)";
			if($stmt = mysqli_prepare($link, $sql)){
				mysqli_stmt_bind_param(
					$stmt, 
					"sssiisi", 
					$param_art_name, 
					$param_art_type,
					$param_art_user,
					$param_art_prce,
					$param_art_cant,
					$param_art_goal,
					$param_art_stat
				);
				$param_art_name = $article_name;
				$param_art_type = $article_type;
				$param_art_user = $article_user;
				$param_art_prce = $article_price;
				$param_art_cant = $article_amount;
				$param_art_goal = $article_goal;
				$param_art_stat = $article_state;
				if(mysqli_stmt_execute($stmt)){
					//Redireccionador
					header("location: my_welcome.php");
				}else{
					echo "Ha ocurrido un error, porfavor intente mas tarde <br>";
					echo "DB ERROR: ".$link->error;
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
			<h2>Agregar un nuevo Articulo</h2>
			<p>Indique los datos del articulo para su inclusion a la lista de Vitrineo Facil</p>
			<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
				<div class="form-group <?php echo (!empty($article_name_err)) ? 'has-error' : ''; ?>">
					<label>Nombre</label>
					<input type="text" name="article_name" class="form-control" value="<?php echo $article_name; ?>">
					<span class="help-block"><?php echo $article_name_err; ?></span>
				</div>
				
				<div class="form-group <?php echo (!empty($article_type_err)) ? 'has-error' : ''; ?>">
					<label>Tipo</label>
					<input type="text" name="article_type" class="form-control" value="<?php echo $article_type; ?>">
					<span class="help-block"><?php echo $article_type_err; ?></span>
				</div>
				
				<div class="form-group <?php echo (!empty($article_price_err)) ? 'has-error' : ''; ?>">
					<label>Precio</label>
					<input type="text" name="article_price" class="form-control" value="<?php $article_price; ?>">
					<span class="help-block"><?php echo $article_price_err; ?></span>
				</div>
				
				<div class="form-group <?php echo (!empty($article_amount_err)) ? 'has-error' : ''; ?>">
					<label>Cantidad</label>
					<input type="text" name="article_amount" class="form-control" value="<?php $article_amount; ?>">
					<span class="help-block"><?php echo $article_amount_err; ?></span>
				</div>
				
				<div class="form-group <?php echo (!empty($article_goal_err)) ? 'has-error' : ''; ?>">
					<label>Proposito</label>
					<input type="text" name="article_goal" class="form-control" value="<?php echo $article_goal; ?>">
					<span class="help-block"><?php echo $article_goal_err; ?></span>
				</div>
				
				<div class="form-group">
					<input type="submit" class="btn btn-primary" value="Agregar Articulo">
				</div>
				<p><a href="my_welcome.php">Volver</a></p>
			</form>
		</div>
		
	</body>
</html>