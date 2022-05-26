<?php
	include "INV_Codigo_A.php";
	$sub_id = "";
	$sub_nm = $_SESSION["Nombre"];
	
	require_once "my_config.php";
	$param_name = $param_email = "";
	
	$E_NAME = $tienda->mostrar_empleado($_SESSION['aux_1'])->mostrar_nombre();
	$E_EMAIL = $tienda->mostrar_empleado($_SESSION['aux_1'])->mostrar_correo();
	//echo "Editando a empleado: ".$E_NAME;
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(trim($_POST['Nombre']) != $E_NAME){
			$sql = "update Usuario set Nombre = '".$_POST['Nombre']."' where Nombre = '".$E_NAME."'";
			if($link->query($sql) === TRUE) {
				//echo "Record updated successfully";
				if($_SESSION["Nombre"] == $E_NAME){
					$_SESSION["Nombre"] = $_POST['Nombre'];
				}
			}else{
				echo "Error updating record: ".$link->error;
			}
		}
		
		if(trim($_POST['E_Mail']) != $E_EMAIL){
			$sql = "update Usuario set Correo = '".$_POST['E_Mail']."' where Correo = '".$E_EMAIL."'";
			if($link->query($sql) === TRUE) {
				//echo "Record updated successfully";
			}else{
				echo "Error updating record: ".$link->error;
			}
		}
		
		
		header("location: my_login.php");
	}
?>

<!DOCTYPE html>
<html lang="en">
	<head></head>
	<body>
		<main class="px-3">
			<br><br>
				<div class="wrapper">
					<h2>Editando Empleado</h2>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="form-group">
							<label>Nombre</label>
							<input type="text" name="Nombre" class="form-control" value=<?php echo $E_NAME; ?>>
							<span class="help-block"></span>
						</div>
						
						<div class="form-group">
							<label>Correo</label>
							<input type="text" name="E_Mail" class="form-control"value=<?php echo $E_EMAIL; ?>>
							<span class="help-block"></span>
						</div><br>
						
						<div class="form-group">
							<input type="submit" class="btn btn-primary" value="Confirmar">
							<a href="my_welcome_A.php" class="btn btn-danger">Cancelar</a>
						</div>
					</form>
				</div>
			<br><br><br>
		</main>
	
	</body>
</html>