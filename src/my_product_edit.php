<?php
	include "INV_Codigo_A.php";
	$sub_id = "";
	$sub_nm = $_SESSION["Nombre"];
	
	require_once "my_config.php";
	$param_name = $param_precio = $param_descripcion = "";
	
	$P_NAME = $tienda->mostrar_producto($_SESSION['aux_2'])->mostrar_nombre();
	$P_PRE = $tienda->mostrar_producto($_SESSION['aux_2'])->mostrar_precio();
	$P_DES = $tienda->mostrar_producto($_SESSION['aux_2'])->mostrar_descripcion();
	
	if($_SERVER["REQUEST_METHOD"] == "POST"){
		if(trim($_POST['Nombre']) != $P_NAME){
			$sql = "update Producto set Nombre = '".$_POST['Nombre']."' where Nombre = '".$P_NAME."'";
			if($link->query($sql) === TRUE) {
				//echo "Record updated successfully";
				if($_SESSION["Nombre"] == $P_NAME){
					$_SESSION["Nombre"] = $_POST['Nombre'];
				}
			}else{
				echo "Error updating record: ".$link->error;
			}
		}
		
		if(trim($_POST['Precio']) != $P_PRE){
			$sql = "update Producto set Precio = '".$_POST['Precio']."' where Precio = '".$P_PRE."'";
			if($link->query($sql) === TRUE) {
				//echo "Record updated successfully";
			}else{
				echo "Error updating record: ".$link->error;
			}
		}
		
		if(trim($_POST['Descripcion']) != $P_DES){
			$sql = "update Producto set Descripcion = '".$_POST['Descripcion']."' where Descripcion = '".$P_DES."'";
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
					<h2>Editando Producto</h2>
					<form action="<?php echo htmlspecialchars($_SERVER["PHP_SELF"]); ?>" method="post">
						<div class="form-group">
							<label>Nombre</label>
							<input type="text" name="Nombre" class="form-control" value=<?php echo $P_NAME; ?>>
							<span class="help-block"></span>
						</div>
						
						<div class="form-group">
							<label>Precio</label>
							<input type="text" name="Precio" class="form-control" value=<?php echo $P_PRE; ?>>
							<span class="help-block"></span>
						</div>
						
						<div class="form-group">
							<label>Descripcion</label>
							<input type="text" name="Descripcion" class="form-control" rows="3" value=<?php echo $P_DES; ?>>
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