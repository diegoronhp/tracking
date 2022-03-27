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

$query_usu = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_usu, "text"));
$usu = mysqli_query($track, $query_usu) or die(mysqli_error());
$row_usu = mysqli_fetch_assoc($usu);
$totalRows_usu = mysqli_num_rows($usu);


$query_placas = "SELECT * FROM movequipos ORDER BY placa ASC";;
$placas = mysqli_query($track, $query_placas) or die(mysqli_error());
$row_placas = mysqli_fetch_assoc($placas);
$totalRows_placas = mysqli_num_rows($placas);

if (empty($_POST['tabla'])) {
           $errors[] = "Tabla vacío";
		}  else if (
			!empty($_POST['tabla']) &&
			!empty($_POST['campo']) 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
	
$id_usuario = $row_usu["id_usuario"];
$placa = $_POST["placa"];	
$tabla = $_POST["tabla"];
$campo = $_POST["campo"];
$editar = $_POST[$campo];
	if ($_POST[$campo]=="a") {
$datocambio = "Activo";
	} else if ($_POST[$campo]=="i") {
$datocambio = "Inactivo";
	} else {
$datocambio = $_POST[$campo];		
	}
	if (isset($_POST["cambio"])) {
$cambio = $_POST["cambio"];
	} else {
$cambio = $datocambio;		
	}
		
	
	
        $aeditar=mysqli_real_escape_string($con,(strip_tags($editar,ENT_QUOTES)));

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_POST['tabla'])) {
		$placamov=mysqli_real_escape_string($con,(strip_tags($placa,ENT_QUOTES)));
		$campomov=mysqli_real_escape_string($con,(strip_tags($campo,ENT_QUOTES)));
		$cambiomov=mysqli_real_escape_string($con,(strip_tags($cambio,ENT_QUOTES)));
		$id_usuariomov=mysqli_real_escape_string($con,(strip_tags($id_usuario,ENT_QUOTES)));
											 
	$sqlnew="INSERT INTO cambiosmov (placa, campo, cambio, id_usuario) VALUES ('$placamov','$campomov','$cambiomov','$id_usuariomov')";
  mysqli_select_db($track, $database_track);
  $Result2 = mysqli_query($track, $sqlnew) or die(mysqli_error());
	
  $updateSQL = sprintf("UPDATE $tabla SET $campo=%s WHERE placa='$placa'",
                       GetSQLValueString($aeditar, "text"));

   mysqli_select_db($track, $database_track);
  $Result1 = mysqli_query($track, $updateSQL) or die(mysqli_error());

  $updateGoTo = "../edit_placa.php?placa=$placa";
  if (isset($_SERVER['QUERY_STRING'])) {
    $updateGoTo .= (strpos($updateGoTo, '?')) ? "&" : "?";
    $updateGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $updateGoTo));
}
}
echo "-".$id_usuario;
echo "-".$placa;
echo "-".$tabla;
echo "-".$campo;
echo "-".$editar;

mysqli_free_result($usu);
mysqli_free_result($placas);

?>
