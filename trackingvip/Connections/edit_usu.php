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


$colname_movil = "-1";
if (isset($_SESSION['MM_Username'])) {
  $colname_usu = $_SESSION['MM_Username'];
}
mysqli_select_db($track, $database_track);
$query_usu = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_usu, "text"));
$usu = mysqli_query($track, $query_usu) or die(mysqli_error());
$row_usu = mysqli_fetch_assoc($usu);
$totalRows_usu = mysqli_num_rows($usu);



if (empty($_POST['id_usuario'])) {
           $errors[] = "Sin datos";
        }else if (empty($_POST['nombre'])) {
           $errors[] = "Nombre vacío";
        }  else if ($_POST['usuario']==""){
			$errors[] = "Usuario vacia";
		}  else if (
			!empty($_POST['clave']) &&
			!empty($_POST['nombre']) &&
			$_POST['id_usuario']!="" 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
        $id_usuario=mysqli_real_escape_string($con,(strip_tags($_POST["id_usuario"],ENT_QUOTES)));
		$nombre=mysqli_real_escape_string($con,(strip_tags($_POST["nombre"],ENT_QUOTES)));
		$usuario=mysqli_real_escape_string($con,(strip_tags($_POST["usuario"],ENT_QUOTES)));
		$clave=mysqli_real_escape_string($con,(strip_tags($_POST["clave"],ENT_QUOTES)));
		$estado=mysqli_real_escape_string($con,(strip_tags($_POST["estado"],ENT_QUOTES)));
		$cliente=mysqli_real_escape_string($con,(strip_tags($_POST["cliente"],ENT_QUOTES)));
		$lineas=mysqli_real_escape_string($con,(strip_tags($_POST["lineas"],ENT_QUOTES)));
		$lineaspre=mysqli_real_escape_string($con,(strip_tags($_POST["lineaspre"],ENT_QUOTES)));
		$vehiculos=mysqli_real_escape_string($con,(strip_tags($_POST["vehiculos"],ENT_QUOTES)));
		$grupos=mysqli_real_escape_string($con,(strip_tags($_POST["grupos"],ENT_QUOTES)));
		$facturacion=mysqli_real_escape_string($con,(strip_tags($_POST["facturacion"],ENT_QUOTES)));
		$equipos=mysqli_real_escape_string($con,(strip_tags($_POST["equipos"],ENT_QUOTES)));
		$usuarios=mysqli_real_escape_string($con,(strip_tags($_POST["usuarios"],ENT_QUOTES)));


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_POST['id_usuario'])) {
  $updateSQL = sprintf("UPDATE usuarios SET nombre=%s, clave=%s, usuario=%s, estado=%s, cliente=%s, lineas=%s, lineaspre=%s, vehiculos=%s, grupos=%s, facturacion=%s, equipos=%s, usuarios=%s WHERE id_usuario=%s",
					   GetSQLValueString($nombre, "text"),
					   GetSQLValueString($clave, "text"),
                       GetSQLValueString($usuario, "text"),
                       GetSQLValueString($estado, "text"),
                       GetSQLValueString($cliente, "text"),
                       GetSQLValueString($lineas, "text"),
                       GetSQLValueString($lineaspre, "text"),
                       GetSQLValueString($vehiculos, "text"),
                       GetSQLValueString($grupos, "text"),
                       GetSQLValueString($facturacion, "text"),
                       GetSQLValueString($equipos, "text"),
                       GetSQLValueString($usuarios, "text"),
                       GetSQLValueString($id_usuario, "int"));

   mysqli_select_db($track, $database_track);
  $Result1 = mysqli_query($track, $updateSQL) or die(mysqli_error());

  $updateGoTo = "../usuario.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
}

mysqli_free_result($usu);

?>
