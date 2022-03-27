<?php

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Reporte_equipos.xls");
session_start();

$hostname_track = "localhost";
$database_track = "tucontac_tracking";
$username_track = "tucontac_track1";
$password_track = "tracking@1";
$track = mysql_pconnect($hostname_track, $username_track, $password_track) or trigger_error(mysql_error(),E_USER_ERROR);

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
<title>LISTA DE EQUIPOS</title>
</head>
<body>
<table width="100%" border="1" cellspacing="0" cellpadding="0">
  <tr>
    <td colspan="17" bgcolor="skyblue"><CENTER><strong>REPORTE DE EQUIPOS TRACKING VIP</strong></CENTER></td>
  </tr>
  <tr>
    <td bgcolor="red"><strong>IMEI</strong></td>
    <td bgcolor="red"><strong>MARCA</strong></td>
    <td bgcolor="red"><strong>MODELO</strong></td>
    <td bgcolor="red"><strong>UBICACION</strong></td>
    <td bgcolor="red"><strong>PLACA</strong></td>
    <td bgcolor="red"><strong>CONTRATO</strong></td>
    <td bgcolor="red"><strong>FECHA</strong></td>
    <td bgcolor="red"><strong>ESTADO</strong></td>
    <td bgcolor="red"><strong>OBSERVACION</strong></td>
  </tr>
  
<?PHP

mysql_select_db($database_track,$track);
$query_consulta = "SELECT equipos.imei, equipos.fecha, equipos.ubicacion, equipos.observacion, equipos.estado, equipos.origen, marca_gps.marca, modelo_gps.modelo, movequipos.placa, movequipos.tipo_contrato FROM equipos JOIN marca_gps ON equipos.id_marca = marca_gps.id_marca JOIN modelo_gps ON equipos.id_modelo = modelo_gps.id_modelo LEFT JOIN movequipos ON equipos.id_equipo = movequipos.id_equipo WHERE movequipos.estado = 'a'";
$consulta = mysql_query($query_consulta, $track) or die(mysql_error());
$row_consulta = mysql_fetch_assoc($consulta);
$totalRows_consulta = mysql_num_rows($consulta);
$cont=0;
$total=0;
	

	do { 
                                                $placa=$row_consulta['placa'];
						$imei=$row_consulta['imei'];
						$marca=$row_consulta['marca'];
						$modelo=$row_consulta['modelo'];
						$ubicacion=$row_consulta['ubicacion'];
						$fecha=$row_consulta['fecha'];
						$contrato=$row_consulta['tipo_contrato'];
						$elestado=$row_consulta['estado'];
						$observaciones=$row_consulta['observacion'];
						if ($observaciones!="NULL"){$obs=$observaciones;}
						else {$obs="";}
						if ($elestado=="a"){$estado="Activo";}
						else {$estado="Inactivo";}
                        $cont++;
						
?>
 <tr>
						<td><?php echo $imei;?></td>
						<td><?php echo $marca; ?></td>
						<td><?php echo $modelo; ?></td>
						<td><?php echo $ubicacion; ?></td>
						<td><?php echo $placa;?></td>
						<td><?php echo $contrato;?></td>
						<td><?php echo $fecha;?></td>
						<td><?php echo $estado;?></td>
						<!-- <td>&nbsp;<?php echo $obsimeisim;?></td> -->
						<td><?php echo $obs; ?></td>       
 </tr> 
  
 <?php } while ($row_consulta = mysql_fetch_assoc($consulta));
	
	?>
 
</table>
</body>
</html>
<?php
mysql_free_result($consulta);
?>