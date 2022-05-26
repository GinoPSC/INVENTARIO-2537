<?php
	class producto{
		
		private $local = 0;
		private $nombre = "";
		private $tipo = "";
		private $precio = 0;
		private $cantidad = 0;
		private $descripcion = "";
		public function __construct($l,$n,$t,$p,$c,$d){
			$this->local = $l;
			$this->nombre = $n;
			$this->tipo = $t;
			$this->precio = $p;
			$this->cantidad = $c;
			$this->descripcion = $d;
		}
		
		public function mostrar_local(){
			return $this->local;
		}
		
		public function mostrar_nombre(){
			return $this->nombre;
		}
		
		public function mostrar_precio(){
			return $this->precio;
		}
		
		public function mostrar_descripcion(){
			return $this->descripcion;
		}
		
		public function mostrar_informacion(){
			$info = "".
				"Producto: ".$this->nombre."<br>".
				"Tipo: ".$this->tipo."<br>".
				"Precio: ".$this->precio."<br>".
				"Cantidad: ".$this->cantidad."<br>".
				"Descripcion: ".$this->descripcion."<br>".
			"";
			return $info;
		}
	}

	class empleado{
		
		private $local = 0;
		private $rol = "";
		private $nombre = "";
		private $correo = "";
		public function __construct($l,$r,$n,$c){
			$this->local = $l;
			$this->rol = $r;
			$this->nombre = $n;
			$this->correo = $c;
		}
		
		public function mostrar_local(){
			return $this->local;
		}
		
		public function mostrar_nombre(){
			return $this->nombre;
		}
		
		public function mostrar_correo(){
			return $this->correo;
		}
		
		public function mostrar_informacion(){
			$info = "".
				"Nombre: ".$this->nombre."<br>".
				"Rol: ".$this->rol."<br>".
				"Correo: ".$this->correo."<br>".
			"";
			return $info;
		}
	}

	class local_ventas{
		
		private $lista_empleados = [];
		private $cantidad_empleados = 0;
		private $lista_productos = [];
		private $cantidad_productos = 0;
		public function __construct(){
			//
		}
		
		public function agregar_empleado($c){
			array_push($this->lista_empleados,$c);
			$this->cantidad_empleados++;
		}
		
		public function mostrar_empleado($id_usuario){
			return $this->lista_empleados[$id_usuario];
		}
		
		public function mostrar_cantidad_empleados(){
			return $this->cantidad_empleados;
		}
		
		public function agregar_producto($c){
			array_push($this->lista_productos,$c);
			$this->cantidad_productos++;
		}
		
		public function mostrar_producto($id_producto){
			return $this->lista_productos[$id_producto];
		}
		
		public function mostrar_cantidad_productos(){
			return $this->cantidad_productos;
		}
	}
	
	function cargar_empleados($link,$loc){
		$sql = "SELECT * FROM usuario";
		if($result = mysqli_query($link, $sql)){
			$r_num = mysqli_num_rows($result);
			if ($r_num > 0) {
				while($row = $result->fetch_assoc()) {
					$loc->agregar_empleado(new empleado(
						$row["Loc_ID"],
						$row["Rol_ID"],
						$row["Nombre"],
						$row["E_Mail"]
					));
				}
			}
		}
	}
	
	function cargar_productos($link,$loc){
		$sql = "SELECT * FROM producto";
		if($result = mysqli_query($link, $sql)){
			$r_num = mysqli_num_rows($result);
			if ($r_num > 0) {
				while($row = $result->fetch_assoc()) {
					$loc->agregar_producto(new producto(
						$row["Loc_ID"],
						$row["Nombre"],
						$row["Tipo_ID"],
						$row["Precio"],
						$row["Cantidad"],
						$row["Descripcion"]
					));
				}
			}
		}
	}
	
	//Main
	require_once "my_config.php";
	session_start();
	$tienda = new local_ventas();
	cargar_empleados($link,$tienda);
	cargar_productos($link,$tienda);
?>