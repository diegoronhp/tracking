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


$query_facturacion = "SELECT * FROM facturacion";;
$facturacion = mysqli_query($track, $query_facturacion) or die(mysqli_error());
$row_facturacion = mysqli_fetch_assoc($facturacion);
$totalRows_facturacion = mysqli_num_rows($facturacion);




if (empty($_POST['factura'])) {
           $errors[] = "Factura vacío";
        }else if (empty($_POST['valor'])) {
           $errors[] = "Valor vacío";
        }  else if ($_POST['fecha']==""){
			$errors[] = "Selecciona fecha";
		}  else if (
			!empty($_POST['factura']) &&
			!empty($_POST['valor'])
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
	    $factura=mysqli_real_escape_string($con,(strip_tags($_POST["factura"],ENT_QUOTES)));
        $valor=mysqli_real_escape_string($con,(strip_tags($_POST["valor"],ENT_QUOTES)));
		$fecha=mysqli_real_escape_string($con,(strip_tags($_POST["fecha"],ENT_QUOTES)));
		$concepto=mysqli_real_escape_string($con,(strip_tags($_POST["concepto"],ENT_QUOTES)));
		$id_usuario=mysqli_real_escape_string($con,(strip_tags($_POST["id_usuario"],ENT_QUOTES)));
		$observaciones=mysqli_real_escape_string($con,(strip_tags($_POST["observaciones"],ENT_QUOTES)));

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

	
if (isset($_POST["factura"])) {
  $insertSQL = sprintf("INSERT INTO movfacturas (factura, concepto, valor, fecha, id_usuario, observaciones) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($factura, "text"),
					   GetSQLValueString($concepto, "text"),
                       GetSQLValueString($valor, "text"),
                       GetSQLValueString($fecha, "text"),
                       GetSQLValueString($id_usuario, "int"),
                       GetSQLValueString($observaciones, "text"));

  mysqli_select_db($track, $database_track);
  $Result1 = mysqli_query($track, $insertSQL) or die(mysqli_error());
	
	
  $insertGoTo = "../consultafactura.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}	
}

mysqli_free_result($usu);
mysqli_free_result($facturacion);


?>
