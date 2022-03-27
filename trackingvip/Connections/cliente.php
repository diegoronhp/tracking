<?php 
//mysql_select_db($database_track, $track);
$query_cliente = "SELECT * FROM clientes ORDER BY nombre ASC";;
$cliente = mysqli_query($track, $query_cliente) or die(mysqli_error());
$row_cliente = mysqli_fetch_assoc($cliente);
$totalRows_cliente = mysqli_num_rows($cliente);

?>