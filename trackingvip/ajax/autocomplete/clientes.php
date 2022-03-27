<?php
/* if (isset($_GET['term'])){
include("../../config/db.php");
include("../../config/conexion.php");
$return_arr = array(); */
/* If connection to database, run sql statement. -comentario-*/
/* if ($con)
{
	
	$fetch = mysqli_query($con,"SELECT * FROM clientes where nombre_cliente like '%" . mysqli_real_escape_string($con,($_GET['term'])) . "%' LIMIT 0 ,50"); */
	
	/* Retrieve and store in array the results of the query. -comentario- */
	/* while ($row = mysqli_fetch_array($fetch)) {
		$id_cliente=$row['id_cliente'];
		$row_array['value'] = $row['nombre'];
		$row_array['id_cliente']=$id_cliente;
		$row_array['nit_cliente']=$row['nit'];
		$row_array['dv_cliente']=$row['dv'];
		$row_array['nombre_cliente']=$row['nombre'];
		$row_array['telefono_cliente']=$row['telefono'];
		$row_array['email_cliente']=$row['correo'];
		$row_array['direccion_cliente']=$row['direccion'];
		$row_array['ciudad_cliente']=$row['ciudad'];
		$row_array['dia_corte_cliente']=$row['dia_corte'];
		$row_array['estado']=$row['estado'];

		array_push($return_arr,$row_array);
    }
	
} */

/* Free connection resources. -comentario- */
/* mysqli_close($con); */

/* Toss back results as json encoded array. -comentario-*/
/* echo json_encode($return_arr);

} */

?>