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


$_SESSION['q1'];
$q1 = $_SESSION['q1'];
$_SESSION['q2'];
$q2 = $_SESSION['q2'];


$query_facturacion = "SELECT * FROM facturacion";;
$facturacion = mysqli_query($track, $query_facturacion) or die(mysqli_error($track));
$row_facturacion = mysqli_fetch_assoc($facturacion);
$totalRows_facturacion = mysqli_num_rows($facturacion);



$des = str_replace( "<p>",'',$_POST["descripcionc"]);
$desc = str_replace( "</p>",'<br />',$des);
$des2 = str_replace( "<p>",'',$_POST["descripciona"]);
$desa = str_replace( "</p>",'<br />',$des2);
$des3 = str_replace( "<p>",'',$_POST["descripcion1"]);
$desc1 = str_replace( "</p>",'<br />',$des3);
$des4 = str_replace( "<p>",'',$_POST["descripcion2"]);
$desc2 = str_replace( "</p>",'<br />',$des4);
$des5 = str_replace( "<p>",'',$_POST["descripcion3"]);
$desc3 = str_replace( "</p>",'<br />',$des5);
$des6 = str_replace( "<p>",'',$_POST["descripcion4"]);
$desc4 = str_replace( "</p>",'<br />',$des6);


if (empty($_POST['id_cliente'])) {
           $errors[] = "Cliente vacío";
        }else if (empty($_POST['id_grupo'])) {
           $errors[] = "Grupo vacío";
        }  else if ($_POST['fecha_fact']==""){
			$errors[] = "Selecciona fecha";
		}  else if (
			!empty($_POST['id_cliente']) &&
			!empty($_POST['id_grupo']) &&
			$_POST['estado']!="" 
		){
		/* Connect To Database*/
		require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
		require_once ("../config/conexion.php");//Contiene funcion que conecta a la base de datos
		// escaping, additionally removing everything that could be (html/javascript-) code
	    $id_cliente=mysqli_real_escape_string($con,(strip_tags($_POST["id_cliente"],ENT_QUOTES)));
        $id_grupos=mysqli_real_escape_string($con,(strip_tags($_POST["id_grupo"],ENT_QUOTES)));
		$placasc=mysqli_real_escape_string($con,(strip_tags($_POST["placasc"],ENT_QUOTES)));
		$placasa=mysqli_real_escape_string($con,(strip_tags($_POST["placasa"],ENT_QUOTES)));
		$estado=mysqli_real_escape_string($con,(strip_tags($_POST["estado"],ENT_QUOTES)));
		$numero=mysqli_real_escape_string($con,(strip_tags($_POST["factura"],ENT_QUOTES)));
		$valor_unic=mysqli_real_escape_string($con,(strip_tags($_POST["valor_unic"],ENT_QUOTES)));
		$valor_unia=mysqli_real_escape_string($con,(strip_tags($_POST["valor_unia"],ENT_QUOTES)));
		$subtotala=mysqli_real_escape_string($con,(strip_tags($_POST["subtotala"],ENT_QUOTES)));
		$subtotalc=mysqli_real_escape_string($con,(strip_tags($_POST["subtotalc"],ENT_QUOTES)));
		$iva=mysqli_real_escape_string($con,(strip_tags($_POST["iva"],ENT_QUOTES)));
		$retefuente=mysqli_real_escape_string($con,(strip_tags($_POST["retefuente"],ENT_QUOTES)));
		$reteica=mysqli_real_escape_string($con,(strip_tags($_POST["reteica"],ENT_QUOTES)));
	    $subtotal=mysqli_real_escape_string($con,(strip_tags($_POST["subtotal"],ENT_QUOTES)));
	    $total=mysqli_real_escape_string($con,(strip_tags($_POST["total"],ENT_QUOTES)));
	    $cantidada=mysqli_real_escape_string($con,(strip_tags($_POST["cantidada"],ENT_QUOTES)));
	    $cantidadc=mysqli_real_escape_string($con,(strip_tags($_POST["cantidadc"],ENT_QUOTES)));
	    $motivo=mysqli_real_escape_string($con,(strip_tags($_POST["motivo"],ENT_QUOTES)));
	    $vencimiento=mysqli_real_escape_string($con,(strip_tags($_POST["fecha_venc"],ENT_QUOTES)));
	    $fecha_fact=mysqli_real_escape_string($con,(strip_tags($_POST["fecha_fact"],ENT_QUOTES)));
	    $periodo=1;
	    $descripcionc=$desc;
	    $descripciona=$desa;
	    $coniva=mysqli_real_escape_string($con,(strip_tags($_POST["coniva"],ENT_QUOTES)));
	    $conretencion=mysqli_real_escape_string($con,(strip_tags($_POST["conretencion"],ENT_QUOTES)));
	    $conreteica=mysqli_real_escape_string($con,(strip_tags($_POST["conreteica"],ENT_QUOTES)));
	    $banco=mysqli_real_escape_string($con,(strip_tags($_POST["banco"],ENT_QUOTES)));
		$placas1=mysqli_real_escape_string($con,(strip_tags($_POST["placas1"],ENT_QUOTES)));
		$subtotal1=mysqli_real_escape_string($con,(strip_tags($_POST["valor1"],ENT_QUOTES)));
	    $cantidad1=mysqli_real_escape_string($con,(strip_tags($_POST["cantidad1"],ENT_QUOTES)));
	    if ($cantidad1>0) {
		$valor_uni1=$subtotal1/$cantidad1;
			} else {
			$valor_uni1=0;
		}
	    $descripcion1=$desc1;
		$placas2=mysqli_real_escape_string($con,(strip_tags($_POST["placas2"],ENT_QUOTES)));
		$subtotal2=mysqli_real_escape_string($con,(strip_tags($_POST["valor2"],ENT_QUOTES)));
	    $cantidad2=mysqli_real_escape_string($con,(strip_tags($_POST["cantidad2"],ENT_QUOTES)));
		if ($cantidad2>0) {
		$valor_uni2=$subtotal2/$cantidad2;
			} else {
			$valor_uni2=0;
		}
	    $descripcion2=$desc2;
		$placas3=mysqli_real_escape_string($con,(strip_tags($_POST["placas3"],ENT_QUOTES)));
		$subtotal3=mysqli_real_escape_string($con,(strip_tags($_POST["valor3"],ENT_QUOTES)));
	    $cantidad3=mysqli_real_escape_string($con,(strip_tags($_POST["cantidad3"],ENT_QUOTES)));
		if ($cantidad3>0) {
		$valor_uni3=$subtotal3/$cantidad3;
			} else {
			$valor_uni3=0;
		}
	    $descripcion3=$desc3;
		$placas4=mysqli_real_escape_string($con,(strip_tags($_POST["placas4"],ENT_QUOTES)));
		$subtotal4=mysqli_real_escape_string($con,(strip_tags($_POST["valor4"],ENT_QUOTES)));
	    $cantidad4=mysqli_real_escape_string($con,(strip_tags($_POST["cantidad4"],ENT_QUOTES)));
		if ($cantidad4>0) {
		$valor_uni4=$subtotal4/$cantidad4;
			} else {
			$valor_uni4=0;
		}
	    $descripcion4=$desc4;
	if(empty($coniva)) {
	$coniva="n";
} else {
	$coniva="s";
}
	if(empty($conretencion)) {
	$conretencion="n";
} else {
	$conretencion="s";
}
	if(empty($conreteica)) {
	$conreteica="n";
} else {
	$conreteica="s";
}
	if ($coniva!="s") {
		$masiva=0;
	} else {
		$masiva=$iva;
	}
	if ($conretencion!="s") {
		$masretefuente=0;
	} else {
		$masretefuente=$retefuente;
	}
	
	if ($conreteica!="s") {
		$masreteica=0;
	} else {
		$masreteica=$reteica;
	}
		$total=$subtotal+$masiva-$masretefuente-$masreteica;
		$valor_total=$total+$reteica+$retefuente;
	



$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}

	
if (isset($_POST["id_cliente"])) {
  $insertSQL = sprintf("INSERT INTO facturacion (id_cliente, id_grupos, placasc, placasa, estado, numero, valor_total, iva, retefuente, reteica, subtotal, total, cantidada, cantidadc, motivo, vencimiento, fecha_fact, periodo, descripcionc, descripciona, coniva, conretencion, conreteica, banco, placas1, valor_uni1, subtotal1, cantidad1, descripcion1, placas2, valor_uni2, subtotal2, cantidad2, descripcion2, placas3, valor_uni3, subtotal3, cantidad3, descripcion3, placas4, valor_uni4, subtotal4, cantidad4, descripcion4) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($id_cliente, "int"),
					   GetSQLValueString($id_grupos, "int"),
                       GetSQLValueString($placasc, "text"),
                       GetSQLValueString($placasa, "text"),
                       GetSQLValueString($estado, "text"),
                       GetSQLValueString($numero, "text"),
                       GetSQLValueString($valor_total, "int"),
                       GetSQLValueString($iva, "int"),
                       GetSQLValueString($retefuente, "int"),
                       GetSQLValueString($reteica, "int"),
                       GetSQLValueString($subtotal, "int"),
                       GetSQLValueString($total, "int"),
                       GetSQLValueString($cantidada, "int"),
                       GetSQLValueString($cantidadc, "int"),
                       GetSQLValueString($motivo, "text"),
                       GetSQLValueString($vencimiento, "text"),
                       GetSQLValueString($fecha_fact, "text"),
                       GetSQLValueString($periodo, "text"),
                       GetSQLValueString($descripcionc, "text"),
                       GetSQLValueString($descripciona, "text"),
                       GetSQLValueString($coniva, "text"),
                       GetSQLValueString($conretencion, "text"),
                       GetSQLValueString($conreteica, "text"),
                       GetSQLValueString($banco, "text"),
					   GetSQLValueString($placas1, "text"),
                       GetSQLValueString($valor_uni1, "int"),
                       GetSQLValueString($subtotal1, "int"),
                       GetSQLValueString($cantidad1, "int"),
                       GetSQLValueString($descripcion1, "text"),
					   GetSQLValueString($placas2, "text"),
                       GetSQLValueString($valor_uni2, "int"),
                       GetSQLValueString($subtotal2, "int"),
                       GetSQLValueString($cantidad2, "int"),
                       GetSQLValueString($descripcion2, "text"),
					   GetSQLValueString($placas3, "text"),
                       GetSQLValueString($valor_uni3, "int"),
                       GetSQLValueString($subtotal3, "int"),
                       GetSQLValueString($cantidad3, "int"),
                       GetSQLValueString($descripcion3, "text"),
					   GetSQLValueString($placas4, "text"),
                       GetSQLValueString($valor_uni4, "int"),
                       GetSQLValueString($subtotal4, "int"),
                       GetSQLValueString($cantidad4, "int"),
                       GetSQLValueString($descripcion4, "text"));

  mysqli_select_db($track, $database_track);
  $Result1 = mysqli_query($track, $insertSQL) or die(mysqli_error($track));
	
	
  $insertGoTo = "../facturado.php?numero=".base64_encode($_POST['factura'])."&tm=b";
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  header(sprintf("Location: %s", $insertGoTo));
  }
}	
}

mysqli_free_result($usu);
mysqli_free_result($facturacion);


?>
