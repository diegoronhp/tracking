<?php
require_once('Connections/tracking.php'); 
require_once('config/login.php');
header('Content-Type: text/html; charset=ISO-8859-1');
$_GET['id_cliente'];
$_GET['id_grupo'];
$_GET['fecha'];
$cliente=$_GET['id_cliente'];
$grupo=$_GET['id_grupo'];
$fecha="'".$_GET['fecha']."'";
$q1 = $_SESSION['q1'];
$q2 = $_SESSION['q2'];
function nombremes($mes){
 setlocale(LC_TIME, 'spanish');  
 $nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 
 return $nombre;
} 




$query_consultanom = "SELECT * FROM clientes WHERE id_cliente=$cliente";
$consultanom = mysqli_query($track, $query_consultanom) or die(mysqli_error($track));
$row_consultanom = mysqli_fetch_assoc($consultanom);



if ($row_consultanom["cobro"]=='Anticipado') {

if ($q1==1) {
$mespro = 12;
$q22 = $q2-1;
} else {
$mespro = $q1-1;
$q22 = $q2;
}
}

$corte=$row_consultanom["dia_corte"];

/* mayo 12 - no es necesario 
$query_consultotal = "SELECT COUNT(*) AS cantidad, id_cliente, SUM(valor_mensual) AS total, estado, placa, id_grupos, fecha FROM movequipos WHERE estado='a' AND fecha < CONCAT($q2,'-',$q1,'-',$corte) AND id_cliente=$cliente AND id_grupos=$grupo order by fecha ASC";
$consultotal = mysqli_query($track, $query_consultotal) or die(mysqli_error($track));
$row_consultotal = mysqli_fetch_assoc($consultotal);


$query_consulplacas = "SELECT id_cliente, estado, id_grupos, fecha, placa FROM movequipos WHERE estado='a' AND fecha < CONCAT($q2,'-',$q1,'-',$corte) AND id_cliente=$cliente AND id_grupos=$grupo order by fecha ASC";
$consulplacas = mysqli_query($track, $query_consulplacas) or die(mysqli_error($track));
$row_consulplacas = mysqli_fetch_assoc($consulplacas);
*/



$query_consultotala = "SELECT COUNT(*) AS cantidad, id_cliente, SUM(valor_mensual) AS total, estado, placa, id_grupos, fecha, tipo_contrato FROM movequipos WHERE estado='a' AND fecha < CONCAT($q2,'-',$q1,'-',$corte) AND id_cliente=$cliente AND id_grupos=$grupo AND tipo_contrato='ARRIENDO' order by fecha ASC";
$consultotala = mysqli_query($track, $query_consultotala) or die(mysqli_error($track));
$row_consultotala = mysqli_fetch_assoc($consultotala);


$query_consulplacasa = "SELECT id_cliente, estado, id_grupos, fecha, placa FROM movequipos WHERE estado='a' AND fecha < CONCAT($q2,'-',$q1,'-',$corte) AND id_cliente=$cliente AND id_grupos=$grupo AND tipo_contrato='ARRIENDO' order by fecha ASC";
$consulplacasa = mysqli_query($track, $query_consulplacasa) or die(mysqli_error($track));
$row_consulplacasa = mysqli_fetch_assoc($consulplacasa);


if ($row_consultanom["cobro"]=='Anticipado') {
	

$query_consultotalap = "SELECT COUNT(*) AS cantidad, id_cliente, SUM(valor_mensual) AS total, estado, placa, id_grupos, fecha, tipo_contrato FROM movequipos WHERE estado='a' AND MONTH(fecha) = ($mespro) AND YEAR(fecha) = $q2 AND id_cliente=$cliente AND id_grupos=$grupo AND tipo_contrato='ARRIENDO' order by fecha ASC";
$consultotalap = mysqli_query($track, $query_consultotalap) or die(mysqli_error($track));
$row_consultotalap = mysqli_fetch_assoc($consultotalap);


// no toma dias julio 9 - $query_consulplacasap = "SELECT id_cliente, estado, id_grupos, fecha, placa FROM movequipos WHERE estado='a' AND MONTH(fecha) = ($q1-1) AND YEAR(fecha) = $q2 AND id_cliente=$cliente AND id_grupos=$grupo AND tipo_contrato='ARRIENDO' order by fecha ASC";
$dia=$row_consultanom["dia_corte"];
	// revisar mespro para el prorrateo
//$mespro = $q1-1;
$query_consulplacasap = "SELECT SUM(DATEDIFF(CONCAT($q22,'-',$mespro,'-',$dia), fecha)) AS losdias, id_cliente, estado, id_grupos, fecha, placa FROM movequipos WHERE estado='a' AND MONTH(fecha) = ($mespro) AND YEAR(fecha) = $q2 AND id_cliente=$cliente AND id_grupos=$grupo AND tipo_contrato='ARRIENDO' order by fecha ASC";

$consulplacasap = mysqli_query($track, $query_consulplacasap) or die(mysqli_error($track));
$row_consulplacasap = mysqli_fetch_assoc($consulplacasap);

	
$query_consulplacasap1 = "SELECT id_cliente, estado, id_grupos, fecha, placa FROM movequipos WHERE estado='a' AND MONTH(fecha) = ($mespro) AND YEAR(fecha) = $q2 AND id_cliente=$cliente AND id_grupos=$grupo AND tipo_contrato='ARRIENDO' order by fecha ASC";

$consulplacasap1 = mysqli_query($track, $query_consulplacasap1) or die(mysqli_error($track));
$row_consulplacasap1 = mysqli_fetch_assoc($consulplacasap1);
	

}
//cambio doble =
if ($row_consultanom["cobro"] == 'Vencido') {
$dia=$row_consultanom["dia_corte"];

$mespro = $q1;
$mespro2 = $q1+1;

$query_consultotalap = "SELECT COUNT(*) AS cantidad, id_cliente, SUM(valor_mensual) AS total, estado, placa, id_grupos, fecha, tipo_contrato FROM movequipos WHERE estado='a' AND MONTH(fecha) = ($q1) AND YEAR(fecha) = $q2 AND id_cliente=$cliente AND id_grupos=$grupo AND tipo_contrato='ARRIENDO' order by fecha ASC";
$consultotalap = mysqli_query($track, $query_consultotalap) or die(mysqli_error($track));
$row_consultotalap = mysqli_fetch_assoc($consultotalap);


/* $query_consulplacasap = "SELECT id_cliente, estado, id_grupos, fecha, placa FROM movequipos WHERE estado='a' AND MONTH(fecha) = ($q1) AND YEAR(fecha) = $q2 AND id_cliente=$cliente AND id_grupos=$grupo AND tipo_contrato='ARRIENDO' order by fecha ASC"; */
$query_consulplacasap = "SELECT SUM(DATEDIFF(CONCAT($q2,'-',$mespro2,'-',$dia), fecha)) AS losdias, id_cliente, estado, id_grupos, fecha, placa FROM movequipos WHERE estado='a' AND fecha < CONCAT($q2,'-',$mespro2,'-',$dia) AND fecha > CONCAT($q2,'-',$q1,'-',$dia) AND id_cliente=$cliente AND id_grupos=$grupo AND tipo_contrato='ARRIENDO' order by fecha ASC"; 
$consulplacasap = mysqli_query($track, $query_consulplacasap) or die(mysqli_error($track));
$row_consulplacasap = mysqli_fetch_assoc($consulplacasap);

}

	

$query_consultotalc = "SELECT COUNT(*) AS cantidad, id_cliente, SUM(valor_mensual) AS total, estado, placa, id_grupos, fecha, tipo_contrato FROM movequipos WHERE estado='a' AND fecha < CONCAT($q2,'-',$q1,'-',$corte) AND id_cliente=$cliente AND id_grupos=$grupo AND tipo_contrato='COMPRA' order by fecha ASC";
$consultotalc = mysqli_query($track, $query_consultotalc) or die(mysqli_error($track));
$row_consultotalc = mysqli_fetch_assoc($consultotalc);


$query_consulplacasc = "SELECT id_cliente, estado, id_grupos, fecha, placa FROM movequipos WHERE estado='a' AND fecha < CONCAT($q2,'-',$q1,'-',$corte) AND id_cliente=$cliente AND id_grupos=$grupo AND tipo_contrato='COMPRA' order by fecha ASC";
$consulplacasc = mysqli_query($track, $query_consulplacasc) or die(mysqli_error($track));
$row_consulplacasc = mysqli_fetch_assoc($consulplacasc);


if ($row_consultanom["cobro"]=='Anticipado') {
/* cambio 4 enero 2020 mas linea 133, q1 por mespro y dia por uldia */
$a_date = $q2.'-'.$q1.'-'.$dia;
$fecha = new DateTime($a_date);
$fecha->modify('last day of this month');
$uldia = $fecha->format('d');

	
$query_consultotalcp = "SELECT COUNT(*) AS cantidad, id_cliente, SUM(valor_mensual) AS total, estado, placa, id_grupos, fecha, tipo_contrato FROM movequipos WHERE estado='a' AND MONTH(fecha) = ($mespro) AND YEAR(fecha) = $q22 AND id_cliente=$cliente AND id_grupos=$grupo AND tipo_contrato='COMPRA' order by fecha ASC";
$consultotalcp = mysqli_query($track, $query_consultotalcp) or die(mysqli_error($track));
$row_consultotalcp = mysqli_fetch_assoc($consultotalcp);

$dia=$row_consultanom["dia_corte"];	
$query_consulplacascp = "SELECT SUM(DATEDIFF(CONCAT($q22,'-',$mespro,'-',$uldia), fecha)) AS losdias, id_cliente, estado, id_grupos, fecha, placa FROM movequipos WHERE estado='a' AND fecha < CONCAT($q2,'-',$q1,'-',$dia) AND fecha > CONCAT($q22,'-',$mespro,'-',$dia) AND id_cliente=$cliente AND id_grupos=$grupo AND tipo_contrato='COMPRA' order by fecha ASC";
$consulplacascp = mysqli_query($track, $query_consulplacascp) or die(mysqli_error($track));
$row_consulplacascp = mysqli_fetch_assoc($consulplacascp);
	

$query_consulplacascp1 = "SELECT id_cliente, estado, id_grupos, fecha, placa FROM movequipos WHERE estado='a' AND MONTH(fecha) = ($mespro) AND YEAR(fecha) = $q22 AND id_cliente=$cliente AND id_grupos=$grupo AND tipo_contrato='COMPRA' order by fecha ASC";
$consulplacascp1 = mysqli_query($track, $query_consulplacascp1) or die(mysqli_error($track));
$row_consulplacascp1 = mysqli_fetch_assoc($consulplacascp1);

}


if ($row_consultanom["cobro"]=='Vencido') {

// julio 5 2018 no calcula dias de compra prorrateo $dia = $row_consultanom["dia_corte"]-1;
$dia = $row_consultanom["dia_corte"];
$mespro = $q1;
$mespro2 = $q1+1;

$query_consultotalcp = "SELECT COUNT(*) AS cantidad, id_cliente, SUM(valor_mensual) AS total, estado, placa, id_grupos, fecha, tipo_contrato FROM movequipos WHERE estado='a' AND fecha < CONCAT($q2,'-',$mespro2,'-',$dia) AND fecha > CONCAT($q2,'-',$q1,'-',$dia)AND id_cliente=$cliente AND id_grupos=$grupo AND tipo_contrato='COMPRA' order by fecha ASC";
$consultotalcp = mysqli_query($track, $query_consultotalcp) or die(mysqli_error($track));
$row_consultotalcp = mysqli_fetch_assoc($consultotalcp);

/* nuevo - agosto 6 2018 */
$a_date = $q2.'-'.$q1.'-'.$dia;
$fecha = new DateTime($a_date);
$fecha->modify('last day of this month');
$uldia = $fecha->format('d');


$query_consulplacascp = "SELECT SUM(DATEDIFF(CONCAT($q2,'-',$q1,'-',$uldia), fecha)) AS losdias, id_cliente, estado, id_grupos, fecha, placa FROM movequipos WHERE estado='a' AND fecha < CONCAT($q2,'-',$mespro2,'-',$dia) AND fecha > CONCAT($q2,'-',$q1,'-',$dia) AND id_cliente=$cliente AND id_grupos=$grupo AND tipo_contrato='COMPRA' order by fecha ASC";
$consulplacascp = mysqli_query($track, $query_consulplacascp) or die(mysqli_error($track));
$row_consulplacascp = mysqli_fetch_assoc($consulplacascp);

/* no funcionan dias- agosto 6 2018

$query_consulplacascp = "SELECT SUM(DATEDIFF(CONCAT($q2,'-',$q1,'-',$dia), fecha)) AS losdias, id_cliente, estado, id_grupos, fecha, placa FROM movequipos WHERE estado='a' AND fecha < CONCAT($q2,'-',$mespro2,'-',$dia) AND fecha > CONCAT($q2,'-',$q1,'-',$dia) AND id_cliente=$cliente AND id_grupos=$grupo AND tipo_contrato='COMPRA' order by fecha ASC";
$consulplacascp = mysqli_query($track, $query_consulplacascp) or die(mysqli_error($track));
$row_consulplacascp = mysqli_fetch_assoc($consulplacascp);
fin agos 6 2018 */

	/* mostrar listado de placas */

$query_consulplacascp1 = "SELECT id_cliente, estado, id_grupos, fecha, placa FROM movequipos WHERE estado='a' AND fecha < CONCAT($q2,'-',$mespro2,'-',$dia) AND fecha > CONCAT($q2,'-',$q1,'-',$dia) AND id_cliente=$cliente AND id_grupos=$grupo AND tipo_contrato='COMPRA' order by fecha ASC";
$consulplacascp1 = mysqli_query($track, $query_consulplacascp1) or die(mysqli_error($track));
$row_consulplacascp1 = mysqli_fetch_assoc($consulplacascp1);

}

/*
$iva=round($row_consultotal["total"]*19/119);
*/
			  if ($row_consultotala["total"] > 0) {
$subtotala=$row_consultotala["total"]-round($row_consultotala["total"]*19/119);
$valor_unia=$subtotala/$row_consultotala["cantidad"];
				} else {
				  $subtotala = 0;
				  $valor_unia = 0;
			  }

              if ($row_consultotalap["total"] > 0) {
// $valora=($row_consultotalap["total"]/30/$row_consultotalap["cantidad"])*(30-abs($row_consulplacasap["losdias"])); cambio 5 sep 2018, toma los dias restantes
$valora=($row_consultotalap["total"]/30/$row_consultotalap["cantidad"])*(abs($row_consulplacasap["losdias"])-1);
$subtotal2=$valora-round($valora*19/119);
$valor_uni2=$subtotalap/$row_consultotalap["cantidad"];
				} else {
				  $subtotal2 = 0;
				  $valor_uni2 = 0;
			  }

			  if ($row_consultotalc["total"] > 0) {
$subtotalc=$row_consultotalc["total"]-round($row_consultotalc["total"]*19/119);
$valor_unic=$subtotalc/$row_consultotalc["cantidad"];
} else {
				  $subtotalc = 0;
				  $valor_unic = 0;
			  }
if ($row_consultotalcp["total"] > 0) {
/* JULIO 5 2018 TOMA MAL CANTIDAD
$valorc=(($row_consultotalcp["total"]/$row_consultotalcp["cantidad"])/30)*((30*$row_consultotalcp["cantidad"])-abs($row_consulplacascp["losdias"])); */
/* JULIO 7 2018 TOMA MAL CANTIDAD
$valorc=(($row_consultotalcp["total"]/$row_consultotalcp["cantidad"])/30)*(abs($row_consulplacascp["losdias"])); */
/* AGOSTO 6 2018 TOMA MAL VALOR
$valorc=(($row_consultotalcp["total"]/$row_consultotalcp["cantidad"])/30)*((30*$row_consultotalcp["cantidad"])-abs($row_consulplacascp["losdias"]));
$subtotal1=$valorc-round($valorc*19/119);
$valor_uni1=$subtotal1/$row_consultotalcp["cantidad"]; */

/* valor total prorrareo compra - no se define adelantado o vencido
$valorc=(($row_consultotalcp["total"]/$row_consultotalcp["cantidad"])/30)*(30-abs($row_consulplacascp["losdias"]));
abril 9 2019 se modifica para que funcione alianza marzo(vencido) - dejo cada una por separado segun cobro */

if ($row_consultanom["cobro"]=="Anticipado") {
	$ll = 5;
	$valorc=(($row_consultotalcp["total"]/$row_consultotalcp["cantidad"])/30)*($row_consulplacascp["losdias"]);
  //  $valorc=(($row_consultotalcp["total"]/$row_consultotalcp["cantidad"])/30)*(30-abs($row_consulplacascp["losdias"]));
} 
	if ($row_consultanom["cobro"]=="Vencido") {
	$ll = 10;
    $valorc=(($row_consultotalcp["total"]/$row_consultotalcp["cantidad"])/30)*($row_consulplacascp["losdias"]);
}
$subtotal1=$valorc-round($valorc*19/119);
$valor_uni1=$subtotal1/$row_consultotalcp["cantidad"];
} else {
				  $subtotal1 = 0;
				  $valor_uni1 = 0;
			  }

$subtotal=$subtotala+$subtotalc+$subtotal1+$subtotal2;
$iva=round($subtotal*0.19);
$retefuente=round($subtotal*0.04);
$reteica=round($subtotal*0.00966);
$total=$subtotal+$iva-$retefuente-$reteica;
$valortotal=$subtotal+$iva;

    $active_facturas="active";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$title="Facturacion";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

<title><?php echo $title;?></title>

<script language="JavaScript" src="src/js/jquery-1.5.1.min.js"></script>
<script language="JavaScript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="stylesheet" />
<link rel="stylesheet" href="css/custom.css">
<link rel="stylesheet" href="css/login.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">
	<script src="config/ckeditor/ckeditor.js"></script>
	<script src="config/ckeditor/samples/js/sample.js"></script>
	<link rel="stylesheet" href="config/ckeditor/samples/css/samples.css">
	<link rel="stylesheet" href="config/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">


</head>
<body>

	
<?php include("config/menu.php");?>


<div class="container">

	<div class="panel panel-info">
		<div class="panel-heading">
		   <div class="btn-group pull-right">
        		        
	        	<!-- <a href="#popnw" class="btn btn-default" title='Nuevo cliente' onclick="obtener_datos('<?php echo $id_cliente;?>');" ><i class="glyphicon glyphicon-user"> Nuevo Cliente </i></a>	        
				<!-- <button type='button' class="btn btn-info" data-toggle="modal" data-target="#popnw"><span class="glyphicon glyphicon-plus" ></span> Nuevo Cliente</button> -->
			</div>
			<h4><i class='glyphicon glyphicon-list-alt'></i> Factura <?php echo $row_consultanom["nombre"]; ?> - Periodo <?php echo nombremes($q1);?> <?php echo $q2;?></h4>
		</div>
		<div class="panel-body">
		
		
		<div class="popup-contenedor">
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="new_factura" name="new_factura" action="Connections/new_factura.php">
			<input type="hidden" value="<?php echo $row_consultanom["id_cliente"]; ?>" id="id_cliente" name="id_cliente">
			<input type="hidden" value="<?php echo $grupo; ?>" id="id_grupo" name="id_grupo">
			<input type="hidden" value="mensualidad" id="motivo" name="motivo">
			<input type="hidden" value="a" id="estado" name="estado">
			<input type="hidden" value="<?php echo $row_consultanom["dia_corte"];?>" id="corte" name="corte">
			<input type="hidden" value="<?php echo $valor_unic;?>" id="valor_unic" name="valor_unic">
			<input type="hidden" value="<?php echo $valor_unia;?>" id="valor_unia" name="valor_unia">
			<input type="hidden" value="<?php echo $valor_uni1;?>" id="valor_uni1" name="valor_uni1">
			<input type="hidden" value="<?php echo $valor_uni2;?>" id="valor_uni2" name="valor_uni2">
			<input type="hidden" value="<?php echo $iva;?>" id="iva" name="iva">
			<input type="hidden" value="<?php echo $retefuente;?>" id="retefuente" name="retefuente">
			<input type="hidden" value="<?php echo $reteica;?>" id="reteica" name="reteica">
			<input type="hidden" value="<?php echo $valortotal;?>" id="valor_total" name="valor_total">
			<input type="hidden" value="<?php echo $total;?>" id="total" name="total">
			<input type="hidden" value="<?php echo $subtotal;?>" id="subtotal" name="subtotal">
			<input type="hidden" value="<?php echo $subtotala;?>" id="subtotala" name="subtotala">
			<input type="hidden" value="<?php echo $subtotalc;?>" id="subtotalc" name="subtotalc">
			<input type="hidden" value="<?php echo $subtotal1;?>" id="subtotal1" name="subtotal1">
			<input type="hidden" value="<?php echo $subtotal2;?>" id="subtotal2" name="subtotal2">
			<input type="hidden" value="<?php echo $q2.$q1;?>" id="periodo" name="periodo">
			
		  <div class="form-group row">
          <div class="col-md-3">
          <label for="ex1"> Fecha Factura</label> 
           <input type="date" name="fecha_fact" id="fecha_fact" required>
          </div>
		  <div class="col-md-3">
          <label for="ex1"> Fecha Vencimiento</label> 
           <input type="date" name="fecha_venc" id="fecha_venc" required>
          </div>
          <div class="col-md-2">
          <label for="ex1"> Factura No.</label>
          <input class="form-control" id="factura" name="factura" type="text" required>
          </div>
          <div class="col-md-4">          
          <div class="radio">
          <label><input type="radio" name="banco" id="banco" checked value="avvillas">Av Villas</label>
          </div>
          <div class="radio">
          <label><input type="radio" name="banco" id="banco" value="bogota">Bogota</label>
          </div>
          </div>
			  </div>
		  <div class="form-group row">
          <div class="col-md-7">
          <label for="ex1"> Nombre</label>
          <input class="form-control" id="ss5" value="<?php echo $row_consultanom["nombre"]; ?>" readonly type="text">
           </div> 
		  <div class="col-md-2">
          <label for="ex1"> Nit</label>
          <input class="form-control" id="ss4" value="<?php echo $row_consultanom["nit"]; ?>" readonly type="text">
          </div>
          <div class="col-md-1">
          <label for="ex1"> DV</label>
          <input class="form-control" id="ss3" value="<?php echo $row_consultanom["dv"]; ?>" readonly type="text">
          </div>
			  </div>
			  <div class="form-group row">
			  <div class="col-md-2">
          <label for="ex2"> Telefono</label>
          <input class="form-control" id="ss9" value="<?php echo $row_consultanom["telefono"]; ?>" readonly type="text">
          </div>
		  <div class="col-md-7">
          <label for="ex1"> Direccion</label>
          <input class="form-control" id="ss11" value="<?php echo $row_consultanom["direccion"]; ?>" readonly type="text">
          </div>
		  <div class="col-md-1">
          <label for="ex1"> Corte</label>
          <input class="form-control" id="ss2" value="<?php echo $row_consultanom["dia_corte"]; ?>" readonly type="text">
          </div>          
		  </div>
		  <div class="form-group row">
			   <div class="col-md-2">
          <label for="ex1"> Sub Total</label>
          <input class="form-control" id="ss14" value="<?php echo number_format($subtotal); ?>" readonly type="text">
          </div>
          <div class="col-md-2">
          <input type="checkbox" value="s" id="coniva" name="coniva" checked><label for="ex1"> &nbsp;IVA</label>
          <input class="form-control" id="ss6" value="<?php echo number_format($iva); ?>" readonly type="text">
          </div>
			   <div class="col-md-2">
          <input type="checkbox" value="s" id="conretencion" name="conretencion" checked><label for="ex1">&nbsp;ReteFuente</label>
          <input class="form-control" id="ss16" value="<?php echo number_format($retefuente); ?>" readonly type="text">
          </div>
          <div class="col-md-2">
          <input type="checkbox" value="s" id="conreteica" name="conreteica" checked><label for="ex1"> ReteIca</label>
          <input class="form-control" id="ss17" value="<?php echo number_format($reteica); ?>" readonly type="text">
          </div>
			   <div class="col-md-2">
          <label for="ex1"> Total</label>
          <input class="form-control" id="ss18" value="<?php echo number_format($total); ?>" readonly type="text">
          </div>
          </div>
				</div>
		  <?php 
			  if ($subtotalc > 0) {?>	
			<hr align="left" noshade="noshade" size="4" width="80%" />
		  <div class="form-group row">
			  <div class="col-md-10">
          <label for="ex1">Descripcion Compra:</label> 
          <textarea class="form-control" rows="5" id="editor" name="descripcionc" required></textarea>
          </div>
				</div>
         <div class="form-group row">
			  <div class="col-md-7">
          <label for="ex1"> Detalle Compra:</label>
          <input class="form-control" id="placasc" name="placasc" value="
              <?php
			  if($row_consultotalc["cantidad"]<8) {
				  echo "Placa: ";
              do {
				echo $row_consulplacasc["placa"]." "; 
			  } while ($row_consulplacasc = mysqli_fetch_assoc($consulplacasc));
			  } else {
				  echo "VER ANEXO";
			  }?>" readonly type="text">	
          </div>
          <div class="col-md-2">
          <label for="ex1"> Valor Compra</label>
          <input class="form-control" id="valorc" name="vaolrc" value="<?php echo number_format($subtotalc); ?>" readonly type="text">
          </div>
         <div class="col-md-1">
          <label for="ex1"> Cantidad</label>
          <input class="form-control" id="cantidadc" name="cantidadc" value="<?php echo $row_consultotalc["cantidad"]; ?>" readonly type="text">
          </div>
				</div>
				<?php } ?>
			
		  <?php 
			  if ($row_consulplacascp["losdias"] > 0) {?>	
			  <!-- oooooooooooojjjjjjjjjjoooooooooooooooo -->
			<hr align="left" noshade="noshade" size="4" width="80%" />
		  <div class="form-group row">
			  <div class="col-md-10">
          <label for="ex1">Descripcion Compra Prorateo:</label> 
          <textarea class="form-control" rows="5" id="editor1" name="descripcion1" required></textarea>
          <script type="text/javascript">
	CKEDITOR.replace( 'editor1' );
</script>
          </div>
				</div>
         <div class="form-group row">
			  <div class="col-md-7">
          <label for="ex1"> Detalle Compra Prorrateo:</label>
          <input class="form-control" id="placas1" name="placas1" value="
              <?php
			  if($row_consultotalcp["cantidad"]<8) {
				  echo "Placa: ";
              do {
				echo $row_consulplacascp1["placa"]." "; 
			  } while ($row_consulplacascp1 = mysqli_fetch_assoc($consulplacascp1));
			  } else {
				  echo "VER ANEXO";
			  }?>" readonly type="text">	
          </div>
          <div class="col-md-2">
          <label for="ex1"> Valor Compra</label>
          <input class="form-control" id="valor1" name="valor1" value="<?php echo number_format($subtotal1); ?>" readonly type="text">
          </div>
         <div class="col-md-1">
          <label for="ex1"> Cantidad</label>
          <input class="form-control" id="cantidad1" name="cantidad1" value="<?php echo $row_consultotalcp["cantidad"]; ?>" readonly type="text">
          </div>
				</div>
				<?php } ?>
			
		  <?php 
			  if ($subtotala > 0) {?>	
			<hr align="left" noshade="noshade" size="4" width="80%" />		  
		  <div class="form-group row">
			  <div class="col-md-10">
          <label for="ex1">Descripcion Arriendo: </label>
          <textarea class="form-control" rows="5" id="editor3" name="descripciona" required></textarea>
          <script type="text/javascript">
	CKEDITOR.replace( 'editor3' );
</script>
          </div>
				</div>
				 <div class="form-group row">
			  <div class="col-md-7">
          <label for="ex1"> Detalle Arriendo:</label>
          <input class="form-control" id="placasa" name="placasa" value="
              <?php
			  if($row_consultotala["cantidad"]<8) {
				  echo "Placa: ";
              do {
				echo $row_consulplacasa["placa"]." "; 
			  } while ($row_consulplacasa = mysqli_fetch_assoc($consulplacasa));
			  } else {
				  echo "VER ANEXO";
			  }?>" readonly type="text">	
          </div>
          <div class="col-md-2">
          <label for="ex1"> Valor Arriendo</label>
          <input class="form-control" id="valora" name="valora" value="<?php echo number_format($subtotala); ?>" readonly type="text">
          </div>
         <div class="col-md-1">
          <label for="ex1"> Cantidad</label>
          <input class="form-control" id="cantidada" name="cantidada" value="<?php echo $row_consultotala["cantidad"]; ?>" readonly type="text">
          </div>
				<?php } ?>
				
						  <?php 
			  if ($subtotal2 > 0) {?>	
			<hr align="left" noshade="noshade" size="4" width="80%" />
		  <div class="form-group row">
			  <div class="col-md-10">
          <label for="ex1">Descripcion Arriendo Prorrateo:</label> 
          <textarea class="form-control" rows="5" id="editor4" name="descripcion2" required></textarea>
          <script type="text/javascript">
	CKEDITOR.replace( 'editor4' );
</script>
          </div>
				</div>
         <div class="form-group row">
			  <div class="col-md-7">
          <label for="ex1"> Detalle Arriendo Prorateo:</label>
          <input class="form-control" id="placas2" name="placas2" value="
              <?php
			  if($row_consultotalap["cantidad"]<8) {
				  echo "Placa: ";
              do {
				echo $row_consulplacasap1["placa"]." "; 
			  } while ($row_consulplacasap1 = mysqli_fetch_assoc($consulplacasap1));
			  } else {
				  echo "VER ANEXO";
			  }?>" readonly type="text">	
          </div>
          <div class="col-md-2">
          <label for="ex1"> Valor Compra </label>
          <input class="form-control" id="valor2" name="valor2" value="<?php echo number_format($subtotal2); ?>" readonly type="text">
          </div>
         <div class="col-md-1">
          <label for="ex1"> Cantidad</label>
          <input class="form-control" id="cantidad2" name="cantidad2" value="<?php echo $row_consultotalap["cantidad"]; ?>" readonly type="text">
          </div>
				</div>
				<?php } ?>
				
				</div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary" id="actualizar_datos">GENERAR FACTURA</button>
			<a href="facturacion.php" class="btn btn-default" title='Cancelar' ><i class="glyphicon glyphicon-list-alt"> CANCELAR </i></a><br /><br />

		  </div>
		  </form>
		  </div>
		  </div>
		  </div>
		  </div>
		  </div>
		
		
		

<?php
	include("config/footer.php");
	?>
	<script>
	initSample();
</script>

</body>
</html>
<?php
mysqli_free_result($consultanom);
/*
mysqli_free_result($consultotal);

mysqli_free_result($consulplacas);
*/

mysqli_free_result($consultotala);

mysqli_free_result($consulplacasa);

mysqli_free_result($consultotalc);

mysqli_free_result($consulplacasc);

mysqli_free_result($consultotalcp);

mysqli_free_result($consulplacascp);

mysqli_free_result($consultotalap);

mysqli_free_result($consulplacasap);

mysqli_free_result($consulplacasap1);
?>