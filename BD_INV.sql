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

#Locales
INSERT INTO Local_de_ventas VALUES
(null,"Test_A","Santiago, Chile",12345678),
(null,"Test_B","Lima, Peru",12345678),
(null,"Test_C","Buenos Aires, Argentina",12345678),
(null,"Test_D","Chicago, EEUU",12345678),
(null,"Test_E","Roma, Italia",12345678);

select * from Local_de_ventas;
INSERT INTO Local_de_ventas (Nombre, Direccion, Telefono) VALUES ("Local_Test_0", "Dir_Test", 12345678);
#delete from Local_de_ventas;

#Roles de usuario
INSERT INTO Rol_de_usuario VALUES
(null,"Administrador"),
(null,"Empleado");

select * from Rol_de_usuario;
#delete from Rol_de_usuario;

#Tipos de productos
INSERT INTO Tipo_de_producto VALUES
(null,"Comestible"),
(null,"Bebestible"),
(null,"Electrodomestico");

select * from Tipo_de_producto;
#delete from Tipo_de_producto;

#Clases de transacciones
INSERT INTO Clase_de_transaccion VALUES
(null,"Venta"),
(null,"Compra"),
(null,"Retiro");

select * from Clase_de_transaccion;
#delete from Clase_de_transaccion;

#Productos para cada local

#Test_A
INSERT INTO Producto VALUES
(null,"Producto_A","Objeto",1000,2,1,1),
(null,"Producto_B","Objeto",2000,3,1,2),
(null,"Producto_C","Objeto",3000,5,1,3);

#Test_B
INSERT INTO Producto VALUES
(null,"Producto_A","Objeto",1000,1,2,1),
(null,"Producto_B","Objeto",2000,1,2,2),
(null,"Producto_C","Objeto",3000,5,2,3);

#Test_C
INSERT INTO Producto VALUES
(null,"Producto_A","Objeto",1000,5,3,1),
(null,"Producto_B","Objeto",2000,6,3,2),
(null,"Producto_C","Objeto",3000,5,3,3);

#Test_D
INSERT INTO Producto VALUES
(null,"Producto_A","Objeto",1000,10,4,1),
(null,"Producto_B","Objeto",2000,7,4,2),
(null,"Producto_C","Objeto",3000,3,4,3);

#Test_E
INSERT INTO Producto VALUES
(null,"Producto_A","Objeto",1000,4,5,1),
(null,"Producto_B","Objeto",2000,4,5,2),
(null,"Producto_C","Objeto",3000,4,5,3);

select * from Producto;
#delete from Producto;

#---------------------------- Datos de prueba ---------------------------------

#Empleados

#Test_A
INSERT INTO Usuario VALUES
(null,"Gino","Email_A",1234,1,1),
(null,"Manuel","Email_B",1234,2,1),
(null,"Rodrigo","Email_C",1234,1,1),
(null,"Pablo","Email_D",1234,2,1),
(null,"Carmen","Email_E",1234,1,1);

#Test_B
INSERT INTO Usuario VALUES
(null,"Gino","Email_A",1234,1,2),
(null,"Manuel","Email_B",1234,2,2),
(null,"Rodrigo","Email_C",1234,1,2);

#Test_C
INSERT INTO Usuario VALUES
(null,"Gino","Email_A",1234,1,3),
(null,"Manuel","Email_B",1234,2,3),
(null,"Rodrigo","Email_C",1234,1,3),
(null,"Pablo","Email_D",1234,2,3),
(null,"Carmen","Email_E",1234,1,3),
(null,"Joel","Email_F",1234,2,3);

#Test_D
INSERT INTO Usuario VALUES
(null,"Gino","Email_A",1234,1,4);

#Test_E
INSERT INTO Usuario VALUES
(null,"Gino","Email_A",1234,1,5),
(null,"Manuel","Email_B",1234,2,5);

select * from Usuario;

update Usuario
set Nombre = "magnesio"
where Nombre = "ginosc";
#delete from Usuario;

#Transacciones para cada local

#Test_A
INSERT INTO Transaccion (Loc_ID, Usua_ID, Clase_ID) VALUES
(1,1,1),
(1,2,2),
(1,3,3),
(1,4,1),
(1,5,2),
(1,1,3),
(1,2,1);

#Test_B
INSERT INTO Transaccion (Loc_ID, Usua_ID, Clase_ID) VALUES
(2,1,1),
(2,2,2),
(2,3,3),
(2,1,1),
(2,2,2),
(2,3,3);

#Test_C
INSERT INTO Transaccion (Loc_ID, Usua_ID, Clase_ID) VALUES
(3,6,1),
(3,2,2),
(3,3,3),
(3,4,1),
(3,5,2);

#Test_D
INSERT INTO Transaccion (Loc_ID, Usua_ID, Clase_ID) VALUES
(4,1,1),
(4,1,2),
(4,1,3),
(4,1,1),
(4,1,2),
(4,1,3),
(4,1,1),
(4,1,2),
(4,1,3),
(4,1,1),
(4,1,2),
(4,1,3),
(4,1,1),
(4,1,2);

#Test_E
INSERT INTO Transaccion (Loc_ID, Usua_ID, Clase_ID) VALUES
(5,1,1),
(5,2,2),
(5,1,3),
(5,1,1),
(5,2,2),
(5,2,3),
(5,1,1),
(5,2,2),
(5,1,3),
(5,1,1);

select * from Transaccion
where Fecha >  DATE_ADD(NOW(), interval -1 month);

#select * from Transaccion;
#delete from Transaccion;

#Grupos de productos por cada local

#Test_A
INSERT INTO Grupo_de_productos VALUES
(null,1000,1,1,1),
(null,1000,1,1,2),
(null,2000,1,2,3),
(null,2000,1,2,4),
(null,2000,1,2,5),
(null,3000,1,3,6),
(null,3000,1,3,7);

#Test_B
INSERT INTO Grupo_de_productos VALUES
(null,1000,1,1,8),
(null,2000,1,2,9),
(null,3000,1,3,10),
(null,3000,1,3,11),
(null,3000,1,3,12),
(null,3000,1,3,13);

#Test_C
INSERT INTO Grupo_de_productos VALUES
(null,2000,2,1,14),
(null,2000,1,2,14),
(null,8000,4,2,15),
(null,3000,1,3,15),
(null,3000,3,1,16),
(null,6000,2,3,16),
(null,2000,1,2,17),
(null,6000,2,3,18);

#Test_D
INSERT INTO Grupo_de_productos VALUES
(null,1000,1,1,19),
(null,2000,1,2,19),
(null,1000,1,1,20),
(null,1000,1,1,21),
(null,1000,1,1,22),
(null,1000,1,1,23),
(null,1000,1,1,24),
(null,1000,1,1,25),
(null,1000,1,1,26),
(null,1000,1,1,27),
(null,1000,1,1,28),
(null,2000,1,2,29),
(null,2000,1,2,30),
(null,3000,1,3,31),
(null,3000,1,3,32);

#Test_E
INSERT INTO Grupo_de_productos VALUES
(null,1000,1,1,33),
(null,1000,1,1,34),
(null,1000,1,1,35),
(null,2000,1,2,36),
(null,2000,1,2,37),
(null,2000,1,2,38),
(null,3000,1,3,39),
(null,3000,1,3,40),
(null,3000,1,3,41),
(null,1000,1,1,42),
(null,2000,1,2,42),
(null,3000,1,3,42);

select * from Grupo_de_productos;

select
	Transaccion.Loc_ID,
	Grupo_de_productos.*
from Grupo_de_productos
inner join Transaccion on (
	Grupo_de_productos.Tran_ID = Transaccion.Tran_ID
)where Transaccion.Loc_ID=1 order by Grup_ID;

select
	Transaccion.Loc_ID,
	Grupo_de_productos.*
from Grupo_de_productos
inner join Transaccion on (
	Grupo_de_productos.Tran_ID = Transaccion.Tran_ID
)where Transaccion.Loc_ID=2 order by Grup_ID;

select
	Transaccion.Loc_ID,
	Grupo_de_productos.*
from Grupo_de_productos
inner join Transaccion on (
	Grupo_de_productos.Tran_ID = Transaccion.Tran_ID
)where Transaccion.Loc_ID=3 order by Grup_ID;

select
	Transaccion.Loc_ID,
	Grupo_de_productos.*
from Grupo_de_productos
inner join Transaccion on (
	Grupo_de_productos.Tran_ID = Transaccion.Tran_ID
)where Transaccion.Loc_ID=4 order by Grup_ID;

select
	Transaccion.Loc_ID,
	Grupo_de_productos.*
from Grupo_de_productos
inner join Transaccion on (
	Grupo_de_productos.Tran_ID = Transaccion.Tran_ID
)where Transaccion.Loc_ID=5 order by Grup_ID;
#delete from Grupo_de_productos;
