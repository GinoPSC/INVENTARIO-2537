<?php
	class articulo{
		
		private $nombre = "";
		private $tipo = "";
		private $usuario = "";
		private $precio = 0;
		private $cantidad = 0;
		private $fecha = "";
		private $proposito = "";
		private $estado = true;
		public function __construct($u,$n,$t,$pre,$c,$f,$pro){
			$this->usuario = $u;
			$this->nombre = $n;
			$this->tipo = $t;
			$this->precio = $pre;
			$this->cantidad = $c;
			$this->fecha = $f;
			$this->proposito = $pro;
		}
		
		public function cambiar_estado($nuevo_estado){
			$this->estado = $nuevo_estado;
		}
		public function mostrar_estado(){
			return $this->estado;
		}
		public function mostrar_usuario(){
			return $this->usuario;
		}
		public function mostrar_informacion(){
			$info = "".
			"Usuario: ".$this->usuario."<br>".
			"Articulo: ".$this->nombre."<br>".
			"Tipo: ".$this->tipo."<br>".
			"Precio: ".$this->precio."<br>".
			"Cantidad: ".$this->cantidad."<br>".
			"Fecha: ".$this->fecha."<br>".
			"Proposito: ".$this->proposito."<br>".
			"<br>";
			return $info;
		}
	}

	class inventario{
		
		private $propietario = "";
		private $cantidad_articulos_creados = 0;
		private $cantidad_articulos_guardados = 0;
		private $lista_articulos = [[],[]];
		public function __construct($p){
			$this->propietario = $p;
		}
		
		public function mostrar_articulo($list,$art){
			return $this->lista_articulos[$list][$art];
		}
		
		public function añadir_articulo($n,$t,$pre,$c,$f,$pro){
			$art = new articulo($this->propietario,$n,$t,$pre,$c,$f,$pro);
			array_push($this->lista_articulos[0], $art);
			$this->cantidad_articulos_creados++;
		}
		
		public function guardar_articulo_vitrina($art){
			array_push($this->lista_articulos[1], $art);
			$this->cantidad_articulos_guardados++;
		}
		
		public function modificar_articulo($valor){
			return $this->lista_articulos[0][$valor];
		}
		
		public function mostrar_cantidad_guardada(){
			return $this->cantidad_articulos_guardados;
		}
		
		public function mostrar_cantidad_creada(){
			return $this->cantidad_articulos_creados;
		}
	}

	class cuenta_cliente{
		
		private $nombre = "";
		private $correo = "";
		private $lista_privada;
		public function __construct($n,$c){
			$this->nombre = $n;
			$this->correo = $c;
			$this->lista_privada = new inventario($n);
		}
		
		public function mostrar_inventario(){
			return $this->lista_privada;
		}
		public function mostrar_nombre(){
			return $this->nombre;
		}
	}

	class vitrina{
		
		private $lista_clientes = [];
		private $cantidad_clientes = 0;
		public function __construct(){
			//
		}
		
		public function agregar_cliente($c){
			array_push($this->lista_clientes,$c);
			$this->cantidad_clientes++;
		}
		
		public function mostrar_cliente($id_cuenta){
			return $this->lista_clientes[$id_cuenta];
		}
		
		public function mostrar_articulo_publicado($id_cuenta,$id_articulo){
			$ar_pu = $this->lista_clientes[$id_cuenta]->mostrar_inventario()->mostrar_articulo(0,$id_articulo);
			if($ar_pu->mostrar_estado()){
				return $ar_pu;
			}else{
				return null;
			}
		}
		
		public function guardar_articulo($cuenta_activa,$id_art){
			$this->cuenta_activa->mostrar_inventario()->guardar_articulo_vitrina($id_art);
		}
		
		public function mostrar_cantidad_clientes(){
			return $this->cantidad_clientes;
		}
	}
	
	function load_accounts($link){
		
		$cue = [];
		$sql = "SELECT * FROM users";
		if($result = mysqli_query($link, $sql)){
			$r_num = mysqli_num_rows($result);
			if ($r_num > 0) {
				while($row = $result->fetch_assoc()) {
					/*echo "Usuario: ".$row["username"]."<br>";
					echo "Correo: ".$row["email"]."<br><br>";*/
					$nueva_cuenta = new cuenta_cliente(
						$row["username"],
						$row["email"]
					);
					array_push($cue, $nueva_cuenta);
				}
				return $cue;
			}else{
				echo "0 results <br><br>";
			}
		}else{
			echo "no results <br><br>";
		}
		
		mysqli_close($link);
		return null;
	}
	
	function load_article($link,$cue){
		
		$sql = "SELECT * FROM articles";
		if($result = mysqli_query($link, $sql)){
			$r_num = mysqli_num_rows($result);
			if ($r_num > 0) {
				while($row = $result->fetch_assoc()) {
					/*echo "Usuario: ".$row["art_user"]."<br>";
					echo "Articulo: ".$row["art_name"]."<br>";
					echo "Tipo: ".$row["art_type"]."<br>";
					echo "Precio: ".$row["art_prce"]."<br>";
					echo "Cantidad: ".$row["art_cant"]."<br>";
					echo "Fecha: ".$row["art_date"]."<br>";
					echo "Proposito: ".$row["art_goal"]."<br><br>";*/
					for($ci=0;$ci<sizeof($cue);$ci++){
						if($cue[$ci]->mostrar_nombre() == $row["art_user"]){
							$cue[$ci]->mostrar_inventario()->añadir_articulo(
								$row["art_name"],
								$row["art_type"],
								$row["art_prce"],
								$row["art_cant"],
								$row["art_date"],
								$row["art_goal"]
							);
						}
					}
				}
			}else{
				echo "0 results <br><br>";
			}
		}else{
			echo "no results <br><br>";
		}
	}
	
	function load_article_rescued($link,$cue){
		
		$sql = "SELECT * FROM articles_rescued";
		if($result = mysqli_query($link, $sql)){
			$r_num = mysqli_num_rows($result);
			if ($r_num > 0) {
				while($row = $result->fetch_assoc()) {
					/*echo "Usuario: ".$row["art_hldr"]."<br>";
					echo "ID Articulo: ".$row["art_id"]."<br>";*/
					for($ci=0;$ci<sizeof($cue);$ci++){
						if($cue[$ci]->mostrar_nombre() == $row["art_hldr"]){
							$cue[$ci]->mostrar_inventario()->guardar_articulo_vitrina($row["art_id"]);
						}
					}
				}
			}else{
				echo "0 results <br><br>";
			}
		}else{
			echo "no results <br><br>";
		}
	}
	
	require_once "my_config.php";
	session_start();
	$vitrineo_facil = new vitrina();
	$cuentas = load_accounts($link);
	if($cuentas!=null){
		for($ci=0;$ci<sizeof($cuentas);$ci++){
			$vitrineo_facil->agregar_cliente($cuentas[$ci]);
		}
		load_article($link, $cuentas);
		load_article_rescued($link, $cuentas);
	}
?>