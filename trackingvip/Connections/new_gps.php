<?php
require_once('tracking.php'); 
require_once('../config/login.php');
require_once('cliente.php');



function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }
 // $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($track,$theValue) : mysqli_escape_string($track,$theValue);
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

$arnes = "SI";
mysqli_select_db($track, $database_track);
$query_gps = "SELECT * FROM equipos";;
$gps = mysqli_query($track, $query_gps) or die(mysqli_error($track));
$row_gps = mysqli_fetch_assoc($gps);
$totalRows_gps = mysqli_num_rows($gps);

if (empty($_POST['imei'])) {
           $errors[] = "IMEI vacío";
        }else if (empty($_POST['fecha'])) {
           $errors[] = "Fecha vacío";
        }  else if (
			!empty($_POST['imei']) &&
			!empty($_POST['fecha']) &&
			$_POST['id_marca']!="" 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
	    $imei=mysqli_real_escape_string($con,(strip_tags($_POST["imei"],ENT_QUOTES)));
        $id_marca=mysqli_real_escape_string($con,(strip_tags($_POST["id_marca"],ENT_QUOTES)));
		$id_modelo=mysqli_real_escape_string($con,(strip_tags($_POST["id_modelo"],ENT_QUOTES)));
		$fecha=mysqli_real_escape_string($con,(strip_tags($_POST["fecha"],ENT_QUOTES)));
		$ubicacion=mysqli_real_escape_string($con,(strip_tags($_POST["ubicacion"],ENT_QUOTES)));
		$origen=mysqli_real_escape_string($con,(strip_tags($_POST["origen"],ENT_QUOTES)));
	    $arnes=mysqli_real_escape_string($con,(strip_tags($arnes,ENT_QUOTES)));



$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_POST['imei'])) {
  $insertSQL = sprintf("INSERT INTO equipos (id_marca, id_modelo, imei, arnes, fecha, ubicacion, origen) VALUES (%s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($id_marca, "int"),
					   GetSQLValueString($id_modelo, "int"),
                       GetSQLValueString($imei, "text"),
                       GetSQLValueString($arnes, "text"),
                       GetSQLValueString($fecha, "text"),
                       GetSQLValueString($ubicacion, "text"),
                       GetSQLValueString($origen, "text"));

	
  $Result1 = mysqli_query($track, $insertSQL) or die(mysqli_error($track));
	
  $insertGoTo = "../gps.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}	
}

mysqli_free_result($usu);
mysqli_free_result($gps);

?>
