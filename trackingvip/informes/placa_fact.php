<?php

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Detalle_facturacion.xls");
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
<title>LISTA DE VEHICULOS</title>
</head>
<body>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="6" bgcolor="skyblue"><CENTER><strong>CONSULTA FACTURA TRACKING VIP</strong></CENTER></td>
  </tr>
  <tr>
    <td bgcolor="red"><strong>NUM</strong></td>
    <td bgcolor="red"><strong>PLACA</strong></td>
    <td bgcolor="red"><strong>VALOR</strong></td>
    <td bgcolor="red"><strong>DIAS</strong></td>
    <td bgcolor="red"><strong>FACTURA</strong></td>
    <td bgcolor="red"><strong>PERIODO</strong></td>
  </tr>
  
<?PHP
$factura = $_GET['numero'];
$query_consulta = "SELECT f.placa, f.periodo, f.dias_facturados, f.valor, f.factura FROM control_fact f WHERE f.factura='$factura' ORDER BY f.placa ASC";
$consulta = mysqli_query($track, $query_consulta) or die(mysqli_error());
$row_consulta = mysqli_fetch_assoc($consulta);
$totalRows_consulta = mysqli_num_rows($consulta);
$cont=0;
$total=0;
	

	do { 
                        $placa=$row_consulta['placa'];
						$periodo=$row_consulta['periodo'];
						$dias=$row_consulta['dias_facturados'];
						$valor=$row_consulta['valor'];
						$factura=$row_consulta['factura'];
                        $cont++;
		
						
?> 

						
						
						<!-- <td><?php echo $date_added;?></td> --> 
 <tr>
						<td><?php echo $cont;?></td>
						<td><?php echo $placa;?></td>
						<td><?php echo $valor; ?></td>
						<td><?php echo $dias; ?></td>
						<td><?php echo $factura; ?></td>
						<td><?php echo $periodo;?></td>      
 </tr> 
  
 <?php } while ($row_consulta = mysqli_fetch_assoc($consulta));
	
	?>
 
</table>
</body>
</html>
<?php
mysqli_free_result($consulta);
?>