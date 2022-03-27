<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('tracking.php');
require_once('../config/login.php');

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }
 //  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($track,$theValue) : mysqli_escape_string($track,$theValue);
  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}


//mysql_select_db($database_track, $track);
$query_equipo = "SELECT * FROM equipos";
$equipo = mysqli_query($track, $query_equipo) or die(mysqli_error());
$row_equipo = mysqli_fetch_assoc($equipo);
$totalRows_equipo = mysqli_num_rows($equipo);

if (empty($_POST['id_equipo'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['imei'])) {
           $errors[] = "Imei vacío";
        }  else if ($_POST['id_marca']==""){
			$errors[] = "Selecciona la marca";
		}  else if (
			!empty($_POST['id_equipo']) &&
			!empty($_POST['imei']) &&
			$_POST['id_marca']!="" 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
        $id_equipo=mysqli_real_escape_string($con,(strip_tags($_POST["id_equipo"],ENT_QUOTES)));
		$id_marca=mysqli_real_escape_string($con,(strip_tags($_POST["id_marca"],ENT_QUOTES)));
		$id_modelo=mysqli_real_escape_string($con,(strip_tags($_POST["id_modelo"],ENT_QUOTES)));
		$imei=mysqli_real_escape_string($con,(strip_tags($_POST["imei"],ENT_QUOTES)));
		$fecha=mysqli_real_escape_string($con,(strip_tags($_POST["fecha"],ENT_QUOTES)));
		$ubicacion=mysqli_real_escape_string($con,(strip_tags($_POST["ubicacion"],ENT_QUOTES)));
		$origen=mysqli_real_escape_string($con,(strip_tags($_POST["origen"],ENT_QUOTES)));


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_POST['id_equipo'])) {
  $updateSQL = sprintf("UPDATE equipos SET id_marca=%s, id_modelo=%s, imei=%s, fecha=%s, ubicacion=%s, origen=%s WHERE id_equipo=%s",
					   GetSQLValueString($id_marca, "int"),
					   GetSQLValueString($id_modelo, "int"),
                       GetSQLValueString($imei, "text"),
                       GetSQLValueString($fecha, "text"),
                       GetSQLValueString($ubicacion, "text"),
                       GetSQLValueString($origen, "text"),
                       GetSQLValueString($id_equipo, "int"));

  mysqli_select_db($track, $database_track);
  $Result1 = mysqli_query($track, $updateSQL) or die(mysql_error());
  if (isset($_POST['deinv'])) {
  $desde = $_POST['deinv'];
  $updateGoTo = "../inv.php";
  } else {
  $updateGoTo = "../gps.php";
  }
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
}



mysqli_free_result($usu);
mysqli_free_result($equipo);

?>
