<?php
	$error = false;
	$config = include 'configPrestamos.php';

	try {
		$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
		$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
		
		if (isset($_POST['Cliente'])) {
			$consultaSQL = "SELECT prest.idPrestamo, concat_ws(' ', cl.cNombre, cl.cApellidoPaterno, cl.cApellidoMaterno) AS cNombreCliente, mt.nMonto, mt.nPlazos, mt.nAbono
				FROM tbprestamos prest
				INNER JOIN catclientes cl ON cl.idCliente = prest.idCliente
				INNER JOIN catmontosplazos mt ON mt.idMonto = prest.idMonto WHERE concat_ws(' ', cl.cNombre, cl.cApellidoPaterno, cl.cApellidoMaterno) LIKE '%" . $_POST['Cliente'] . "%'";
		} else {
			$consultaSQL = "SELECT prest.idPrestamo, concat_ws(' ', cl.cNombre, cl.cApellidoPaterno, cl.cApellidoMaterno) AS cNombreCliente, mt.nMonto, mt.nPlazos, mt.nAbono
				FROM tbprestamos prest
				INNER JOIN catclientes cl ON cl.idCliente = prest.idCliente
				INNER JOIN catmontosplazos mt ON mt.idMonto = prest.idMonto";
		}

		$sentencia = $conexion->prepare($consultaSQL);
		$sentencia->execute();

		$prestamos = $sentencia->fetchAll();

	} catch(PDOException $error) {
		$error = $error->getMessage();
	}
?>

<?php include "plantillas/encabezado.php"; ?>

<?php
if ($error) {
?>
	<div class="container mt-2">
		<div class="row">
			<div class="col-md-12">
				<div class="alert alert-danger" role="alert">
				<?= $error ?>
				</div>
			</div>
		</div>
	</div>
<?php
	}
?>
	<div>
		<div class="container">
			<div class="row">
				<div class="col-md-12">
					<h2 class="mt-4">Prestamos</h2>
					<hr>					
					<form action="" method="post">
						<div class="form-group">
							<input type="text" name="Cliente" id="Cliente" placeholder="Buscar por cliente">
						</div>
						<button type="submit" name="submit" class="btn btn-primary">Buscar</button>
						<a href="AgregarPrestamo.php" class="btn btn-primary" style="float: right;">Agregar Prestamo</a>
						<!--input type="button" value="Agregar Prestamo" class="btn btn-primary" style="float: right;" -->
					</form>

				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<hr>
					<table class="table">
						<thead>
							<tr>
								<th>#</th>
								<th>Nombre</th>
								<th>Monto</th>
								<th>Plazos</th>
								<th>Abono</th>
								<th>Acciones</th>
							</tr>
						</thead>
						<tbody>
							<?php
								if ($prestamos && $sentencia->rowCount() > 0) {
									foreach ($prestamos as $fila) {
										?>
										<tr>
											<td><?php echo $fila["idPrestamo"] ?></td>
											<td><?php echo $fila["cNombreCliente"] ?></td>
											<td><?php echo $fila["nMonto"] ?></td>
											<td><?php echo $fila["nPlazos"] ?></td>
											<td><?php echo $fila["nAbono"] ?></td>
											<td><a href="<?= 'amortizacion.php?idPrestamo='.($fila["idPrestamo"]) ?>" target="_blank">✏️ Amortizacion</td>
										</tr>
										<?php
									}
								}
							?>
						</tbody>
					</table>
				</div>
			</div>

			<a href="index.php" class="btn btn-secondary mt-4 align-middle">Regresar a Menu Principal</a>
		</div>
	</div>

<?php include "plantillas/piepagina.php"; ?>