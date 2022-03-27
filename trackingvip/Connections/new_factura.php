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

/*
$query_facturacion = "SELECT * FROM facturacion";
$facturacion = mysqli_query($track, $query_facturacion) or die(mysqli_error($track));
$row_facturacion = mysqli_fetch_assoc($facturacion);
$totalRows_facturacion = mysqli_num_rows($facturacion);
*/

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
	    $corte=mysqli_real_escape_string($con,(strip_tags($_POST["corte"],ENT_QUOTES)));
        $id_grupos=mysqli_real_escape_string($con,(strip_tags($_POST["id_grupo"],ENT_QUOTES)));
		$placasc=mysqli_real_escape_string($con,(strip_tags($_POST["placasc"],ENT_QUOTES)));
		$placasa=mysqli_real_escape_string($con,(strip_tags($_POST["placasa"],ENT_QUOTES)));
		$estado=mysqli_real_escape_string($con,(strip_tags($_POST["estado"],ENT_QUOTES)));
		$numero=mysqli_real_escape_string($con,(strip_tags($_POST["factura"],ENT_QUOTES)));
		$valor_unic=mysqli_real_escape_string($con,(strip_tags($_POST["valor_unic"],ENT_QUOTES)));
		$valor_unia=mysqli_real_escape_string($con,(strip_tags($_POST["valor_unia"],ENT_QUOTES)));
		$valor_total=mysqli_real_escape_string($con,(strip_tags($_POST["valor_total"],ENT_QUOTES)));
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
	    $periodo=mysqli_real_escape_string($con,(strip_tags($_POST["periodo"],ENT_QUOTES)));
	    $descripcionc=$desc;
	    $descripciona=$desa;
		if (isset($_POST["coniva"])) {
	    $coniva2=mysqli_real_escape_string($con,(strip_tags($_POST["coniva"],ENT_QUOTES)));
		} else {
			$coniva2="n";
		}
	    $conretencion=mysqli_real_escape_string($con,(strip_tags($_POST["conretencion"],ENT_QUOTES)));
	    $conreteica=mysqli_real_escape_string($con,(strip_tags($_POST["conreteica"],ENT_QUOTES)));
	    $banco=mysqli_real_escape_string($con,(strip_tags($_POST["banco"],ENT_QUOTES)));
		$placas1=mysqli_real_escape_string($con,(strip_tags($_POST["placas1"],ENT_QUOTES)));
		$valor_uni1=mysqli_real_escape_string($con,(strip_tags($_POST["valor_uni1"],ENT_QUOTES)));
		$subtotal1=mysqli_real_escape_string($con,(strip_tags($_POST["subtotal1"],ENT_QUOTES)));
	    $cantidad1=mysqli_real_escape_string($con,(strip_tags($_POST["cantidad1"],ENT_QUOTES)));
	    $descripcion1=$desc1;
		$placas2=mysqli_real_escape_string($con,(strip_tags($_POST["placas2"],ENT_QUOTES)));
		$valor_uni2=mysqli_real_escape_string($con,(strip_tags($_POST["valor_uni2"],ENT_QUOTES)));
		$subtotal2=mysqli_real_escape_string($con,(strip_tags($_POST["subtotal2"],ENT_QUOTES)));
	    $cantidad2=mysqli_real_escape_string($con,(strip_tags($_POST["cantidad2"],ENT_QUOTES)));
	    $descripcion2=$desc2;
		$placas3=mysqli_real_escape_string($con,(strip_tags($_POST["placas3"],ENT_QUOTES)));
		$valor_uni3=mysqli_real_escape_string($con,(strip_tags($_POST["valor_uni3"],ENT_QUOTES)));
		$subtotal3=mysqli_real_escape_string($con,(strip_tags($_POST["subtotal3"],ENT_QUOTES)));
	    $cantidad3=mysqli_real_escape_string($con,(strip_tags($_POST["cantidad3"],ENT_QUOTES)));
	    $descripcion3=$desc3;
		$placas4=mysqli_real_escape_string($con,(strip_tags($_POST["placas4"],ENT_QUOTES)));
		$valor_uni4=mysqli_real_escape_string($con,(strip_tags($_POST["valor_uni4"],ENT_QUOTES)));
		$subtotal4=mysqli_real_escape_string($con,(strip_tags($_POST["subtotal4"],ENT_QUOTES)));
	    $cantidad4=mysqli_real_escape_string($con,(strip_tags($_POST["cantidad4"],ENT_QUOTES)));
	    $descripcion4=$desc4;
	

if($coniva2=="n") {
	$coniva="n";
	$subtotal=$valor_total;
	$total=$valor_total;
	$valor_unic=$valor_total;
	$subtotalc=$valor_total;
	$iva="0";
} else {
	$coniva="s";
}
	if(empty($conretencion)) {
	$conretencion="n";
	$retefuente="0";
} else {
	$conretencion="s";
}
	if(empty($conreteica)) {
	$conreteica="n";
	$reteica="0";
} else {
	$conreteica="s";
}

$editFormAction = $_SERVER['PHP_SELF'];
if (isset($_SERVER['QUERY_STRING'])) {
  $editFormAction .= "?" . htmlentities($_SERVER['QUERY_STRING']);
}
	$total=$subtotal+$iva-$retefuente-$reteica;

	
if (isset($_POST["id_cliente"])) {
  $insertSQL = sprintf("INSERT INTO facturacion (id_cliente, id_grupos, placasc, placasa, estado, numero, valor_unic, valor_unia, subtotalc, subtotala, valor_total, iva, retefuente, reteica, subtotal, total, cantidada, cantidadc, motivo, vencimiento, fecha_fact, periodo, descripcionc, descripciona, coniva, conretencion, conreteica, banco, placas1, valor_uni1, subtotal1, cantidad1, descripcion1, placas2, valor_uni2, subtotal2, cantidad2, descripcion2, placas3, valor_uni3, subtotal3, cantidad3, descripcion3, placas4, valor_uni4, subtotal4, cantidad4, descripcion4) VALUES (%s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($id_cliente, "int"),
					   GetSQLValueString($id_grupos, "int"),
                       GetSQLValueString($placasc, "text"),
                       GetSQLValueString($placasa, "text"),
                       GetSQLValueString($estado, "text"),
                       GetSQLValueString($numero, "text"),
                       GetSQLValueString($valor_unic, "int"),
                       GetSQLValueString($valor_unia, "int"),
                       GetSQLValueString($subtotalc, "int"),
                       GetSQLValueString($subtotala, "int"),
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

  $Result1 = mysqli_query($track, $insertSQL) or die(mysqli_error($track));
	
	
	
$query_cargaplaca = "SELECT id_cliente, estado, id_grupos, fecha, placa, valor_mensual FROM movequipos WHERE estado='a' AND fecha < CONCAT($q2,'-',$q1-1,'-',$corte) AND id_cliente=$id_cliente AND id_grupos=$id_grupos order by fecha ASC";
$cargaplaca = mysqli_query($track, $query_cargaplaca) or die(mysqli_error($track));
$row_cargaplaca = mysqli_fetch_assoc($cargaplaca);
	
	

	
	
	
	
/* ok anticipado	
$query_cargaplaca = "SELECT id_cliente, estado, id_grupos, fecha, placa, valor_mensual FROM movequipos WHERE estado='a' AND fecha < CONCAT($q2,'-',$q1,'-',$corte) AND id_cliente=$id_cliente AND id_grupos=$id_grupos order by fecha ASC";
$cargaplaca = mysqli_query($track, $query_cargaplaca) or die(mysqli_error($track));
$row_cargaplaca = mysqli_fetch_assoc($cargaplaca);
	
*/	
	
	
	
	
/*	

$query_cargaplaca = "SELECT movequipos.id_cliente, movequipos.estado, movequipos.id_grupos, movequipos.placa, movequipos.valor_mensual, movequipos.fecha, clientes.id_cliente FROM movequipos JOIN clientes ON movequipos.id_cliente = clientes.id_cliente JOIN grupos ON movequipos.id_grupos = grupos.id_grupos WHERE movequipos.estado='a' AND movequipos.fecha < CONCAT($q2,'-',$q1,'-',clientes.dia_corte) AND movequipos.id_cliente = $id_cliente";
$cargaplaca = mysqli_query($track, $query_cargaplaca) or die(mysqli_error($track));
$row_cargaplaca = mysqli_fetch_assoc($cargaplaca);

*/
	
	$motivo = "mensualidad";
	$periodo = $periodo;
	$dias_facturados = "30";
	$factura = $numero;
	
	do {
		$placa = $row_cargaplaca["placa"];
		$valor = $row_cargaplaca["valor_mensual"];
		
		
	$insertSQL2 = sprintf("INSERT INTO control_fact (placa, motivo, periodo, dias_facturados, valor, factura) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($placa, "text"),
                       GetSQLValueString($motivo, "text"),
                       GetSQLValueString($periodo, "text"),
                       GetSQLValueString($dias_facturados, "int"),
                       GetSQLValueString($valor, "int"),
                       GetSQLValueString($factura, "text"));

 
  $Result2 = mysqli_query($track, $insertSQL2) or die(mysqli_error($track));
	
	} while ($row_cargaplaca = mysqli_fetch_assoc($cargaplaca));	

$mespro = $q1-1;
	

$query_cargaplaca2 = "SELECT DATEDIFF(CONCAT($q2,'-',$mespro,'-','30'), fecha) AS losdias, movequipos.id_cliente, movequipos.estado, movequipos.id_grupos, movequipos.placa, movequipos.valor_mensual, movequipos.fecha, clientes.id_cliente FROM movequipos JOIN clientes ON movequipos.id_cliente = clientes.id_cliente JOIN grupos ON movequipos.id_grupos = grupos.id_grupos WHERE movequipos.estado='a' AND MONTH(fecha) = ($q1-1) AND YEAR(fecha) = $q2  AND movequipos.id_cliente = $id_cliente";
$cargaplaca2 = mysqli_query($track, $query_cargaplaca2) or die(mysqli_error($track));
$row_cargaplaca2 = mysqli_fetch_assoc($cargaplaca2);
	
	$motivo2 = "prorrateo";
	$periodo = $periodo;
	if ($row_cargaplaca2["valor_mensual"]> 0) {	
	do {
	    $dias_facturados1 = $row_cargaplaca2["losdias"]+1;
		$placa1 = $row_cargaplaca2["placa"];
		$valor1 = $row_cargaplaca2["valor_mensual"]/30*($row_cargaplaca2["losdias"]+1);
	
	$insertSQL3 = sprintf("INSERT INTO control_fact (placa, motivo, periodo, dias_facturados, valor, factura) VALUES (%s, %s, %s, %s, %s, %s)",
                       GetSQLValueString($placa1, "text"),
                       GetSQLValueString($motivo2, "text"),
                       GetSQLValueString($periodo, "text"),
                       GetSQLValueString($dias_facturados1, "int"),
                       GetSQLValueString($valor1, "int"),
                       GetSQLValueString($factura, "text"));


  $Result3 = mysqli_query($track, $insertSQL3) or die(mysqli_error($track));
	
	} while ($row_cargaplaca2 = mysqli_fetch_assoc($cargaplaca2));
	}
	
	
  $insertGoTo = "../facturado.php?numero=".base64_encode($_POST['factura']);
  if (isset($_SERVER['QUERY_STRING'])) {
    $insertGoTo .= (strpos($insertGoTo, '?')) ? "&" : "?";
    $insertGoTo .= $_SERVER['QUERY_STRING'];
  header(sprintf("Location: %s", $insertGoTo));
  }
}	
}

mysqli_free_result($usu);
mysqli_free_result($facturacion);
mysqli_free_result($cargaplaca);
?>