<?php
	include "INV_Codigo_A.php";
	
	//Redireccionador
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
		header("location: my_login.php");
		exit;
	}
	$sub_nm = $_SESSION["Nombre"];
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
		<link href="cover.css" rel="stylesheet">
		<script src="http://ajax.googleapis.com/ajax/libs/jquery/1.11.2/jquery.min.js"></script>
	</head>

	<body class="text-center text-white bg-dark">
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
				<div id="Ventana_A">			
					<br><p><a href="my_employee_register.php" class="btn btn-info">Añadir Empleado</a></p><br>
			
					<form action="" method="POST">
						<div class="row row-cols-1 row-cols-sm-2 row-cols-md-2 g-3">
							<?php
								$EC = $tienda->mostrar_cantidad_empleados();
								for($i=0;$i<$EC;$i++){
									echo "".
										"<div class='col'>".
											"<div class='card shadow-sm text-dark h-100'>".
												"<div class='card-body'>";
													echo $tienda->mostrar_empleado($i)->mostrar_informacion()."<br>";
													echo "".
														"<button type='submit' name='u_edit' value='$i'".
														"class='btn btn-sm btn-outline-secondary' >Editar</button><br><br>".
													"";
											echo "</div>".
										"</div>".
									"</div>";
								}
							?>
							<div class='col'>
								<div class='card border-light bg-transparent shadow-sm h-100'>
									<div class='card-body'>
										<p>
											Proximamente mas empleados
										</p>
									</div>
								</div>
							</div>
						</div>
					</form>
					
					<br><br>
				</div>
				
				<p>
					<a href="my_transaction.php" class="btn btn-light">Realizar Transaccion</a>
					<a href="my_reset_password.php" class="btn btn-warning">Restablecer contraseña</a>
					<a href="my_logout.php" class="btn btn-danger">Cerrar sesion</a>
				</p>
				
				<?php
					if (isset($_POST["u_edit"])){
						$_SESSION['aux_1'] = $_POST["u_edit"];
						echo "
							<script>
								$.ajax({
									type: 'GET',
									url: 'my_user_edit.php',
									success: function (data) {
										document.getElementById('Ventana_A').innerHTML = data; 
									}
									});
							</script>
						";
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