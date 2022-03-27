<?php

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Reporte_recargas.xls");
session_start();

$hostname_track = "localhost";
$database_track = "tracking_tracking";
$username_track = "tracking_track1";
$password_track = "tracking@1";
/* $track = mysqli_connect($hostname_track, $username_track, $password_track, $database_track) or trigger_error(mysqli_error(),E_USER_ERROR); */


$track = new mysqli($hostname_track, $username_track, $password_track, $database_track);
if ($track -> connect_errno) {
die( "Fallo la conexi«Ñn a MySQL: (" . $mysqli -> mysqli_connect_errno() 
. ") " . $mysqli -> mysqli_connect_error());
}

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>RECARGAS</title>
</head>
<body>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="6" bgcolor="skyblue"><CENTER><strong>REPORTE DE RECARGAS TRACKING VIP</strong></CENTER></td>
  </tr>
  <tr>
    <td bgcolor="red"><strong>NUM</strong></td>
    <td bgcolor="red"><strong>FECHA</strong></td>
    <td bgcolor="red"><strong>LINEA</strong></td>
    <td bgcolor="red"><strong>VALOR</strong></td>
    <td bgcolor="red"><strong>PLACA</strong></td>
    <td bgcolor="red"><strong>USUARIO</strong></td>
  </tr>
  
<?PHP

mysqli_select_db($database_track,$track);
$query_consulta = "SELECT recarga.fecha as fechas, valor, movequipos.placa, sim.linea, usuarios.nombre FROM recarga LEFT JOIN movequipos ON movequipos.id_sim = recarga.id_linea LEFT JOIN sim ON sim.id_sim = recarga.id_linea LEFT JOIN usuarios ON recarga.id_usuario = usuarios.id_usuario ORDER BY fechas DESC";
$consulta = mysqli_query($track, $query_consulta) or die(mysqli_error());
$row_consulta = mysqli_fetch_assoc($consulta);
$totalRows_consulta = mysqli_num_rows($consulta);
$cont=0;
$total=0;
	

	do { 
                        $fecha=$row_consulta['fechas'];
						$valor=$row_consulta['valor'];
						$placa=$row_consulta['placa'];
						$linea=$row_consulta['linea'];
						$usuario_r=$row_consulta['nombre'];
                        $cont++;
		
?> 

 <tr>
						<td><?php echo $cont;?></td>
						<td><?php echo $fecha; ?></td>
						<td><?php echo $linea; ?></td>
						<td><?php echo $valor; ?></td>
						<td><?php echo $placa; ?></td>
						<td><?php echo $usuario_r;?></td>   
 </tr> 
  
 <?php } while ($row_consulta = mysqli_fetch_assoc($consulta));
	
	?>
 
</table>
</body>
</html>
<?php
mysqli_free_result($consulta);
?>