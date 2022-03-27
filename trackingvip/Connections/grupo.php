<?php 
mysql_select_db($database_track, $track);
$query_grupo = "select grupos.id_grupos, grupos.nombre, clientes.nombre AS elnombre FROM  grupos INNER JOIN clientes WHERE grupos.id_cliente = clientes.id_cliente  ORDER BY nombre ASC";;
$grupo = mysql_query($query_grupo, $track) or die(mysql_error());
$row_grupo = mysql_fetch_assoc($grupo);
$totalRows_grupo = mysql_num_rows($grupo);

//AND grupos.id_grupos='".$id_grupos."'

?>