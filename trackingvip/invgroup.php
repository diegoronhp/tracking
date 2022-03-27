<?php
require_once('Connections/tracking.php'); 
require_once('config/login.php');
//require_once('Connections/gps.php');

    $active_fact="";
	$active_productos="";
	$active_gps="active";
	$active_usuarios="";	
	$title="INVENTARIO";

$_GET['ver'];
$ver = $_GET['ver'];


$query_equipo = "SELECT equipos.id_equipo, equipos.id_marca, equipos.id_modelo, equipos.imei, equipos.ubicacion, equipos.fecha, equipos.origen, marca_gps.id_marca, modelo_gps.id_modelo, marca_gps.marca, modelo_gps.modelo FROM equipos JOIN marca_gps ON equipos.id_marca = marca_gps.id_marca JOIN modelo_gps ON equipos.id_modelo = modelo_gps.id_modelo WHERE equipos.ubicacion = '$ver'";
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
		    <div class="btn-group pull-right">
			</div>
	   <h4><i class='glyphicon glyphicon-list-alt'></i>  Inventario GPS</h4>
		</div>
		<div class="panel-body">
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>Imei</th>
					<th>Marca</th>
					<th>Modelo</th>
					<th>Ubicacion</th>
					<th>Placa</th>
					<th>Estado Placa</th>
					<th>Fecha</th>
					<?php if( $row_usu["equipos"] == "e") { ?>
					<th class='text-right'></th>
			  <?php } ?>
					
				</tr>
				<?php   do {
						$id_equipo=$row_equipo['id_equipo'];
						$imei=$row_equipo['imei'];
						$marca=$row_equipo['marca'];
						$ubicacion=$row_equipo['ubicacion'];
						$modelo=$row_equipo['modelo'];
						$fecha=$row_equipo['fecha'];
						//$date_added= date('d/m/Y', strtotime($row['date_added']));
					mysqli_select_db($track, $database_track);
                    $query_placa = "SELECT placa, estado FROM movequipos WHERE id_equipo=$id_equipo ORDER BY fecha DESC";
                    $placa = mysqli_query($track, $query_placa) or die(mysqli_error());
                    $row_placa = mysqli_fetch_assoc($placa);
                    $numrows = mysqli_num_rows($placa);
					$placas=$row_placa['placa'];
					if ($row_placa['estado']=='a'){
						$est_placas='Activo';
					} elseif ($row_placa['estado']=='i'){
						$est_placas='Inactivo';
					} else {						
						$est_placas='';
					}
					?>
					<input type="hidden" value="<?php echo $imei; ?>" id="id_equipo<?php echo $id_equipo;?>">
					<!-- <input type="hidden" value="<?php echo $id_cliente;?>" id="id_cliente<?php echo $id_grupos;?>">
					<input type="hidden" value="<?php echo $nombre_grupo;?>" id="nombre_grupo<?php echo $id_grupos;?>"> -->
					
					<tr>
						<td><?php echo $imei; ?></td>
						<td><?php echo $marca; ?></td>
						<td><?php echo $modelo;?></td>
						<td><?php echo $ubicacion;?></td>
						<td>
						<?php if( $row_usu["vehiculos"] == "e") { ?><a href="edit_placa.php?placa=<?php echo $placas; ?>" class="" title='Editar cliente' >
			  <?php } ?><?php echo $placas;?>
			  <?php if( $row_usu["vehiculos"] == "e") { ?></a>
			  <?php } ?></td>
						<td><?php echo $est_placas;?></td>
						<td><?php echo $fecha;?></td>
						<?php if( $row_usu["equipos"] == "e") { ?>
						<td >
					<span class="pull-right">
					<!--  <a href="#" class="btn btn-default" title='Ver' onclick="obtener_datos('<?php echo $id_equipo;?>');" >  <i class="glyphicon glyphicon-eye-open"></i> </a> -->
					<a href="gps.php?desde=1&id=<?php echo $id_equipo; ?>#popup" class="btn btn-default" title='Editar GPS' ><i class="glyphicon glyphicon-edit"></i> </a>
					<!--  <a href="#" class="btn btn-default" title='Historial' onclick="obtener_datos('<?php echo $id_equipo;?>');" >  <i class="glyphicon glyphicon-transfer"></i> </a> -->
					<!--  <a href="#popup" class='btn btn-default' title='Borrar cliente' onclick="eliminar('<?php echo $id_grupos; ?>')"><i class="glyphicon glyphicon-trash"></i> </a> -->
					<!--  <a href="#" class='btn btn-default' title='Borrar cliente' onclick="eliminar('<?php echo $id_grupos; ?>')"><i class="glyphicon glyphicon-trash"></i> </a> -->
					</span>
					</td>
			  <?php } ?>
					</tr>
					<?php
				} while ($row_equipo = mysqli_fetch_assoc($equipo)); ?>
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