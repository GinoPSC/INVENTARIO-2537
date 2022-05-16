<?php
	include "VF_Codigo_A.php";
	$sub_id = "";
	$sub_nm = $_SESSION["username"];
?>

<!DOCTYPE html>
<html lang="en">
	<head></head>
	<body>
	
		<form action="" method="POST">
			<?php
				echo "Articulos:<br>";
				$cant_cli = $vitrineo_facil->mostrar_cantidad_clientes();
				for($i=0;$i<$cant_cli;$i++){
					$cant_art = $vitrineo_facil->mostrar_cliente($i)->mostrar_inventario()->mostrar_cantidad_creada();
					for($j=0;$j<$cant_art;$j++){
						$art_id = "";
						$art_id = $i."|".$j."|".$sub_nm;
						$art_nombre = $vitrineo_facil->mostrar_articulo_publicado($i,$j)->mostrar_usuario();
						echo "<br>".$vitrineo_facil->mostrar_articulo_publicado($i,$j)->mostrar_informacion();
							if($sub_nm != $art_nombre){
								echo "<button type='submit' name='art_save' value='$art_id'>Guardar Articulo</button>";
							}
						echo "<br><br>";
					}
				}
			?>
		</form>
		
		<h1>--------------------------------------</h1>
	
	</body>
</html>