<?php 
mysql_select_db($database_track, $track);
$query_gps = "SELECT equipos.id_equipo, equipos.id_marca, equipos.id_modelo, equipos.imei, equipos.fecha, equipos.origen, marca_gps.id_marca, modelo_gps.id_modelo, marca_gps.marca, modelo_gps.modelo FROM equipos JOIN marca_gps ON equipos.id_marca = marca_gps.id_marca JOIN modelo_gps ON equipos.id_modelo = modelo_gps.id_modelo ORDER BY marca_gps.marca ASC";;
$gps = mysql_query($query_gps, $track) or die(mysql_error());
$row_gps = mysql_fetch_assoc($gps);
$totalRows_gps = mysql_num_rows($gps);

?>

