<?php

require_once('tracking.php'); 
require_once('../config/login.php');


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

//mysql_select_db($database_track, $track);
$query_cliente = "SELECT * FROM clientes ORDER BY nombre ASC";
$cliente = mysqli_query($track, $query_cliente) or die(mysqli_error());
$row_cliente = mysqli_fetch_assoc($cliente);
$totalRows_cliente = mysqli_num_rows($cliente);

if (empty($_POST['mod_id'])) {
           $errors[] = "ID vacío";
        }else if (empty($_POST['mod_nombre'])) {
           $errors[] = "Nombre vacío";
        }  else if ($_POST['mod_estado']==""){
			$errors[] = "Selecciona el estado del cliente";
		}  else if (
			!empty($_POST['mod_id']) &&
			!empty($_POST['mod_nombre']) &&
			$_POST['mod_estado']!="" 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
	    $id=mysqli_real_escape_string($con,(strip_tags($_POST["mod_id"],ENT_QUOTES)));
        $nit=mysqli_real_escape_string($con,(strip_tags($_POST["mod_nit"],ENT_QUOTES)));
		$dv=mysqli_real_escape_string($con,(strip_tags($_POST["mod_dv"],ENT_QUOTES)));
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["mod_nombre"],ENT_QUOTES)));
		$telefono=mysqli_real_escape_string($con,(strip_tags($_POST["mod_telefono"],ENT_QUOTES)));
		$email=mysqli_real_escape_string($con,(strip_tags($_POST["mod_email"],ENT_QUOTES)));
		$direccion=mysqli_real_escape_string($con,(strip_tags($_POST["mod_direccion"],ENT_QUOTES)));
		$ciudad=mysqli_real_escape_string($con,(strip_tags($_POST["mod_ciudad"],ENT_QUOTES)));
		$corte=mysqli_real_escape_string($con,(strip_tags($_POST["mod_dia_corte"],ENT_QUOTES)));
	    $estado=mysqli_real_escape_string($con,(strip_tags($_POST["mod_estado"],ENT_QUOTES)));
	    $cobro=mysqli_real_escape_string($con,(strip_tags($_POST["mod_cobro"],ENT_QUOTES)));
	    $observaciones=mysqli_real_escape_string($con,(strip_tags($_POST["mod_observaciones"],ENT_QUOTES)));



$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_POST['mod_id'])) {
  $insertSQL = sprintf("INSERT INTO clientes (nit, dv, nombre, telefono, correo, direccion, ciudad, dia_corte, estado, observaciones, cobro) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($nit, "int"),
					   GetSQLValueString($dv, "int"),
                       GetSQLValueString($nombre, "text"),
                       GetSQLValueString($telefono, "text"),
                       GetSQLValueString($email, "text"),
                       GetSQLValueString($direccion, "text"),
                       GetSQLValueString($ciudad, "text"),
                       GetSQLValueString($corte, "int"),
                       GetSQLValueString($estado, "text"),
                       GetSQLValueString($observaciones, "text"),
                       GetSQLValueString($cobro, "text"));

  mysqli_select_db($track, $database_track);
  $Result1 = mysqli_query($track, $insertSQL) or die(mysqli_error());
	
  $insertGoTo = "../clientes.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}	
}

echo $_POST['mod_id']." y ".$_POST['mod_estado'];

mysqli_free_result($usu);
mysqli_free_result($cliente);

?>
