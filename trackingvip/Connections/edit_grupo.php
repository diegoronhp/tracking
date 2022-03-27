<?php
$hostname_track = "localhost";
$database_track = "tracking_tracking";
$username_track = "tracking_track1";
$password_track = "tracking@1";
/* $track = mysqli_connect($hostname_track, $username_track, $password_track, $database_track) or trigger_error(mysqli_error(),E_USER_ERROR); */


$track = new mysqli($hostname_track, $username_track, $password_track, $database_track);
if ($track -> connect_errno) {
die( "Fallo la conexion a MySQL: (" . $mysqli -> mysqli_connect_errno() 
. ") " . $mysqli -> mysqli_connect_error());
}

//initialize the session
if (!isset($_SESSION)) {
  session_start();
}


function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }
  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($track,$theValue) : mysqli_escape_string($track,$theValue);
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



if (empty($_SESSION['tipo'])) {
           $errors[] = "vacío";
        }else if (empty($_SESSION['editgrupo'])) {
           $errors[] = "vacío";
        }  else if ($_POST['id_cliente']==""){
			$errors[] = "vacia";
		}  else if (
			!empty($_POST['id_cliente']) &&
			!empty($_SESSION['editgrupo']) &&
			$_SESSION['editnombre']!="" 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
        $id_grupos=mysqli_real_escape_string($con,(strip_tags($_SESSION['editgrupo'],ENT_QUOTES)));
		$id_cliente=mysqli_real_escape_string($con,(strip_tags($_POST['id_cliente'],ENT_QUOTES)));
		$nombre=mysqli_real_escape_string($con,(strip_tags($_SESSION['editnombre'],ENT_QUOTES)));


$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_POST['id_cliente'])) {
  $updateSQL = sprintf("UPDATE grupos SET id_cliente=%s, nombre=%s WHERE id_grupos=%s",
					   GetSQLValueString($id_cliente, "text"),
					   GetSQLValueString($nombre, "text"),
                       GetSQLValueString($id_grupos, "int"));


  $Result1 = mysqli_query($track, $updateSQL) or die(mysqli_error($track));
	  unset($_SESSION['tipo']);
	  unset($_SESSION['editgrupo']);
	  unset($_SESSION['editnombre']);

  $updateGoTo = "../clientes.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", "../grupos.php"));
}
}
mysqli_free_result($usu);
?>