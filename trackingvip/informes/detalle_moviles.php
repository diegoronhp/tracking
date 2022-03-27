<?php

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Reporte_vehiculos.xls");
session_start();

$q1 = $_SESSION['q1'];
$q2 = $_SESSION['q2'];

function nombremes($mes){
 setlocale(LC_TIME, 'spanish');  
 $nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 
 return $nombre;
}
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

$_GET['id_cliente'];
$_GET['id_grupo'];
$_GET['fecha'];
$cliente=$_GET['id_cliente'];
$grupo=$_GET['id_grupo'];
$fecha="'".$_GET['fecha']."'";



$query_consultanom = "SELECT movequipos.id_cliente, movequipos.id_grupos, movequipos.tipo_contrato, clientes.id_cliente, clientes.nombre, clientes.dia_corte, grupos.nombre AS elgrupo FROM movequipos JOIN clientes ON movequipos.id_cliente = clientes.id_cliente JOIN grupos ON movequipos.id_grupos = grupos.id_grupos WHERE movequipos.id_cliente = $cliente AND movequipos.id_grupos = $grupo";
$consultanom = mysqli_query($track, $query_consultanom) or die(mysqli_error());
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
    <td colspan="9" bgcolor="skyblue"><CENTER><strong>REPORTE DE VEHICULOS CLIENTE <?php echo $row_consultanom["nombre"]; ?></strong></CENTER></td>
  </tr>
  <tr>
    <td bgcolor="red"><strong>NUM</strong></td>
    <td bgcolor="red"><strong>PLACA</strong></td>
    <td bgcolor="red"><strong>GRUPO</strong></td>
    <td bgcolor="red"><strong>FECHA INSTALACION</strong></td>
    <td bgcolor="red"><strong>CONTRATO</strong></td>
    <td bgcolor="red"><strong>VALOR</strong></td>
    <td bgcolor="red"><strong>DIAS</strong></td>
    <td bgcolor="red"><strong>MES</strong></td>
    <td bgcolor="red"><strong>IMEI</strong></td>
  </tr>
  
<?PHP

$query_consulta = "SELECT movequipos.id_cliente, movequipos.tipo_contrato, movequipos.valor_mensual, movequipos.placa, movequipos.id_equipo, equipos.imei, movequipos.estado, movequipos.subgrupo, movequipos.id_grupos, movequipos.fecha, clientes.id_cliente, clientes.cobro, clientes.nombre, grupos.nombre AS elgrupo FROM movequipos JOIN clientes ON movequipos.id_cliente = clientes.id_cliente JOIN grupos ON movequipos.id_grupos = grupos.id_grupos JOIN equipos ON movequipos.id_equipo = equipos.id_equipo WHERE movequipos.estado='a' AND movequipos.fecha < $fecha AND movequipos.id_cliente = $cliente AND movequipos.id_grupos = $grupo ORDER BY elgrupo ASC";
$consulta = mysqli_query($track, $query_consulta) or die(mysqli_error());
$row_consulta = mysqli_fetch_assoc($consulta);
$totalRows_consulta = mysqli_num_rows($consulta);
$cont=0;
$total=0;
	

if ($row_consulta["cobro"]=='Anticipado') {
	
	if ($q1==1) {
$mespro = 12;
$q22 = $q2-1;
} else {
$mespro = $q1-1;
$q22 = $q2;
}
	
$dia = $row_consultanom["dia_corte"];	
//$mespro = $q1-1;
$query_consulplacascp = "SELECT DATEDIFF(CONCAT($q22,'-',$mespro,'-',$dia), fecha) AS losdias, movequipos.id_cliente, movequipos.tipo_contrato, movequipos.valor_mensual, movequipos.placa, movequipos.estado, movequipos.subgrupo, movequipos.id_grupos, movequipos.fecha, clientes.id_cliente, clientes.nombre, grupos.nombre AS elgrupo FROM movequipos JOIN clientes ON movequipos.id_cliente = clientes.id_cliente JOIN grupos ON movequipos.id_grupos = grupos.id_grupos WHERE movequipos.estado='a' AND fecha < CONCAT($q2,'-',$q1,'-',$dia) AND fecha > CONCAT($q22,'-',$mespro,'-',$dia) AND movequipos.id_cliente=$cliente AND movequipos.id_grupos=$grupo order by fecha ASC";
$consulplacascp = mysqli_query($track, $query_consulplacascp) or die(mysqli_error());
$row_consulplacascp = mysqli_fetch_assoc($consulplacascp);

}
	
if ($row_consulta["cobro"]=='Vencido') {

$dia = $row_consultanom["dia_corte"];
$mespro = $q1;
$mespro2 = $q1+1;
$query_consulplacascp = "SELECT DATEDIFF(CONCAT($q2,'-',$mespro,'-',$dia), fecha) AS losdias, movequipos.id_cliente, movequipos.tipo_contrato, movequipos.valor_mensual, movequipos.placa, movequipos.estado, movequipos.subgrupo, movequipos.id_grupos, movequipos.fecha, clientes.id_cliente, clientes.nombre, grupos.nombre AS elgrupo FROM movequipos JOIN clientes ON movequipos.id_cliente = clientes.id_cliente JOIN grupos ON movequipos.id_grupos = grupos.id_grupos WHERE movequipos.estado='a' AND fecha < CONCAT($q2,'-',$mespro2,'-',$dia) AND fecha > CONCAT($q2,'-',$q1,'-',$dia) AND movequipos.id_cliente=$cliente AND movequipos.id_grupos=$grupo order by fecha ASC";
$consulplacascp = mysqli_query($track, $query_consulplacascp) or die(mysqli_error());
$row_consulplacascp = mysqli_fetch_assoc($consulplacascp);

}
	
	
$mes = nombremes($q1);
$mesp = nombremes($mespro);
	do { 
	$placa=$row_consulta["placa"];
	$fecha=$row_consulta["fecha"];
	$valor=$row_consulta["valor_mensual"];
	$contrato=$row_consulta["tipo_contrato"];
	$subgrupo=$row_consulta["subgrupo"];
    $cont++;
	$total1= $total1 + $row_consulta["valor_mensual"];
	$imei=$row_consulta["imei"];
?>  
 <tr>
	<td><?php echo $cont; ?></td>
	<td><?php echo $placa; ?></td>
	<td><?php echo $subgrupo; ?></td>
	<td><?php echo $fecha; ?></td>
	<td><?php echo $contrato; ?></td>
	<td><?php echo $valor; ?></td> 
	<td>30</td>    
	<td><?php echo $mes; ?></td>  
	<td><?php echo "&nbsp;".$imei; ?></td>               
 </tr> 
  
 <?php } while ($row_consulta = mysqli_fetch_assoc($consulta));
 
 do { 
	$placap=$row_consulplacascp["placa"];
	$diasp=$row_consulplacascp["losdias"]+30;
	$fechap=$row_consulplacascp["fecha"];
	$valorp=round( $row_consulplacascp["valor_mensual"]/30*$diasp, 0, PHP_ROUND_HALF_UP);
	$contratop=$row_consulplacascp["tipo_contrato"];
	$subgrupop=$row_consulplacascp["subgrupo"];
    $cont++;
	$total2= $total2 + $valorp;
?>  
 <tr>
	<td><?php echo $cont; ?></td>
	<td><?php echo $placap; ?></td>
	<td><?php echo $subgrupop; ?></td>
	<td><?php echo $fechap; ?></td>
	<td><?php echo $contratop; ?></td>
	<td><?php echo $valorp; ?></td>
	<td><?php echo $diasp; ?></td>
	<td><?php echo $mesp; ?></td>
	<td></td>                        
 </tr> 
  
 <?php } while ($row_consulplacascp = mysqli_fetch_assoc($consulplacascp));
	$total = $total1 + $total2;
	?>
 
  <tr>
	 <td colspan="5" bgcolor="skyblue" style="text-align: right"><div class = "pull-right"><strong>VALOR TOTAL</strong></div></td>
	<td bgcolor="skyblue"><?php echo $total; ?></td>
	<td colspan="3" bgcolor="skyblue"</td>         
 </tr> 
</table>
</body>
</html>
<?php
mysqli_free_result($consulta);

mysqli_free_result($consultanom);

mysqli_free_result($consulplacascp);
?>