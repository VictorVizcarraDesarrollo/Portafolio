CREATE DATABASE Prestamos;

USE Prestamos;

CREATE TABLE CatClientes (
	idCliente INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	cNombre VARCHAR(30),
	cApellidoPaterno VARCHAR(30),
	cApellidoMaterno VARCHAR(30),
	dFechaNacimiento TIMESTAMP,
	bPrestamoBloqueado BOOLEAN,
	bActivo BOOLEAN
);

INSERT INTO CatClientes (cNombre, cApellidoPaterno, cApellidoMaterno, dFechaNacimiento, bPrestamoBloqueado, bActivo)
VALUES( 'Victor Manuel', 'Vizcarra', 'Bejarano', '19930301', 0, 1 );

CREATE TABLE CatMontosPlazos (
	idMonto INTEGER UNSIGNED AUTO_INCREMENT PRIMARY KEY,
	cDescripcion VARCHAR(100),
	nMonto BIGINT,
	nPlazos INTEGER,
	nInteres BIGINT,
	nAbono FLOAT,
	bActivo BOOLEAN
);

INSERT INTO CatMontosPlazos ( cDescripcion, nMonto, nPlazos, nInteres, nAbono, bActivo )
VALUES ( '$3000 a 12 pagos quincenales de plazo' , 3000,12,900,325,1 ) 
,( '$3000 a 18 pagos quincenales de plazo' , 3000,18,1110,228.33,1 ) 
,( '$3000 a 24 pagos quincenales de plazo' , 3000,24,1350,181.25,1 ) 
,( '$3000 a 30 pagos quincenales de plazo' , 3000,30,1560,152,1 ) 
,( '$3000 a 36 pagos quincenales de plazo' , 3000,36,1800,133.33,1 ) 
,( '$3000 a 42 pagos quincenales de plazo' , 3000,42,2010,119.29,1 ) 
,( '$7000 a 12 pagos quincenales de plazo' , 7000,12,2100,758.33,1 ) 
,( '$7000 a 18 pagos quincenales de plazo' , 7000,18,2590,532.78,1 ) 
,( '$7000 a 24 pagos quincenales de plazo' , 7000,24,3150,422.92,1 ) 
,( '$7000 a 30 pagos quincenales de plazo' , 7000,30,3640,354.67,1 ) 
,( '$7000 a 36 pagos quincenales de plazo' , 7000,36,4200,311.11,1 ) 
,( '$7000 a 42 pagos quincenales de plazo' , 7000,42,4690,278.33,1 ) 
,( '$15000 a 12 pagos quincenales de plazo' , 15000,12,4500,1625,1 ) 
,( '$15000 a 18 pagos quincenales de plazo' , 15000,18,5550,1141.67,1 ) 
,( '$15000 a 24 pagos quincenales de plazo' , 15000,24,6750,906.25,1 ) 
,( '$15000 a 30 pagos quincenales de plazo' , 15000,30,7800,760,1 ) 
,( '$15000 a 36 pagos quincenales de plazo' , 15000,36,9000,666.67,1 ) 
,( '$15000 a 42 pagos quincenales de plazo' , 15000,42,10050,596.43,1 ) 
,( '$25000 a 12 pagos quincenales de plazo' , 25000,12,7500,2708.33,1 ) 
,( '$25000 a 18 pagos quincenales de plazo' , 25000,18,9250,1902.78,1 ) 
,( '$25000 a 24 pagos quincenales de plazo' , 25000,24,11250,1510.42,1 ) 
,( '$25000 a 30 pagos quincenales de plazo' , 25000,30,13000,1266.67,1 ) 
,( '$25000 a 36 pagos quincenales de plazo' , 25000,36,15000,1111.11,1 ) 
,( '$25000 a 42 pagos quincenales de plazo' , 25000,42,16750,994.05,1 ) 
,( '$40000 a 12 pagos quincenales de plazo' , 40000,12,12000,4333.33,1 ) 
,( '$40000 a 18 pagos quincenales de plazo' , 40000,18,14800,3044.44,1 ) 
,( '$40000 a 24 pagos quincenales de plazo' , 40000,24,18000,2416.67,1 ) 
,( '$40000 a 30 pagos quincenales de plazo' , 40000,30,20800,2026.67,1 ) 
,( '$40000 a 36 pagos quincenales de plazo' , 40000,36,24000,1777.78,1 ) 
,( '$40000 a 42 pagos quincenales de plazo' , 40000,42,26800,1590.48,1 );

--	SELECT * FROM CatClientes;
--	SELECT * FROM CatMontosPlazos;