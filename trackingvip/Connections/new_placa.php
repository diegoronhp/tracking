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



$query_cliente = "SELECT * FROM clientes ORDER BY nombre ASC";;
$cliente = mysqli_query($track, $query_cliente) or die(mysqli_error());
$row_cliente = mysqli_fetch_assoc($cliente);
$totalRows_cliente = mysqli_num_rows($cliente);

if (empty($_POST['placa'])) {
           $errors[] = "Placa vacío";
        }else if (empty($_POST['id_cliente'])) {
           $errors[] = "Cliente vacío";
        }   else if (
			!empty($_POST['placa']) &&
			!empty($_POST['id_cliente'])
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
	    $placa=mysqli_real_escape_string($con,(strip_tags($_POST["placa"],ENT_QUOTES)));
        $id_equipo=mysqli_real_escape_string($con,(strip_tags($_POST["id_equipo"],ENT_QUOTES)));
		$id_cliente=mysqli_real_escape_string($con,(strip_tags($_POST["id_cliente"],ENT_QUOTES)));
		$id_grupos=1;
		$subgrupo=mysqli_real_escape_string($con,(strip_tags($_POST["subgrupo"],ENT_QUOTES)));
		$estado=mysqli_real_escape_string($con,(strip_tags($_POST["estado"],ENT_QUOTES)));
		$tipo_contrato=mysqli_real_escape_string($con,(strip_tags($_POST["tipo_contrato"],ENT_QUOTES)));
		$avl=mysqli_real_escape_string($con,(strip_tags($_POST["avl"],ENT_QUOTES)));
		$ciudad=mysqli_real_escape_string($con,(strip_tags($_POST["ciudad"],ENT_QUOTES)));
	    $plataforma=mysqli_real_escape_string($con,(strip_tags($_POST["plataforma"],ENT_QUOTES)));
	    $id_sim=mysqli_real_escape_string($con,(strip_tags($_POST["id_sim"],ENT_QUOTES)));
	    $valor_mensual=mysqli_real_escape_string($con,(strip_tags($_POST["valor_mensual"],ENT_QUOTES)));
	    $propietario=mysqli_real_escape_string($con,(strip_tags($_POST["propietario"],ENT_QUOTES)));
	    $tipo_vehiculo=mysqli_real_escape_string($con,(strip_tags($_POST["tipo_vehiculo"],ENT_QUOTES)));
	    $tel_propietario=mysqli_real_escape_string($con,(strip_tags($_POST["tel_propietario"],ENT_QUOTES)));
	    $referencia1=mysqli_real_escape_string($con,(strip_tags($_POST["referencia1"],ENT_QUOTES)));
	    $referencia2=mysqli_real_escape_string($con,(strip_tags($_POST["referencia2"],ENT_QUOTES)));
	    $referencia3=mysqli_real_escape_string($con,(strip_tags($_POST["referencia3"],ENT_QUOTES)));
	    $observaciones=mysqli_real_escape_string($con,(strip_tags($_POST["observaciones"],ENT_QUOTES)));
	    $fecha=mysqli_real_escape_string($con,(strip_tags($_POST["fecha"],ENT_QUOTES)));
	    $fecha_compra=mysqli_real_escape_string($con,(strip_tags($_POST["fecha_compra"],ENT_QUOTES)));
	    $id_usuario=mysqli_real_escape_string($con,(strip_tags($row_usu["id_usuario"],ENT_QUOTES)));
	



$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

if (isset($_POST['placa'])) {
  $insertSQL = sprintf("INSERT INTO movequipos (placa,id_equipo,id_cliente,id_grupos,subgrupo,estado,tipo_contrato,avl,ciudad,plataforma,id_sim,valor_mensual,propietario,tipo_vehiculo,tel_propietario,referencia1,referencia2,referencia3,observaciones,fecha,fecha_compra,id_usuario) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($placa, "text"),
					   GetSQLValueString($id_equipo, "int"),
                       GetSQLValueString($id_cliente, "int"),
					   GetSQLValueString($id_grupos, "int"),
                       GetSQLValueString($subgrupo, "text"),
                       GetSQLValueString($estado, "text"),
                       GetSQLValueString($tipo_contrato, "text"),
                       GetSQLValueString($avl, "text"),
                       GetSQLValueString($ciudad, "text"),
                       GetSQLValueString($plataforma, "text"),
                       GetSQLValueString($id_sim, "int"),
                       GetSQLValueString($valor_mensual, "text"),
                       GetSQLValueString($propietario, "text"),
                       GetSQLValueString($tipo_vehiculo, "text"),
                       GetSQLValueString($tel_propietario, "text"),
                       GetSQLValueString($referencia1, "text"),
                       GetSQLValueString($referencia2, "text"),
                       GetSQLValueString($referencia3, "text"),
                       GetSQLValueString($observaciones, "text"),
                       GetSQLValueString($fecha, "text"),
                       GetSQLValueString($fecha_compra, "text"),
                       GetSQLValueString($id_usuario, "int"));
	
  $sqlnew="INSERT INTO cambiosmov (placa, campo, cambio, id_usuario) VALUES ('$placa','placa','Creacion','$id_usuario')";
  mysqli_select_db($track, $database_track);
  $Result2 = mysqli_query($track, $sqlnew) or die(mysqli_error());
	
	

  mysqli_select_db($track, $database_track);
  $Result1 = mysqli_query($track, $insertSQL) or die(mysqli_error());
	unset($_SESSION["placa"]);
	unset($_SESSION["id_equipo"]);
	unset($_SESSION["id_cliente"]);
	
  $insertGoTo = "../vehiculos.php";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  }
  header(sprintf("Location: %s", $insertGoTo));
}	
}


mysqli_free_result($usu);
mysqli_free_result($cliente);

?>
