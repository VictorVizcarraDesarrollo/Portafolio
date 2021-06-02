<?php

if (isset($_POST['guardar'])) {
	$resultado = [
		'error' => false,
		'mensaje' => 'Cliente agregado con éxito'
	];

	$config = include 'configPrestamos.php';

	try {
		$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
		$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

		$cliente = [
			"cNombre"				=> $_POST['cNombre'],
			"cApellidoPaterno"		=> $_POST['cApellidoPaterno'],
			"cApellidoMaterno"		=> $_POST['cApellidoMaterno'],
			"dFechaNacimiento"		=> $_POST['dFechaNacimiento'],
		];

		$consulta = "INSERT INTO CatClientes (cNombre, cApellidoPaterno, cApellidoMaterno, dFechaNacimiento)";
		$consulta .= "VALUES (:" . implode(", :", array_keys($cliente)) . ")";

		$sentencia = $conexion->prepare($consulta);
		$sentencia->execute($cliente);

	} catch (PDOException $th) {
		$resultado['error'] = true;
		$resultado['mensaje'] = $th->getMessage();
	}
}
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Catalogo de Clientes</title>
		<link rel="shortcut icon" type="image/x-icon" href="imagenes/prestamos.ico">

		<link rel="stylesheet" href="https://stackpath.bootstrapcdn.com/bootstrap/4.5.2/css/bootstrap.min.css">

	</head>
	<body>

<?php
	if (isset($resultado)) {
?>
	<div class="container mt-3">
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-<?= $resultado['error'] ? 'danger' : 'success' ?>" role="alert">
				<?= $resultado['mensaje'] ?>
				</div>
			</div>
		</div>
	</div>
<?php
	}
?>

	<div class="container">
		<div class="row">
			<div class="col-md-8">
				<h2 class="mt-4">Captura de Clientes</h2>
				<hr>
				<form action="" method="post">
					<div class="form-group">
						<label for="cNombre">Nombre</label>
						<input type="text" name="cNombre" id="cNombre" class="form-control" maxlength="30" required>
					</div>

					<div class="form-group">
						<label for="cApellidoPaterno">Apellido Paterno</label>
						<input type="text" name="cApellidoPaterno" id="cApellidoPaterno" class="form-control" maxlength="30" required>
					</div>

					<div class="form-group">
						<label for="cApellidoMaterno">Apellido Materno</label>
						<input type="text" name="cApellidoMaterno" id="cApellidoMaterno" class="form-control" maxlength="30">
					</div>

					<div class="form-group">
						<label for="cFechaNacimiento">Fecha Nacimiento</label>
						<input type="date" name="dFechaNacimiento" id="dFechaNacimiento" class="form-control" maxlength="8" required min="1990-01-01" max="2021-12-31">
					</div>

					<div class="form-group">
						<input type="submit" name="guardar" class="btn btn-success mt-4" value="Guardar">
						<a href="index.php" class="btn btn-secondary mt-4 align-middle">Regresar a Menu Principal</a>
					</div>
				</form>
			</div>
		</div>
	</div>

<?php include "plantillas/piepagina.php"; ?>


