<?php

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Reporte_facturado.xls");

session_start();

$hostname_track = "localhost";
$database_track = "tracking_tracking";
$username_track = "tracking_track1";
$password_track = "tracking@1";
/* $track = mysqli_connect($hostname_track, $username_track, $password_track, $database_track) or trigger_error(mysqli_error($track),E_USER_ERROR); */


$track = new mysqli($hostname_track, $username_track, $password_track, $database_track);
if ($track -> connect_errno) {
die( "Fallo la conexi«Ñn a MySQL: (" . $mysqli -> mysqli_connect_errno() 
. ") " . $mysqli -> mysqli_connect_error());
}

$_GET['id_cliente'];
$_GET['id_grupo'];
$_GET['factura'];
$cliente=$_GET['id_cliente'];
$grupo=$_GET['id_grupo'];
$factura=$_GET['factura'];


$query_consultanom = "SELECT id_cliente, nombre FROM clientes WHERE id_cliente = $cliente";
$consultanom = mysqli_query($track, $query_consultanom) or die(mysqli_error($track));
$row_consultanom = mysqli_fetch_assoc($consultanom);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LISTA DE VEHICULOS</title>
</head>
<body>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="6" bgcolor="skyblue"><CENTER><strong>REPORTE DE VEHICULOS CLIENTE <?php echo $row_consultanom["nombre"]; ?> FACTURA <?php echo $factura; ?></strong></CENTER></td>
  </tr>
  <tr>
    <td bgcolor="red"><strong>NUM</strong></td>
    <td bgcolor="red"><strong>PLACA</strong></td>
    <td bgcolor="red"><strong>DIAS</strong></td>
    <td bgcolor="red"><strong>VALOR</strong></td>
    <td bgcolor="red"><strong>CONTRATO</strong></td>
    <td bgcolor="red"><strong>FECHA INSTALACION</strong></td>
    <td bgcolor="red"><strong>IMEI</strong></td>
  </tr>
  
<?PHP

$query_consulta = "SELECT movequipos.id_cliente, movequipos.tipo_contrato, movequipos.valor_mensual, movequipos.placa, movequipos.estado, movequipos.id_grupos, movequipos.fecha, equipos.id_equipo, equipos.imei control_fact.factura, control_fact.placa AS laplaca, control_fact.valor, control_fact.dias_facturados FROM movequipos JOIN control_fact ON movequipos.placa = control_fact.placa JOIN equipos ON movequipos.id_equipo = equipos.id_equipo WHERE control_fact.factura = '$factura'";
$consulta = mysqli_query($track, $query_consulta) or die(mysqli_error($track));
$row_consulta = mysqli_fetch_assoc($consulta);
$totalRows_consulta = mysqli_num_rows($consulta);
$cont=0;
$total=0;
	do { 
	$placa=$row_consulta["laplaca"];
	$fecha=$row_consulta["fecha"];
	$valor=$row_consulta["valor"];
	$imei=$row_consulta["imei"];
	$dias=$row_consulta["dias_facturados"];
	$contrato=$row_consulta["tipo_contrato"];
    $cont++;
	$total= $total + $row_consulta["valor_mensual"];
?>  
 <tr>
	<td><?php echo $cont; ?></td>
	<td><?php echo $placa; ?></td>
	<td><?php echo $dias; ?></td>
	<td><?php echo $valor; ?></td>
	<td><?php echo $contrato; ?></td> 
	<td><?php echo $fecha; ?></td>
	<td><?php echo $imei; ?></td>                    
 </tr> 
  
 <?php } while ($row_consulta = mysqli_fetch_assoc($consulta)); ?>
  <tr>
	 <td colspan="3" bgcolor="skyblue"><span class="pull-right"><strong>VALOR TOTAL</strong></span>
	<td bgcolor="skyblue"><?php echo $total; ?></td>                 
 </tr> 
</table>
</body>
</html>
<?php
mysqli_free_result($consulta);

mysqli_free_result($consultanom);
?>