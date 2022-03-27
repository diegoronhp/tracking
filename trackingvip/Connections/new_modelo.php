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


if (empty($_POST['id_marca'])) {
           $errors[] = "Marca vacía";
        }else if (empty($_POST['modelo'])) {
           $errors[] = "Modelo vacío";
        }{
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
	    $id_marca=mysqli_real_escape_string($con,(strip_tags($_POST["id_marca"],ENT_QUOTES)));
        $modelo=mysqli_real_escape_string($con,(strip_tags($_POST["modelo"],ENT_QUOTES)));

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

	
if (isset($_POST["modelo"])) {
  $insertSQL = sprintf("INSERT INTO modelo_gps (id_marca, modelo) VALUES (%s, %s)",
                       GetSQLValueString($id_marca, "text"),
					   GetSQLValueString($modelo, "text"));

  mysqli_select_db($track, $database_track);
  $Result1 = mysqli_query($track, $insertSQL) or die(mysqli_error());
	
	
  $insertGoTo = "../gps.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}	
}

if (empty($_POST['marca'])) {
           $errors[] = "Marca vacía";
        }{
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
	    $marca=mysqli_real_escape_string($con,(strip_tags($_POST["marca"],ENT_QUOTES)));

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

	
if (isset($_POST["marca"])) {
  $insertSQL = sprintf("INSERT INTO marca_gps (marca) VALUES (%s)",
                       GetSQLValueString($marca, "text"));

  mysqli_select_db($track, $database_track);
  $Result1 = mysqli_query($track, $insertSQL) or die(mysqli_error());
	
	
  $insertGoTo = "../gps.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}	
}


mysqli_free_result($usu);


?>
