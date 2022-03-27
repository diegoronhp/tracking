<?php
require_once('Connections/tracking.php'); 
require_once('config/login.php');
//require_once('Connections/gps.php');

    $active_fact="";
	$active_productos="";
	$active_gps="active";
	$active_usuarios="";	
	$title="INVENTARIO";

$query_equipo = "SELECT COUNT(equipos.id_equipo) AS cantidad, equipos.ubicacion FROM equipos WHERE ubicacion <> 'INACTIVO' GROUP BY ubicacion";
$equipo = mysqli_query($track, $query_equipo) or die(mysqli_error());
$row_equipo = mysqli_fetch_assoc($equipo);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $title;?></title>

<script language="JavaScript" src="src/js/jquery-1.5.1.min.js"></script>
<script language="JavaScript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="stylesheet" />
<link rel="stylesheet" href="css/custom.css">
<link rel="stylesheet" href="css/login.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
</head>
<body>
<?php include("config/menu.php");?>
	<div class="container">
	<div class="panel panel-info">
	   <div class="panel-heading">
	   <h4><i class='glyphicon glyphicon-list-alt'></i>  Inventario GPS</h4>
		</div>
		<div class="panel-body">
       
			<div class="table-responsive">
			  <table class="table" align="center" style="width: 400px">
				<tr  class="info">
					<th>Ubicacion</th>
					<th class="text-center">Cantidad</th>
					<th></th>
			  </tr>
				<?php   do {
						$ubicacion=$row_equipo["ubicacion"];
						$cantidad=$row_equipo["cantidad"];
					?>
					<tr>
					<td><?php echo $ubicacion; ?></td>
					<td class="text-center"><?php echo $cantidad; ?></td>
					<td ><span class="pull-right">
					<a href="invgroup.php?ver=<?php echo $ubicacion; ?>" class="btn btn-default" title='Ver' ><i class="glyphicon glyphicon-edit"></i></a>
					<!-- <a href="#" class='btn btn-default' title='Borrar cliente' onclick="eliminar('<?php echo $id_cliente; ?>')"><i class="glyphicon glyphicon-trash"></i> </a> -->
					</span></td>
					</tr>
			  <?php } while ($row_equipo = mysqli_fetch_assoc($equipo)); ?>
			  </table>
			</div>
			</div>
			</div>
			</div>
	<hr>
	<?php
	include("config/footer.php");
	?>
</body>
</html>
<?php
mysqli_free_result($usu);
// mysqli_free_result($cliente);

?>