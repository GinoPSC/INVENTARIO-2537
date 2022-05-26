<?php
	include "INV_Codigo_A.php";
	
	if($_SESSION["prod_count"] === 0){
		echo "<h4>Debes agregar un producto para continuar</h4>";
		$_SESSION["prod_allowed"] = false;
	}
	
	$sub_id = "";
	$sub_nm = $_SESSION["Nombre"];
?>

<!DOCTYPE html>
<html lang="en">
	<head></head>
	<body>
		<div class="pg_err"><span class="help-block text-danger"></span></div>
		<?php
			$p_cant = $tienda->mostrar_cantidad_productos();
			for($i=0;$i<$_SESSION["prod_count"];$i++){
				echo "".
					"<div class='text-dark'>".
						"<div class='form-group text-dark'>".
							"<label>Seleccione el producto ".($i+1)."</label>".
							"<select id='group_prod_id_".$i."' name='PID".$i."' class='form-control'>".
								"<option value=''>---------</option>";
								for($j=0;$j<$p_cant;$j++){
									echo "<option value=".($j+1).">".$tienda->mostrar_producto($j)->mostrar_nombre()."</option>";
								}echo "".
							"</select>".
						"</div>".
						
						"<div class='form-group'>".
							"<label>Ingrese un precio</label>".
							"<input type='text' id='grup_precio_".$i."' name='PRE".$i."' class='form-control'>".
						"</div>".
						
						"<div class='form-group'>".
							"<label>Ingrese una cantidad</label>".
							"<input type='text' id='grup_cantidad_".$i."' name='CAN".$i."' class='form-control'>".
						"</div>".
					"</div>".
				"<br>";
			}
		?>
		
		<div class="form-group" style="overflow:auto;">
			<div style="float:right;">
				<button type="button" onclick="direct_submit()">Siguiente</button>
				<a href="reset_regist.php" class="text-white">
					<button type="button" class="bg-danger">Cancelar</a>
				</a>
			</div>
		</div>
		
	</body>
</html>