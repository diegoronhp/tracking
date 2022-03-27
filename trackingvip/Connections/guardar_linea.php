<?php
	
	require 'tracking.php';
	$resultado="";
	
	//recuperar las variables
	
	if(isset($_POST['imei_sim']) && !empty($_POST['imei_sim']) &&
	   isset($_POST['linea']) && !empty($_POST['linea']) &&
	   isset($_POST['empresa_sim']) && !empty($_POST['empresa_sim']) &&
	   isset($_POST['estado']) && !empty($_POST['estado']) &&
	   isset($_POST['tipo']) && !empty($_POST['tipo']) &&
	   isset($_POST['nombre_plan']) && !empty($_POST['nombre_plan']) &&
	   isset($_POST['valor_mensual']) && !empty($_POST['valor_mensual']))
	{
		$sql = "INSERT INTO sim (imei_sim, linea, empresa_sim, estado, tipo, nombre_plan, valor_mensual) VALUES ('$_POST[imei_sim]', '$_POST[linea]',  '$_POST[empresa_sim]', '$_POST[estado]', '$_POST[tipo]', '$_POST[nombre_plan]', '$_POST[valor_mensual]')";
	
	$resultado=$track->query($sql);
	}	
?>

<html lang="es">
	<head>
		
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link href="css/bootstrap.min.css" rel="stylesheet">
		<link href="css/bootstrap-theme.css" rel="stylesheet">
		<script src="js/jquery-3.1.1.min.js"></script>
		<script src="js/bootstrap.min.js"></script>	
	</head>
	
	<body>
		<div class="container">
			<div class="row">
				<div class="row" style="text-align:center">
					<?php if($resultado) { ?>
						<h3>REGISTRO GUARDADO</h3>
						<?php } else { ?>
						<h3>ERROR AL GUARDAR</h3>
					<?php } ?>
					
					<a href="../linea.php" class="btn btn-primary">Regresar</a>
					
				</div>
			</div>
		</div>
	</body>
</html>
