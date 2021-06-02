<?php

if (isset($_POST['guardar'])) {
	$resultado = [
		'error' => false,
		'mensaje' => 'Prestamo registrado con éxito'
	];

	if ($_POST['idCliente'] == 0) {
		$resultado = [
			'error' => true,
			'mensaje' => 'Favor de seleccionar Cliente'
		];
	}
	elseif ($_POST['idMonto'] == 0) {
		$resultado = [
			'error' => true,
			'mensaje' => 'Favor de seleccionar Plan de Prestamo'
		];
	}
	else {

		$config = include 'configPrestamos.php';

		try {
			$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
			$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);

			$datosPrestamo = [
				"idCliente"			=> $_POST['idCliente'],
				"idMonto"			=> $_POST['idMonto'],
				"dFechaSolicitud"	=> $_POST['dFechaSolicitud'],
			];

			$consulta = "INSERT INTO tbprestamos ( idCliente, idMonto, dFechaSolicitud )";
			$consulta .= " VALUES (:" . implode(", :", array_keys($datosPrestamo)) . ")";

			$sentencia = $conexion->prepare($consulta);
			$sentencia->execute($datosPrestamo);

		} catch (PDOException $th) {
			$resultado['error'] = true;
			$resultado['mensaje'] = $th->getMessage();
		}
	}
}
?>

<!DOCTYPE html>
<html lang="es">
	<head>
		<meta charset="utf-8">
		<title>Agregar Prestamo</title>
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
				<h2 class="mt-4">Agregar Prestamo</h2>
				<hr>
				<form action="" method="post">
					<div class="form-group">
						<label for="idCliente">Cliente</label>
						<select class="form-control" id="idCliente" name="idCliente" required>
							<option value="0">Seleccione:</option>
							<?php
								$config = include 'configPrestamos.php';
								
								$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
								$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
								
								$query = $conexion->prepare("SELECT idCliente, concat_ws(' ', cl.cNombre, cl.cApellidoPaterno, cl.cApellidoMaterno) AS cNombreCliente FROM CatClientes AS cl");
								$query->execute();
								$data = $query->fetchAll();

								foreach ($data as $valores):
									echo '<option value="'.$valores["idCliente"].'">'.$valores["cNombreCliente"].'</option>';
								endforeach;
							?>
						</select>
					</div>

					<div class="form-group">
					<label for="idMonto">Plan de Prestamo</label>
						<select class="form-control" id="idMonto" name="idMonto" required>
							<option value="0">Seleccione:</option>
							<?php
								$config = include 'configPrestamos.php';
								
								$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
								$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
								
								$query = $conexion->prepare("SELECT idMonto, cDescripcion FROM CatMontosPlazos AS cl");
								$query->execute();
								$data = $query->fetchAll();

								foreach ($data as $valores):
									echo '<option value="'.$valores["idMonto"].'">'.$valores["cDescripcion"].'</option>';
								endforeach;
							?>
						</select>
					</div>

					<div class="form-group">
						<label for="dFechaSolicitud">Fecha Solicitud</label>
						<input type="date" name="dFechaSolicitud" id="dFechaSolicitud" class="form-control" maxlength="8" required readonly value="<?php echo date('Y-m-d'); ?>">
					</div>

					<div class="form-group" style="align-items: center;">
						<a href="RegistroPrestamos.php" class="btn btn-primary mt-4 align-middle"> Cancelar </a>
						<input type="submit" name="guardar" class="btn btn-success mt-4" value=" Guardar ">
					</div>
				</form>
			</div>
		</div>
	</div>

<?php include "plantillas/piepagina.php"; ?>


