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

$query_linea = "SELECT * FROM sim ORDER BY linea ASC";
$linea = mysqli_query($track, $query_linea) or die(mysqli_error($track));
$row_linea = mysqli_fetch_assoc($linea);
$totalRows_linea = mysqli_num_rows($linea);

		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code

if (empty($_POST['imei_sim'])) {
           $errors[] = "IMEI vacío";
        }else if (empty($_POST['linea'])) {
           $errors[] = "Linea vacía";
        }  else if ($_POST['estado']==""){
			$errors[] = "Selecciona el estado";
		}  else if (
			!empty($_POST['imei_sim']) &&
			!empty($_POST['linea']) &&
			$_POST['estado']!="" 
		){
	    $imei_sim=mysqli_real_escape_string($con,(strip_tags($_POST["imei_sim"],ENT_QUOTES)));
        $linea=mysqli_real_escape_string($con,(strip_tags($_POST["linea"],ENT_QUOTES)));
		$empresa_sim=mysqli_real_escape_string($con,(strip_tags($_POST["empresa_sim"],ENT_QUOTES)));
	    $estado=mysqli_real_escape_string($con,(strip_tags($_POST["estado"],ENT_QUOTES)));
	    $tipo=mysqli_real_escape_string($con,(strip_tags($_POST["tipo"],ENT_QUOTES)));



$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_POST['imei_sim'])) {
  $insertSQL = sprintf("INSERT INTO sim (imei_sim, linea, empresa_sim, estado, tipo) VALUES (%s, %s, %s, %s, %s)",
                       GetSQLValueString($imei_sim, "text"),
                       GetSQLValueString($linea, "text"),
                       GetSQLValueString($empresa_sim, "text"),
                       GetSQLValueString($estado, "text"),
                       GetSQLValueString($tipo, "int"));

  mysqli_select_db($track, $database_track);
  $Result1 = mysqli_query($track, $insertSQL) or die(mysqli_error($track));
	
  $insertGoTo = "../linea.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}
	

	
	
}
	
if (isset($_POST['registro']) && $_POST['registro']==5) {

	
		$id_usuario=mysqli_real_escape_string($con,(strip_tags($_POST["id_usuario"],ENT_QUOTES)));
        $id_linea=mysqli_real_escape_string($con,(strip_tags($_POST["id_linea"],ENT_QUOTES)));
		$valor=mysqli_real_escape_string($con,(strip_tags($_POST["valor"],ENT_QUOTES)));
	    $fecha=mysqli_real_escape_string($con,(strip_tags($_POST["fecha"],ENT_QUOTES)));
	
			
$query_consulcarga = "SELECT * FROM recarga WHERE id_linea = $id_linea AND fecha = '$fecha'";
$concar = mysqli_query($track, $query_consulcarga) or die(mysqli_error());
$row_concar = mysqli_fetch_assoc($concar);
	if (isset($row_concar['id_linea'])) {
	$insertGoTo = "../lineapre.php?ing=0";
 header(sprintf("Location: %s", $insertGoTo));
	} else {
  $insertSQL = sprintf("INSERT INTO recarga (id_usuario, id_linea, valor, fecha) VALUES (%s, %s, %s, %s)",
                       GetSQLValueString($id_usuario, "text"),
                       GetSQLValueString($id_linea, "text"),
                       GetSQLValueString($valor, "text"),
                       GetSQLValueString($fecha, "text"));

  mysqli_select_db($track, $database_track);
  $Result1 = mysqli_query($track, $insertSQL) or die(mysqli_error($track));
	
  $insertGoTo = "../lineapre.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
 header(sprintf("Location: %s", $insertGoTo));
}
}
	
mysqli_free_result($usu);
mysqli_free_result($linea);

?>
