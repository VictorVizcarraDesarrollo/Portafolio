<?php

$config = include 'config.php';

try {
	$conexion = new PDO('mysql:host'. $config['db']['host'], $config['db']['user'], $config['db']['pass'], $config['db']['options']);

	$sql = file_get_contents('database/ambientemysql.sql');

	$conexion->exec($sql);

	echo "Ambiente de la base de datos Prestamos ejecutado correctamente";
} catch (PDOException $th) {
	echo $th->getMessage();
}