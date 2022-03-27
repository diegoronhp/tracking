<?php

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



$colname_movil = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usu = $_SESSION['MM_Username'];
}

$query_usu = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_usu, "text"));
$usu = mysqli_query($track, $query_usu) or die(mysqli_error());
$row_usu = mysqli_fetch_assoc($usu);
$totalRows_usu = mysqli_num_rows($usu);


mysqli_select_db($track, $database_track);
$query_sim = "SELECT * FROM sim";
$sim = mysqli_query($track, $query_sim) or die(mysqli_error());
$row_sim = mysqli_fetch_assoc($sim);
$totalRows_sim = mysqli_num_rows($sim);

if (empty($_POST['id_sim'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['imei_sim'])) {
           $errors[] = "Imei vacío";
        }  else if ($_POST['linea']==""){
			$errors[] = "Linea vacia";
		}  else if (
			!empty($_POST['empresa_sim']) &&
			!empty($_POST['estado']) &&
			$_POST['id_sim']!="" 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
        $id_sim=mysqli_real_escape_string($con,(strip_tags($_POST["id_sim"],ENT_QUOTES)));
		$imei_sim=mysqli_real_escape_string($con,(strip_tags($_POST["imei_sim"],ENT_QUOTES)));
		$linea=mysqli_real_escape_string($con,(strip_tags($_POST["linea"],ENT_QUOTES)));
		$empresa_sim=mysqli_real_escape_string($con,(strip_tags($_POST["empresa_sim"],ENT_QUOTES)));
		$estado=mysqli_real_escape_string($con,(strip_tags($_POST["estado"],ENT_QUOTES)));
		$tipo=mysqli_real_escape_string($con,(strip_tags($_POST["tipo"],ENT_QUOTES)));


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_POST['id_sim'])) {
  $updateSQL = sprintf("UPDATE sim SET imei_sim=%s, linea=%s, empresa_sim=%s, estado=%s, tipo=%s WHERE id_sim=%s",
					   GetSQLValueString($imei_sim, "text"),
					   GetSQLValueString($linea, "text"),
                       GetSQLValueString($empresa_sim, "text"),
                       GetSQLValueString($estado, "text"),
                       GetSQLValueString($tipo, "int"),
                       GetSQLValueString($id_sim, "int"));

   mysqli_select_db($track, $database_track);
  $Result1 = mysqli_query($track, $updateSQL) or die(mysqli_error());

  $updateGoTo = "../linea.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
}



mysqli_free_result($usu);
mysqli_free_result($sim);

?>
