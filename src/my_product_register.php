<?php
	require_once "my_config.php";
	
	//Redireccionador
	session_start();
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
		header("location: my_login.php");
		exit;
	}
	
	$product_name = $product_desc = "";
	$product_price = 0;
	
	$product_name_err = $product_price_err = $product_desc_err = "";

	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(empty(trim($_POST["product_name"]))){
			$product_name_err = "Porfavor ingrese un nombre para su producto";
		}else{
			$sql = "SELECT Prod_ID FROM producto WHERE Nombre = ?";
			//nombre
			if($stmt = mysqli_prepare($link, $sql)){
				mysqli_stmt_bind_param($stmt, "s", $param_prod_name);
				$param_prod_name = trim($_POST["product_name"]);
				if(mysqli_stmt_execute($stmt)){
					mysqli_stmt_store_result($stmt);
					if(mysqli_stmt_num_rows($stmt) == 1){
						$product_name_err = "Este nombre ya lo usa otro producto";
					}else{
						$product_name = trim($_POST["product_name"]);
					}
				}else{
					echo "Ha ocurrido un error, porfavor intente mas tarde";
				}
				mysqli_stmt_close($stmt);
			}
		}
		
		if(empty(trim($_POST["product_price"]))){
			$product_price_err = "Porfavor ingrese un precio distinto";
		}else if(trim($_POST["product_price"] <= 0)){
			$product_price_err = "Porfavor ingrese una cantidad mayor a CERO";
		}else{
			$sql = "SELECT Prod_ID FROM producto WHERE Precio = ?";
			//precio
			if($stmt = mysqli_prepare($link, $sql)){
				mysqli_stmt_bind_param($stmt, "i", $param_art_prce);
				$param_art_prce = trim($_POST["product_price"]);
				if(mysqli_stmt_execute($stmt)){
					mysqli_stmt_store_result($stmt);
					$product_price = trim($_POST["product_price"]);
				}else{
					echo "Ha ocurrido un error, porfavor intente mas tarde";
				}
				mysqli_stmt_close($stmt);
			}
		}
		
		if(empty(trim($_POST["product_desc"]))){
			$product_desc_err = "Porfavor ingrese una descripcion para su producto";
		}else{
			$sql = "SELECT Prod_ID FROM producto WHERE Descripcion = ?";
			//descripcion
			if($stmt = mysqli_prepare($link, $sql)){
				mysqli_stmt_bind_param($stmt, "s", $param_prod_desc);
				$param_prod_desc = trim($_POST["product_desc"]);
				if(mysqli_stmt_execute($stmt)){
					mysqli_stmt_store_result($stmt);
					$product_desc = trim($_POST["product_desc"]);
				}else{
					echo "Ha ocurrido un error, porfavor intente mas tarde";
				}
				mysqli_stmt_close($stmt);
			}
		}
		
		if(
			empty($product_name_err) &&
			empty($product_price_err) &&
			empty($product_desc_err)
		){
			$sql = "INSERT INTO producto (
				Nombre,
				Descripcion,
				Precio,
				Cantidad,
				Loc_ID,
				Tipo_ID
			) VALUES (?, ?, ?, ?, ?, ?)";
			if($stmt = mysqli_prepare($link, $sql)){
				mysqli_stmt_bind_param(
					$stmt, 
					"ssiiii", 
					$param_prod_name, 
					$param_prod_desc,
					$param_prod_prce,
					$param_prod_cant,
					$param_prod_LID,
					$param_prod_TID
				);
				$param_prod_name = $product_name;
				$param_prod_desc = $product_desc;
				$param_prod_prce = $product_price;
				$param_prod_cant = 0;
				$param_prod_LID = 1;
				$param_prod_TID = 1;
				
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
						<a class="nav-link" href="my_welcome_A.php">Empleados</a>
						<a class="nav-link active" href="#">Productos</a>
						<a class="nav-link" href="my_logout.php">Cerrar</a>
					</nav>
				</div>
			</header>

			<main class="px-3">
				<div class="wrapper">
					<h2>Nuevo Producto</h2>
					<p>Indique los datos del producto nuevo</p>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="form-group <?php echo (!empty($product_name_err)) ? 'has-error' : ''; ?>">
							<label>Nombre</label>
							<input type="text" name="product_name" class="form-control" value="<?php echo $product_name; ?>">
							<span class="help-block"><?php echo $product_name_err; ?></span>
						</div>
						
						<div class="form-group <?php echo (!empty($product_price_err)) ? 'has-error' : ''; ?>">
							<label>Precio</label>
							<input type="text" name="product_price" class="form-control" value="<?php $product_price; ?>">
							<span class="help-block"><?php echo $product_price_err; ?></span>
						</div>
						
						<div class="form-group <?php echo (!empty($product_desc_err)) ? 'has-error' : ''; ?>">
							<label>Descripcion</label>
							<textarea type="text" name="product_desc" class="form-control" rows="3" value="<?php echo $product_desc; ?>"></textarea>
							<span class="help-block"><?php echo $product_desc_err; ?></span>
						</div><br>
						
						<div class="form-group">
							<input type="submit" class="btn btn-primary" value="Agregar Articulo">
							<a href="my_welcome_B.php" class="btn btn-danger">Cancelar</a>
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