#--------------------CREACION DE TABLAS-----------------------

CREATE TABLE Local_de_ventas (
	Loc_ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Nombre varchar(50),
	Direccion varchar(50),
	Telefono int NOT NULL
);

CREATE TABLE Rol_de_usuario (
	Rol_ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Rol varchar(50)
);

CREATE TABLE Tipo_de_producto (
	Tipo_ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Tipo varchar(50)
);

CREATE TABLE Clase_de_transaccion (
	Clase_ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Clase varchar(50)
);

CREATE TABLE Producto (
	Prod_ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Nombre varchar(50),
	Descripcion varchar(255),
	Precio int NOT NULL,
	Cantidad int NOT NULL,
	Loc_ID int,
	Tipo_ID int,
	FOREIGN KEY (Loc_ID) REFERENCES Local_de_ventas(Loc_ID),
	FOREIGN KEY (Tipo_ID) REFERENCES Tipo_de_producto(Tipo_ID)
);

CREATE TABLE Usuario (
	Usua_ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Nombre varchar(50) NOT NULL UNIQUE,
	Clave varchar(250) NOT NULL UNIQUE,
	E_Mail varchar(50) NOT NULL UNIQUE,
	Rol_ID int,
	Loc_ID int,
	FOREIGN KEY (Loc_ID) REFERENCES Local_de_ventas(Loc_ID),
	FOREIGN KEY (Rol_ID) REFERENCES Rol_de_usuario(Rol_ID)
);

CREATE TABLE Transaccion (
	Tran_ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Fecha TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
	Comentario varchar(255),
	Loc_ID int,
	Usua_ID int,
	Clase_ID int,
	FOREIGN KEY (Loc_ID) REFERENCES Local_de_ventas(Loc_ID),
	FOREIGN KEY (Usua_ID) REFERENCES Usuario(Usua_ID),
	FOREIGN KEY (Clase_ID) REFERENCES Clase_de_transaccion(Clase_ID)
);

CREATE TABLE Grupo_de_productos (
	Grup_ID int NOT NULL AUTO_INCREMENT PRIMARY KEY,
	Precio int NOT NULL,
	Cantidad int NOT NULL,
	Prod_ID int,
	Tran_ID int,
	FOREIGN KEY (Prod_ID) REFERENCES Producto(Prod_ID),
	FOREIGN KEY (Tran_ID) REFERENCES Transaccion(Tran_ID)
);

#---------------------------- Seed ---------------------------------

#Locales de ventas
INSERT INTO Local_de_ventas VALUES
(null, "Local Centro", "Region, Pais", 12345678);

#Roles de usuario
INSERT INTO Rol_de_usuario VALUES
(null, "Administrador"),
(null, "Empleado");

#Tipos de productos
INSERT INTO Tipo_de_producto VALUES
(null, "Comestible"),
(null, "Bebestible"),
(null, "Electrodomestico");

#Clases de transacciones
INSERT INTO Clase_de_transaccion VALUES
(null, "Venta"),
(null, "Compra"),
(null, "Retiro");

#---------------------------- Datos de prueba ---------------------------------

#Productos
INSERT INTO Producto VALUES
(null, "Bicicleta BMX", "Ejercicio y diversión fuera de casa", 1000000,0,1,1),
(null, "Bebida Coca-Cola", "Refrescante sabor para toda la familia", 1000,0,1,1);

#Usuarios
INSERT INTO Usuario VALUES
(null, "user", "admin", "user@gmail.com", 1,1);