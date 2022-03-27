<?php

header("Content-type: application/vnd.ms-excel");
header("Content-Disposition: attachment; filename=Reporte_vehiculos.xls");
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
    <td colspan="19" bgcolor="skyblue"><CENTER><strong>REPORTE DE VEHICULOS TRACKING VIP</strong></CENTER></td>
  </tr>
  <tr>
    <td bgcolor="red"><strong>NUM</strong></td>
    <td bgcolor="red"><strong>PLACA</strong></td>
    <td bgcolor="red"><strong>DOCUMENTO CLIENTE</strong></td>
    <td bgcolor="red"><strong>CLIENTE</strong></td>
    <td bgcolor="red"><strong>TEL CLIENTE</strong></td>
    <td bgcolor="red"><strong>GRUPO</strong></td>
    <td bgcolor="red"><strong>IMEI</strong></td>
    <td bgcolor="red"><strong>AVL</strong></td>
    <td bgcolor="red"><strong>MODELO</strong></td>
    <td bgcolor="red"><strong>LINEA</strong></td>
    <td bgcolor="red"><strong>IMEI SIM</strong></td>
    <td bgcolor="red"><strong>OPERADOR</strong></td>
    <td bgcolor="red"><strong>CONTRATO</strong></td>
    <td bgcolor="red"><strong>ESTADO</strong></td>
    <td bgcolor="red"><strong>PLATAFORMA</strong></td>
    <td bgcolor="red"><strong>PROPIETARIO</strong></td>
    <td bgcolor="red"><strong>INSTALACION</strong></td>
    <td bgcolor="red"><strong>CIUDAD</strong></td>
    <td bgcolor="red"><strong>VALOR MEN.</strong></td>
  </tr>
  
<?PHP

$query_consulta = "SELECT m.id_movequipos, m.id_equipo, m.id_cliente, m.estado, m.id_grupos, m.placa, m.valor_mensual, m.fecha, m.tipo_contrato, m.avl, m.ciudad, m.plataforma, m.id_sim, m.propietario, m.tel_propietario, m.referencia1, m.referencia2, m.referencia3, m.observaciones, m.fecha_modificado, c.id_cliente, c.nit, c.telefono, c.nombre, e.id_equipo, e.imei, e.id_marca, e.id_modelo, s.id_sim, s.imei_sim, s.linea, s.empresa_sim, g.id_grupos, g.nombre AS ungrupo FROM movequipos m JOIN clientes c ON m.id_cliente = c.id_cliente JOIN grupos g ON m.id_grupos = g.id_grupos JOIN equipos e ON m.id_equipo = e.id_equipo JOIN sim s ON m.id_sim = s.id_sim";
$consulta = mysqli_query($track, $query_consulta) or die(mysqli_error($track));
$row_consulta = mysqli_fetch_assoc($consulta);
$totalRows_consulta = mysqli_num_rows($consulta);
$cont=0;
$total=0;
	

	do { 
                        $placa=$row_consulta['placa'];
						$nombre_cliente=$row_consulta['nombre'];
						$documento=$row_consulta['nit'];
						$elgrupo=$row_consulta['ungrupo'];
						$elmodelo=$row_consulta['id_modelo'];
						$imeisim=$row_consulta['imei_sim'];
						$contrato=$row_consulta['tipo_contrato'];
						$telefono_cliente=$row_consulta['telefono'];
						$email_cliente=$row_consulta['correo'];
						$propietario=$row_consulta['propietario'];
						$imei=$row_consulta['imei'];
						$avl=$row_consulta['avl'];
						$plataforma=$row_consulta['plataforma'];
						$propietario=$row_consulta['propietario'];
						$ciudad=$row_consulta['ciudad'];
						$instalado=$row_consulta['fecha'];
						$valorm=$row_consulta['valor_mensual'];
						$emsim=$row_consulta['empresa_sim'];
						$status_cliente=$row_consulta['estado'];
						$linea=$row_consulta['linea'];
						if ($status_cliente=="a"){$estado="Activo";}
						else {$estado="Inactivo";}
                        $cont++;
		
                    $query_modelos = "SELECT id_modelo, modelo FROM modelo_gps WHERE id_modelo=$elmodelo";
                    $modelos = mysqli_query($track, $query_modelos) or die(mysqli_error());
                    $row_modelos = mysqli_fetch_assoc($modelos);
                    $numrows = mysqli_num_rows($modelos);
					$modelo=$row_modelos['modelo'];
						
?> 

						
						
						<!-- <td><?php echo $date_added;?></td> --> 
 <tr>
						<td><?php echo $cont;?></td>
						<td><?php echo $placa; ?></td>
						<td><?php echo $documento; ?></td>
						<td><?php echo $nombre_cliente; ?></td>
						<td><?php echo $telefono_cliente; ?></td>
						<td><?php echo $elgrupo; ?></td>
						<td><?php echo $imei;?></td>
						<td><?php echo $avl;?></td>
						<td><?php echo $modelo;?></td>
						<td><?php echo $linea;?></td>
						<td>&nbsp;<?php echo $imeisim;?></td>
						<td><?php echo $emsim; ?></td>
						<td><?php echo $contrato; ?></td>
						<td><?php echo $estado;?></td>
						<td><?php echo $plataforma;?></td>
						<td><?php echo $propietario; ?></td>
						<td><?php echo $instalado;?></td>
						<td><?php echo $ciudad;?></td>
						<td><?php echo $valorm;?></td>               
 </tr> 
  
 <?php } while ($row_consulta = mysqli_fetch_assoc($consulta));
	
	?>
 
</table>
</body>
</html>
<?php
mysqli_free_result($consulta);
?>