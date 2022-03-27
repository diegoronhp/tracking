<?php

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Reporte_facturacion.xls");
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
    <td colspan="14" bgcolor="skyblue"><CENTER><strong>HISTORIAL FACTURACION TRACKING VIP</strong></CENTER></td>
  </tr>
  <tr>
    <td bgcolor="red"><strong>NUM</strong></td>
    <td bgcolor="red"><strong>FACTURA</strong></td>
    <td bgcolor="red"><strong>FECHA</strong></td>
    <td bgcolor="red"><strong>NOMBRE</strong></td>
    <td bgcolor="red"><strong>GRUPO</strong></td>
    <td bgcolor="red"><strong>SUBTOTAL</strong></td>
    <td bgcolor="red"><strong>IVA</strong></td>
    <td bgcolor="red"><strong>RETEFUENTE</strong></td>
    <td bgcolor="red"><strong>RETEICA</strong></t>
    <td bgcolor="red"><strong>TOTAL</strong></td>
    <td bgcolor="red"><strong>TIPO</strong></td>
    <td bgcolor="red"><strong>BANCO</strong></td>
    <td bgcolor="red"><strong>ELABORADA</strong></td>
    <td bgcolor="red"><strong>ESTADO</strong></td>
  </tr>
  
<?PHP

$query_consulta = "SELECT f.fecha_fact, f.id_cliente, f.id_grupos, f.estado, f.numero, f.total, f.iva, f.retefuente, f.reteica, f.subtotal, f.motivo, f.coniva, f.conretencion, f.conreteica, f.banco, f.elaborada, c.id_cliente, c.nombre, g.id_grupos, g.nombre AS ungrupo FROM facturacion f JOIN clientes c ON f.id_cliente = c.id_cliente JOIN grupos g ON f.id_grupos = g.id_grupos";
$consulta = mysqli_query($track, $query_consulta) or die(mysqli_error());
$row_consulta = mysqli_fetch_assoc($consulta);
$totalRows_consulta = mysqli_num_rows($consulta);
$cont=0;
$total=0;
	

	do { 
                        $fecha=$row_consulta['fecha_fact'];
						$nombre_cliente=$row_consulta['nombre'];
						$elgrupo=$row_consulta['ungrupo'];
						$numero=$row_consulta['numero'];
						$total=$row_consulta['total'];
						$iva=$row_consulta['iva'];
						$retefuente=$row_consulta['retefuente'];
						$reteica=$row_consulta['reteica'];
						$subtotal=$row_consulta['subtotal'];
						$motivo=$row_consulta['motivo'];
						$coniva=$row_consulta['coniva'];
						$conretencion=$row_consulta['conretencion'];
						$conreteica=$row_consulta['conreteica'];
						$banco=$row_consulta['banco'];
						$elaborada=$row_consulta['elaborada'];
						$status_fact=$row_consulta['estado'];
						if ($status_fact=="a"){$estado="Activo";}
						else {$estado="Inactivo";}
                        $cont++;
		
						
?> 

						
						
						<!-- <td><?php echo $date_added;?></td> --> 
 <tr>
						<td><?php echo $cont;?></td>
						<td><?php echo $numero;?></td>
						<td><?php echo $fecha; ?></td>
						<td><?php echo $nombre_cliente; ?></td>
						<td><?php echo $elgrupo; ?></td>
						<td><?php echo $subtotal;?></td>
						<td><?php echo $iva;?></td>
						<td><?php echo $retefuente;?></td>
						<td><?php echo $reteica;?></td>
						<td><?php echo $total; ?></td>
						<td><?php echo $motivo; ?></td>
						<td><?php echo $banco;?></td>
						<td><?php echo $elaborada; ?></td>
						<td><?php echo $estado;?></td>         
 </tr> 
  
 <?php } while ($row_consulta = mysqli_fetch_assoc($consulta));
	
	?>
 
</table>
</body>
</html>
<?php
mysqli_free_result($consulta);
?>