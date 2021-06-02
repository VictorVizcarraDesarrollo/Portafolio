<?php
	$error = false;
	$config = include 'configPrestamos.php';

	try {
		$dsn = 'mysql:host=' . $config['db']['host'] . ';dbname=' . $config['db']['name'];
		$conexion = new PDO($dsn, $config['db']['user'], $config['db']['pass'], $config['db']['options']);
		
		if (isset($_GET['idPrestamo'])) {
			$consultaSQL = "SELECT catmontosplazos.nPlazos, tbprestamos.dFechaSolicitud, catmontosplazos.nMonto / catmontosplazos.nPlazos AS nPrestamo, catmontosplazos.nInteres / catmontosplazos.nPlazos AS nInteres, catmontosplazos.nAbono
			FROM tbprestamos
				INNER JOIN catmontosplazos ON catmontosplazos.idMonto = tbprestamos.idMonto 
			WHERE tbprestamos.idPrestamo = " . $_GET['idPrestamo'] . ";";
		} /*else {
			$consultaSQL = "SELECT prest.idPrestamo, concat_ws(' ', cl.cNombre, cl.cApellidoPaterno, cl.cApellidoMaterno) AS cNombreCliente, mt.nMonto, mt.nPlazos, mt.nAbono FROM tbprestamos prest INNER JOIN catclientes cl ON cl.idCliente = prest.idCliente INNER JOIN catmontosplazos mt ON mt.idMonto = prest.idMonto";
		}*/
		
		//	echo "'". str_replace("'", "''", $consultaSQL). "'";
		
		$sentencia = $conexion->prepare($consultaSQL);
		$sentencia->execute();

		$prestamos = $sentencia->fetchAll();

		if (isset($_GET['idPrestamo'])) {
			$consultaSQL = "SELECT catmontosplazos.nPlazos, concat_ws(' ', catclientes.cNombre, catclientes.cApellidoPaterno, catclientes.cApellidoMaterno) AS cNombreCliente, '' AS dFechaSolicitud, catmontosplazos.nMonto AS nPrestamo, catmontosplazos.nInteres AS nInteres, ROUND(catmontosplazos.nAbono * catmontosplazos.nPlazos) AS nAbono
			FROM tbprestamos
				INNER JOIN catclientes ON catclientes.idCliente = tbprestamos.idCliente
				INNER JOIN catmontosplazos ON catmontosplazos.idMonto = tbprestamos.idMonto 
			WHERE tbprestamos.idPrestamo = " . $_GET['idPrestamo'] . ";";
		}
		
		$sentencia = $conexion->prepare($consultaSQL);
		$sentencia->execute();

		$TotalPrestamo = $sentencia->fetchAll();
		if ($TotalPrestamo && $sentencia->rowCount() > 0) {
			foreach ($TotalPrestamo as $fila) {
				$nombreCliente = $fila["cNombreCliente"];
			}
		}

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
					<h2 class="mt-4">Amortizacion</h2>

					<label for=""><?php echo "<h4>Prestamo #".$_GET['idPrestamo']." del cliente <b>". $nombreCliente . "</b></h4>" ?></label>
				</div>
			</div>
			<div class="row">
				<div class="col-md-12">
					<hr>
					<table class="table">
						<thead>
							<tr>
								<th>No. Pago</th>
								<th>Fecha</th>
								<th>Préstamo</th>
								<th>Interés</th>
								<th>Abono</th>
							</tr>
						</thead>
						<tbody>
							<?php
								if ($prestamos && $sentencia->rowCount() > 0) {
									foreach ($prestamos as $fila) {
										$nPlazo = 0;
										$fechaSolicitud = date_create($fila["dFechaSolicitud"]);
										for ($i=1; $i <= $fila["nPlazos"]; $i++) { 
											$nPlazo++;
											$fechaSolicitud = date_add($fechaSolicitud, date_interval_create_from_date_string("15 days"));
											//$fechaMostrar = strtotime($fechaSolicitud);
										?>
										<tr>
											<td><?php echo $nPlazo ?></td>
											<td><?php echo date_format($fechaSolicitud,"Y-m-d"); ?></td>
											<td><?php echo $fila["nPrestamo"] ?></td>
											<td><?php echo $fila["nInteres"] ?></td>
											<td><?php echo $fila["nAbono"] ?></td>
										</tr>
										<?php
										}
									}
								}
							?>
							<?php
								if ($TotalPrestamo && $sentencia->rowCount() > 0) {
									foreach ($TotalPrestamo as $fila) {
										?>
										<tr>
											<td>TOTAL</td>
											<td><?php echo $fila["dFechaSolicitud"] ?></td>
											<td><?php echo $fila["nPrestamo"] ?></td>
											<td><?php echo $fila["nInteres"] ?></td>
											<td><?php echo $fila["nAbono"] ?></td>
										</tr>
										<?php
									}
								}
							?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>

<?php include "plantillas/piepagina.php"; ?>