<?php 

define ('DB_USER', "tucontac_track1");
define ('DB_PASSWORD', "tracking@1");
define ('DB_DATABASE', "tucontac_tracking");
define ('DB_HOST', "localhost");
$mysqli = new mysqli(DB_HOST, DB_USER, DB_PASSWORD, DB_DATABASE);
$sql = "SELECT * FROM clientes 
		WHERE nombre LIKE '%".$_GET['q']."%'
		LIMIT 10";
$result = $mysqli->query($sql);
$json = [];
while($row = $result->fetch_assoc()){
     $json[] = ['id'=>$row['id_cliente'], 'text'=>$row['nombre']];
}
echo json_encode($json);
?>