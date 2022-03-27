<?php
/*
 * paging.php
 * 
 * Elaborado por: Moisés Icaza
 * Fecha: 01/08/2013
 * 
 * Paginación de registros utilizando PHP (5.4)
 * y componentes de Bootstrap.
 * 
 */

/* constantes */
require_once('Connections/tracking.php'); 
require_once('config/login.php');
//require_once('Connections/gps.php');

/* variables */
$order="placa ASC";
$url = basename($_SERVER ["PHP_SELF"]);
$limit_end = 8;
$init = ($ini-1) * $limit_end;


/* querys */
$count="SELECT COUNT(*) FROM movequipos";
$query_vehiculos = "SELECT  m.id_movequipos, m.id_equipo, m.id_cliente, m.estado, m.id_grupos, m.placa, m.valor_mensual, m.fecha, m.tipo_contrato, m.avl, m.ciudad, m.plataforma, m.id_sim, m.propietario, m.tel_propietario, m.referencia1, m.referencia2, m.referencia3, m.observaciones, m.fecha_modificado, c.id_cliente, c.nombre, e.id_equipo, e.imei, e.id_marca, e.id_modelo, s.id_sim, s.imei_sim, s.linea, s.empresa_sim, g.id_grupos FROM movequipos m JOIN clientes c ON m.id_cliente = c.id_cliente JOIN grupos g ON m.id_grupos = g.id_grupos JOIN equipos e ON m.id_equipo = e.id_equipo JOIN sim s ON m.id_sim = s.id_sim ORDER BY $order";
$query_vehiculos .= " LIMIT 5, 10";


$vehiculos = mysql_query($query_vehiculos, $track) or die(mysql_error());
$row_vehiculos = mysql_fetch_assoc($vehiculos);
$numrows = mysql_num_rows($vehiculos);

/* conexión al servidor de base de datos */
if ($vehiculos->connect_error) 
{
  die("Error al conectarse al servidor");
   
}else{
   
  $num = $mysql->query($count);
  $x = $num->fetch_array();

 
  $total = ceil($x[0]/$limit_end);
	
	

  echo "<table class='table'>";
  echo "<thead>";
  echo "<tr  class='info'>";
  echo "<th>Placa</th>";
  echo "<th>Cliente</th>";
  echo "<th>Avl</th>";
  echo "<th>Modelo</th>";
  echo "<th>Linea</th>";
  echo "<th>Imei Sim</th>";
  echo "<th>Cliente</th>";
  echo "<th>Operador</th>";
  echo "<th>Contrato</th>";
  echo "<th class='text-right'></th>";
  echo "</tr>";
  echo "</thead>";
  echo "<tbody id='myTable'>";
 
  $c = $vehiculos->query($query_vehiculos);
  while($rows = $c->fetch_array(MYSQLI_ASSOC))
  {
$placa=$row_vehiculos['placa'];
$nombre_cliente=$row_vehiculos['nombre'];
$elmodelo=$row_vehiculos['id_modelo'];
$imeisim=$row_vehiculos['imei_sim'];
$contrato=$row_vehiculos['tipo_contrato'];
$telefono_cliente=$row_vehiculos['telefono'];
$email_cliente=$row_vehiculos['correo'];
$propietario=$row_vehiculos['propietario'];
$avl=$row_vehiculos['avl'];
$plataforma=$row_vehiculos['plataforma'];
$emsim=$row_vehiculos['empresa_sim'];
$status_cliente=$row_vehiculos['estado'];
$linea=$row_vehiculos['linea'];
if ($status_cliente=="a"){$estado="Activo";}
else {$estado="Inactivo";}
						//$date_added= date('d/m/Y', strtotime($row['date_added']));
					mysql_select_db($database_track,$track);
                    $query_modelos = "SELECT id_modelo, modelo FROM modelo_gps WHERE id_modelo=$elmodelo";
                    $modelos = mysql_query($query_modelos, $track) or die(mysql_error());
                    $row_modelos = mysql_fetch_assoc($modelos);
                    $numrows = mysql_num_rows($modelos);
					$modelo=$row_modelos['modelo'];	 	  
	  
	  
    echo "<tr>";
    echo "<td>".$placa."</td>";
    echo "<td>".$nombre_cliente."</td>";
    echo "<td>".$avl."</td>";
    echo "<td>".$modelo."</td>";
    echo "<td>".$linea."</td>";
    echo "<td>".$imeisim."</td>";
    echo "<td>".$emsim."</td>";
    echo "<td>".$contrato."</td>";
    echo "<td>".$estado." ".$plataforma."</td>";
    echo "<td></td>";
    echo "</tr>";
  }
 
  echo "</tbody>";
  echo "<table>";
 
  /* numeración de registros [importante]*/
  echo "<div class='pagination'>";
  echo "<ul>";
  /****************************************/
  if(($ini - 1) == 0)
  {
    echo "<li><a href='#'>&laquo;</a></li>";
  }
  else
  {
    echo "<li><a href='$url?pos=".($ini-1)."'><b>&laquo;</b></a></li>";
  }
  /****************************************/
  for($k=1; $k <= $total; $k++)
  {
    if($ini == $k)
    {
      echo "<li><a href='#'><b>".$k."</b></a></li>";
    }
    else
    {
      echo "<li><a href='$url?pos=$k'>".$k."</a></li>";
    }
  }
  /****************************************/
  if($ini == $total)
  {
    echo "<li><a href='#'>&raquo;</a></li>";
  }
  else
  {
    echo "<li><a href='$url?pos=".($ini+1)."'><b>&raquo;</b></a></li>";
  }
  /*******************END*******************/
  echo "</ul>";
  echo "</div>";
}
?>