<?php

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Reporte_lineas.xls");
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
<title>LISTA DE LINEAS</title>
</head>
<body>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="8" bgcolor="skyblue"><CENTER><strong>REPORTE DE LINEAS TRACKING VIP S.A.S.</strong></CENTER></td>
  </tr>
  <tr>
    <td bgcolor="red"><CENTER><strong>NUM</strong></CENTER></td>
    <td bgcolor="red"><CENTER><strong>LINEA</strong></CENTER></td>
    <td bgcolor="red"><CENTER><strong>IMEI</strong></CENTER></td>
    <td bgcolor="red"><CENTER><strong>EMPRESA</strong></CENTER></td>
	<td bgcolor="red"><CENTER><strong>NOMBRE DEL PLAN</strong></CENTER></td>
	<td bgcolor="red"><CENTER><strong>TIPO</strong></CENTER></td>
	<td bgcolor="red"><CENTER><strong>VALOR DEL PLAN</strong></CENTER></td>
    <td bgcolor="red"><CENTER><strong>PLACA</strong></CENTER></td>
  </tr>
  
<?PHP

$query_consulta = "SELECT sim.imei_sim, sim.linea, sim.empresa_sim, sim.tipo, sim.nombre_plan, sim.valor_mensual, movequipos.placa FROM sim LEFT JOIN movequipos ON sim.id_sim = movequipos.id_sim WHERE movequipos.estado = 'a' ORDER BY sim.empresa_sim ASC";
$consulta = mysqli_query($track, $query_consulta) or die(mysqli_error());
$row_consulta = mysqli_fetch_assoc($consulta);
$totalRows_consulta = mysqli_num_rows($consulta);
$cont=0;
$total=0;
	do { 
                        $imei=$row_consulta['imei_sim'];
						$linea=$row_consulta['linea'];
						$empresa=$row_consulta['empresa_sim'];
						$nombre_plan=$row_consulta['nombre_plan'];
						$valor_mensual=$row_consulta['valor_mensual'];
						$placa=$row_consulta['placa'];
						if ($row_consulta['tipo']==1) {
							$tipo = 'Postpago';
						} elseif ($row_consulta['tipo']==2) {
							$tipo = 'Prepago';
						}
                        $cont++;
		?> 
				
 <tr>
						<td><CENTER><?php echo $cont;?></CENTER></td>
						<td><CENTER><?php echo $linea; ?></CENTER></td>
						<td>&nbsp;<?php echo $imei; ?></td>
						<td><CENTER><?php echo $empresa; ?></CENTER></td>
		 				<td><CENTER><?php echo $nombre_plan; ?></CENTER></td>
	 					<td><CENTER><?php echo $tipo; ?></CENTER></td> 
	 					<td><CENTER><?php echo $valor_mensual; ?></CENTER></td>
						<td><CENTER><?php echo $placa; ?></CENTER></td>   
   
 </tr> 
  
 <?php } while ($row_consulta = mysqli_fetch_assoc($consulta));
	
	?>
 
</table>
</body>
</html>
<?php
mysqli_free_result($consulta);
?>