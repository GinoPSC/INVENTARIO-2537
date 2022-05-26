<?php	
	//Redireccionador
	session_start();
	if(!isset($_SESSION["loggedin"]) || $_SESSION["loggedin"] !== true){
		header("location: my_login.php");
		exit;
	}
	
	if(isset($_SESSION["aux_3"]) === false){
		$_SESSION["prod_count"] = 0;
		$_SESSION["step_num"] = 0;
		$_SESSION["aux_3"] = true;
	}
	
	if($_SESSION["step_num"] == 1){
		echo "<body onload='step_b()'></body>";
	}else if($_SESSION["step_num"] == 2){
		echo "<body onload='step_c()'></body>";
	}
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){		
		if($_SESSION["step_num"] == 0){
			$_SESSION["prod_count"] = trim($_POST["PC"]);
			$_SESSION["clase_id"] = trim($_POST["tran_class_id"]);
			echo "<body onload='step_b()'></body>";
			$_SESSION["step_num"] = 1;
		}else if($_SESSION["step_num"] == 1){
			for ($z = 0;$z<$_SESSION["prod_count"];$z++){
				$_SESSION["prod_id"][$z] = trim($_POST["PID".$z]);
				$_SESSION["precio"][$z] = trim($_POST["PRE".$z]);
				$_SESSION["cantidad"][$z] = trim($_POST["CAN".$z]);
			}
			echo "<body onload='step_c()'></body>";
			$_SESSION["step_num"] = 2;
			header("location: my_transaction.php");
		}else if($_SESSION["step_num"] == 2){
			$_SESSION["comentario"] = trim($_POST["tran_coment"]);
			$_SESSION["step_num"] = 3;
			save_sql();
		}
	}
	
	function save_sql(){
		$tran_coment = $_SESSION["comentario"];
		$tran_class_id = $_SESSION["clase_id"];
		
		for ($y = 0;$y<$_SESSION["prod_count"];$y++){
			$grup_prod_id[$y] = $_SESSION["prod_id"][$y];
			$grup_precio[$y] = $_SESSION["precio"][$y];
			$grup_cantidad[$y] = $_SESSION["cantidad"][$y];
		}
		
		require_once "my_config.php";
		$sql = "INSERT INTO transaccion (
			Comentario,
			Clase_ID,
			Loc_ID,
			Usua_ID
		) VALUES (?, ?, ?, ?)";
		if($stmt = mysqli_prepare($link, $sql)){
			mysqli_stmt_bind_param(
				$stmt, 
				"siii",
				$param_coment,
				$param_class,
				$param_tran_LID,
				$param_tran_UID
			);
			$param_coment = $tran_coment;
			$param_class = $tran_class_id;
			$param_tran_LID = 1;
			$param_tran_UID = 1;
			$tran_ID = null;
			
			if(mysqli_stmt_execute($stmt)){
				$sql = "SELECT * FROM transaccion";
				if($result = mysqli_query($link, $sql)){
					$r_num = mysqli_num_rows($result);
					if ($r_num > 0) {
						while($row = $result->fetch_assoc()) {
							$tran_ID = $row["Tran_ID"];
						}
					}
				}
				
				for ($m = 0;$m<$_SESSION["prod_count"];$m++){					
					$sql = "INSERT INTO grupo_de_productos (
						Prod_ID,
						Tran_ID,
						Precio,
						Cantidad
					) VALUES (?, ?, ?, ?)";
					if($stmt = mysqli_prepare($link, $sql)){
						mysqli_stmt_bind_param(
							$stmt, 
							"iiii",
							$param_grup_PID,
							$param_grup_TID,
							$param_precio,
							$param_cantidad
						);
						$param_grup_PID = (int)$grup_prod_id[$m];
						$param_grup_TID = $tran_ID;
						$param_precio = $grup_precio[$m];
						$param_cantidad = $grup_cantidad[$m];
						$param_grup_PID--;	
						mysqli_stmt_execute($stmt);
					}
					//Redireccionador
					$_SESSION["step_num"] = 0;
					header("location: my_welcome.php");
				}
			}else{
				echo "Ha ocurrido un error, porfavor intente mas tarde <br>";
				echo "DB ERROR: ".$link->error;
			}
			mysqli_stmt_close($stmt);
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
			* {
			  box-sizing: border-box;
			}

			body {
			  background-color: #f1f1f1;
			}

			#regForm {
			  background-color: #ffffff;
			  margin: 79px auto;
			  padding: 30px;
			  width: 80%;
			  min-width: 300px;
			}

			h1 {
			  text-align: center;  
			}

			input {
			  padding: 10px;
			  width: 100%;
			  font-size: 17px;
			  font-family: Raleway;
			  border: 1px solid #aaaaaa;
			}

			/* Mark input boxes that gets an error on validation: */
			input.invalid {
			  background-color: #ffdddd;
			}

			/* Hide all steps by default: */
			.tab {
			  display: none;
			}

			button {
			  background-color: #04AA6D;
			  color: #ffffff;
			  border: none;
			  padding: 10px 20px;
			  font-size: 17px;
			  font-family: Raleway;
			  cursor: pointer;
			}

			button:hover {
			  opacity: 0.8;
			}

			#prevBtn {
			  background-color: #bbbbbb;
			}

			/* Make circles that indicate the steps of the form: */
			.step {
			  height: 15px;
			  width: 15px;
			  margin: 0 2px;
			  background-color: #bbbbbb;
			  border: none;  
			  border-radius: 50%;
			  display: inline-block;
			  opacity: 0.5;
			}

			.step.active {
			  opacity: 1;
			}

			/* Mark the steps that are finished and valid: */
			.step.finish {
			  background-color: #04AA6D;
			}
		</style>
		
		<link href="cover.css" rel="stylesheet">
		<script type="text/javascript" src="https://ajax.googleapis.com/ajax/libs/jquery/3.5.1/jquery.min.js"></script>
	</head>

	<body class="text-white bg-dark">
		<div class="cover-container w-100 p-3 mx-auto flex-column">
			<header class="mb-auto">
				<div>
					<h3 class="float-md-start mb-0">Hola <b><?php echo htmlspecialchars($_SESSION["Nombre"]); ?></b></h3>
					<nav class="nav nav-masthead justify-content-center float-md-end">
						<a class="nav-link active" href="#">Inicio</a>
						<a class="nav-link" href="my_welcome_A.php">Empleados</a>
						<a class="nav-link" href="my_welcome_B.php">Productos</a>
						<a class="nav-link" href="my_logout.php">Cerrar</a>
					</nav>
				</div>
			</header>
			
			<main class="px-3">
				<form id="regForm" action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
					<div class="text-dark text-center">
						<h2>Nueva Transaccion</h2>
						<p>Ingrese los datos para completar la transaccion</p>
					</div>
					
					<div id="Ventana_B">
						<div class="form-group">
							<label class="text-dark">Seleccione la clase de transaccion a realizar</label>
							<p><select name='tran_class_id' class='form-control' id='tran_class'>
								<option value='0'>---------</option>
								<option value='1'>Venta</option>
								<option value='2'>Compra</option>
								<option value='3'>Retiro</option>Prod_Warn
							</select>
							<div class="tc_err"><span class="help-block text-danger"></span></div></p>
							
							<p><input class='form-control' placeholder="Ingrese la cantidad de productos diferentes" id="Pcant" name="PC"></p>
						</div>
						
						<div class="form-group" style="overflow:auto;">
							<div style="float:right;">
								<button type="button" onclick="new_step()">Siguiente</button>
								<a href="reset_regist.php" class="text-white">
									<button type="button" class="bg-danger">Cancelar</a>
								</a>
							</div>
						</div>
					</div>
					
					<!-- Circles which indicates the steps of the form: -->
					<div style="text-align:center;margin-top:40px;">
						<span class="step active" id="step_1"></span>
						<span class="step" id="step_2"></span>
						<span class="step" id="step_3"></span>
					</div>
				</form>

				<script>
					function step_b(){
						document.getElementById("step_1").className = "step finish";
						document.getElementById("step_2").className = "step active";
						document.getElementById("step_3").className = "step";
						$.ajax({
							type: 'GET',
							url: 'my_product_group.php',
							success: function (data) {
								document.getElementById("Ventana_B").innerHTML = data; 
							}
						});
					}
					
					function step_c(){
						document.getElementById("step_1").className = "step finish";
						document.getElementById("step_2").className = "step finish";
						document.getElementById("step_3").className = "step active";
						$.ajax({
							type: 'GET',
							url: 'my_transaction_P2.php',
							success: function (data) {
								document.getElementById("Ventana_B").innerHTML = data; 
							}
						});
					}
					
					function direct_submit(){
						var CompPID = true;
						var contador = <?php echo $_SESSION["prod_count"]; ?>;
						for(var n=0;n<contador;n++){
							if(document.getElementById("group_prod_id_"+n).value == ""){
								CompPID = false;
							}
							
							if(document.getElementById("grup_precio_"+n).value == ""){
								CompPID = false;
							}
							
							if(document.getElementById("grup_cantidad_"+n).value == ""){
								CompPID = false;
							}
						}
						if(contador === 0){CompPID = false;}
						
						if(CompPID){
							document.getElementById("regForm").submit();
							$('.pg_err span').text("");
						}else{
							$('.pg_err span').text("Debes agregar mas datos para continuar");
						}
					}
					
					function last_step(){
						if(document.getElementById("TA").value == ""){
							$('.ta_err span').text("Porfavor ingrese un comentario");
						}else{
							$('.ta_err span').text("");
							document.getElementById("regForm").submit();
						}
					}
					
					function new_step(){
						var CompS = false;
						
						if(document.getElementById("tran_class").selectedIndex == 0){
							$('.tc_err span').text("Porfavor seleccione una clase de transaccion");
						}else{
							$('.tc_err span').text("");
							CompS = true;
						}
						
						if(document.getElementById("Pcant").value > 0){
							if(CompS){document.getElementById("regForm").submit();}
						}else{
							document.getElementById("Pcant").className += " invalid";
						}
					}
				</script>
			</main>

			<footer class="mt-auto text-white-50 text-center">
				<p>Diseño de pagina proporcionado por <a href="https://getbootstrap.com/" class="text-white">Bootstrap</a>, y diseñado por <a href="https://twitter.com/mdo" class="text-white">@mdo</a>.</p>
				<p>Motor de pagina por Gino Sciaraffia</p>
			</footer>
		</div>
	</body>
</html>
