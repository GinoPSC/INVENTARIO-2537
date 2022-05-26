
<?php
	//Redireccionador
	session_start();
	if(isset($_SESSION["loggedin"]) && $_SESSION["loggedin"] === true){
		header("location: my_welcome.php");
		exit;
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
						<a class="nav-link active" href="#">Explora</a>
						<a class="nav-link" href="my_contact.php">Contacto</a>
						<a class="nav-link" href="my_login.php">Sesion</a>
					</nav>
				</div>
			</header>

			<main class="px-3">
				<p class="lead">Explorador en Mantencion</p>
				
				<?php
					require_once "my_config.php";
					$sql = "SELECT * FROM Local_de_ventas";
					if($result = mysqli_query($link, $sql)){
						$r_num = mysqli_num_rows($result);
						if ($r_num > 0) {
							while($row = $result->fetch_assoc()) {								
								echo "Local: ".$row["Nombre"]."<br>";
								echo "Direccion: ".$row["Direccion"]."<br>";
								echo "Telefono: ".$row["Telefono"]."<br><br>";
							}
						}
					}
				?>
				
			</main>

			<footer class="mt-auto text-white-50">
				<p>Diseño de pagina proporcionado por <a href="https://getbootstrap.com/" class="text-white">Bootstrap</a>, y diseñado por <a href="https://twitter.com/mdo" class="text-white">@mdo</a>.</p>
				<p>Motor de pagina por Gino Sciaraffia</p>
			</footer>
		</div>
	</body>
</html>