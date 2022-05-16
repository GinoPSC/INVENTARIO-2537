<?php
	include "VF_Codigo_A.php";
	//Code Test
	function main_loop($cue,$vitrina){
		
		//inicio de sesion
		$test_cuenta = null;
		$test_usuario = $_SESSION["username"];

		for($ci=0;$ci<sizeof($cue);$ci++){
			if($test_usuario == $cue[$ci]->mostrar_nombre()){
				$test_cuenta = $cue[$ci];
			}
		}
		
		if($test_cuenta!=null){
			$start_loop = true;
		}
		
		if($start_loop){
			echo "Articulos Guardados:<br>";
			$cant_cli = $vitrina->mostrar_cantidad_clientes();
			$id_cl = 0;
			for($i=0;$i<$cant_cli;$i++){
				if($vitrina->mostrar_cliente($i)->mostrar_nombre() == $test_usuario){
					$id_cl = $i;
				}
			}
			$cant_art = $vitrina->mostrar_cliente($id_cl)->mostrar_inventario()->mostrar_cantidad_guardada();
			for($j=0;$j<$cant_art;$j++){
				$id_art = $vitrina->mostrar_cliente($id_cl)->mostrar_inventario()->mostrar_articulo(1,$j);
				$CL = explode("|",$id_art)[0];
				$AR = explode("|",$id_art)[1];
				echo "<br>".$vitrina->mostrar_articulo_publicado($CL,$AR)->mostrar_informacion();
			}
			if($cant_art == 0){
				echo "<br> No se ha guardado ningun articulo todavia <br><br>";
			}
		}
	}
	
	main_loop($cuentas,$vitrineo_facil);
	echo "<h1>--------------------------------------</h1>";
?>