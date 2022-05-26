<?php
	//Redireccionador
	session_start();
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

	<body class=" h-100 text-center text-white bg-dark">
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
				<div id="Ventana_A">
					<h2>¡Bienvenido a tu inventario!</h2>
				</div>
				
				<div class="container-fluid">
					<div class="row">
						<main class="w-100">
							<div class="d-flex justify-content-between flex-wrap flex-md-nowrap align-items-center pt-3 pb-2 mb-3 border-bottom">
								<h1 class="h2">Estadisticas</h1>
								
								<div class="btn-toolbar mb-2 mb-md-0">
									<div class="dropdown">
										<button class="btn btn-outline-secondary dropdown-toggle"type="button">
											<span data-feather="calendar"></span>
											Este mes
										</button>
									</div>
								</div>
								
							</div>
							
							<canvas class="my-4 w-100" id="myChart" width="900" height="380"></canvas>
						  
						</main>
					</div>
				</div>
				
				<script src="assets/dist/js/bootstrap.bundle.min.js"></script>
				<script
					src="https://cdn.jsdelivr.net/npm/feather-icons@4.28.0/dist/feather.min.js"
					integrity="sha384-uO3SXW5IuS1ZpFPKugNNWqTZRRglnUJK6UAZ/gxOX80nxEkN9NcGZTftn6RzhGWE"
					crossorigin="anonymous">
				</script>
				<script
					src="https://cdn.jsdelivr.net/npm/chart.js@2.9.4/dist/Chart.min.js"
					integrity="sha384-zNy6FEbO50N+Cg5wap8IKA4M/ZnLJgzc6w2NqACZaK0u0FXfOWRRJOnQtpZun8ha"
					crossorigin="anonymous">
				</script>
				
				<script>
					feather.replace({ 'aria-hidden': 'true' });
					var ctx = document.getElementById('myChart');
					
					var ejeY = [
						0
					];
					
					var ejeX = [
						'Test'
					];
					
					<?php
						require_once "my_config.php";
						$tr_id = [];
						$cl_id = [];
						$tr_cnt = 0;
						$sql = "select * from Transaccion where Fecha >  date_add(now(), interval -1 month)";
						if($result = mysqli_query($link, $sql)){
							$r_num = mysqli_num_rows($result);
							if ($r_num > 0) {
								while($row = $result->fetch_assoc()) {
									$tr_id[$tr_cnt] = $row["Tran_ID"];
									$cl_id[$tr_cnt] = $row["Clase_ID"];
									$tr_cnt++;
								}
							}
						}
						
						$gr_pr = [];
						for ($i = 0;$i<$tr_cnt;$i++){
							$gr_pr[$i] = 0;
							$sql = "select * from Grupo_de_productos where Tran_ID = ".$tr_id[$i];
							if($result = mysqli_query($link, $sql)){
								$r_num = mysqli_num_rows($result);
								if ($r_num > 0) {
									while($row = $result->fetch_assoc()) {
										if($cl_id[$i] == 0){
											$gr_pr[$i] += $row["Precio"]*$row["Cantidad"];
										}else{
											$gr_pr[$i] -= $row["Precio"]*$row["Cantidad"];
										}
									}
								}
							}
						}
						
						//Tran_ID, Clase_ID, Costo_Total
						//$transacciones[0],$transacciones[1],$gr_pr;
						$TT = [];
						for ($j = 0;$j<$tr_cnt;$j++){
							if($cl_id[$j] == 0){
								$TT[$j] = "Venta ".$tr_id[$j];
							}else if($cl_id[$j] == 1){
								$TT[$j] = "Compra ".$tr_id[$j];
							}else{
								$TT[$j] = "Retiro ".$tr_id[$j];
							}
						}
						
						for ($k = 0;$k<$tr_cnt;$k++){
							echo "ejeY.push(". $gr_pr[$k] .");";
							echo "ejeX.push('". $TT[$k] ."');";
						}
					?>
					
					var myChart = new Chart(ctx, {
						type: 'line',
						data: {
							labels: ejeX,
							datasets: [{
								data: ejeY,
								lineTension: 0,
								backgroundColor: 'transparent',
								borderColor: '#007bff',
								borderWidth: 4,
								pointBackgroundColor: '#007bff'
							}]
						},options: {
							scales: {
								yAxes: [{
									ticks: {
										beginAtZero: false
									}
								}]
							},legend: {
								display: false
							}
						}
					})
				</script>
				
				<p>
					<a href="my_transaction" class="btn btn-light">Realizar Transaccion</a>
					<a href="my_reset_password.php" class="btn btn-warning">Restablecer contraseña</a>
					<a href="my_logout.php" class="btn btn-danger">Cerrar sesion</a>
				</p>
			</main>

			<footer class="mt-auto text-white-50">
				<p>Diseño de pagina proporcionado por <a href="https://getbootstrap.com/" class="text-white">Bootstrap</a>, y diseñado por <a href="https://twitter.com/mdo" class="text-white">@mdo</a>.</p>
				<p>Motor de pagina por Gino Sciaraffia</p>
			</footer>
		</div>
	</body>
</html>