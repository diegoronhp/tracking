<?php

require_once('Connections/tracking.php'); 
require_once('config/login.php');
//require_once('Connections/gps.php');



$query_consult = "SELECT id_cliente, nombre, nit FROM clientes WHERE id_cliente IN (SELECT facturacion.id_cliente FROM facturacion LEFT JOIN (SELECT SUM(valor) AS rc, factura FROM movfacturas WHERE concepto = 'Recibo de Caja' GROUP BY factura) AS trc ON trc.factura = facturacion.numero LEFT JOIN (SELECT SUM(valor) AS nc, factura FROM movfacturas WHERE concepto = 'Nota Credito' GROUP BY factura) AS tnc ON tnc.factura = facturacion.numero) ORDER BY nombre ASC ";
$consult = mysqli_query($track, $query_consult) or die(mysqli_error());
$row_consult = mysqli_fetch_assoc($consult);

/* if ($row_consultafact["motivo"]=="mensualidad") {
$imp='factura_pdf.php';} else {
$imp='facturane_pdf.php';} */

$id_usuario = $row_usu["id_usuario"];

    $active_facturas="active";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$title="Facturacion";

function diasv($fecha_i,$fecha_f)
{
	$dias	= (strtotime($fecha_i)-strtotime($fecha_f))/86400;
	$dias 	= abs($dias); $dias = floor($dias);		
	return $dias;
}


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
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
<script src="http://code.jquery.com/jquery-1.0.4.js"></script>

<style type="text/css" media="print">
@media print {
#parte1 {display:none;}
#parte2 {display:none;}
}

</style>
<style type="text/css">
#impe {
	padding:0px;
	line-height:0,2;
	border: none;
	}	
</style>
</head>
<body>	
<?php include("config/menu.php");?>
<div class="container">
	<div class="panel panel-info">	
		<div class="panel-heading">
		    <div class="btn-group pull-right">	        
				<!-- <button type='button' class="btn btn-info" data-toggle="modal" data-target="#popnw"><span class="glyphicon glyphicon-plus" ></span> Nuevo Cliente</button> -->
			</div>
			<h4>Estado de Cuenta Trackingvip</h4>
		</div>
		<div class="panel-body">		
		<div class="popup-contenedor">
		  <div class="modal-body">
			  
			<div class="table-responsive">
			  <table class="table">
				<?php
				  do {
	$elid = $row_consult["id_cliente"];
	mysqli_select_db($track, $database_track);
$query_consultafact = "SELECT numero, fecha_fact, facturacion.id_cliente, rc, nc, facturacion.estado, total, valor_total, vencimiento, clientes.nombre FROM facturacion LEFT OUTER JOIN clientes ON clientes.id_cliente = facturacion.id_cliente LEFT JOIN (SELECT SUM(valor) AS rc, factura FROM movfacturas WHERE concepto = 'Recibo de Caja' GROUP BY factura) AS trc ON trc.factura = facturacion.numero LEFT JOIN (SELECT SUM(valor) AS nc, factura FROM movfacturas WHERE concepto = 'Nota Credito' GROUP BY factura) AS tnc ON tnc.factura = facturacion.numero WHERE facturacion.id_cliente = $elid AND total > 0 ORDER BY vencimiento ASC";
$consultafact = mysqli_query($track, $query_consultafact) or die(mysqli_error());
$row_consultafact = mysqli_fetch_assoc($consultafact); 
				  
$t=0;
$todosaldo = 0;
	
do {
$t++;
$rc=$row_consultafact["rc"];
$nc=$row_consultafact["nc"];
$factura=$row_consultafact["numero"];
$fecha=$row_consultafact["fecha_fact"];
$vence=$row_consultafact["vencimiento"];
$valorf=number_format($row_consultafact["valor_total"]);
$valor=number_format($row_consultafact["valor_total"]-$rc-$nc);
$hoy=date("Y-m-d");
$mora= diasv($vence,$hoy);
if ($mora>0 && $mora <31) {
$dmora = "0-30";
}
if ($mora>30 && $mora <61) {
$dmora = ">30";
}
if ($mora>60 && $mora <121) {
$dmora = ">60";
}
if ($mora>120) {
$dmora = ">120";
}
if (empty($rc)){
$elrc = 0;}
else {$elrc = $rc;}
if (empty($nc)){
$elnc = 0;}
else {$elnc = $nc;}
$elsaldo = $row_consultafact["valor_total"] - $rc - $nc;
$todosaldo += $row_consultafact["valor_total"] - $row_consultafact["rc"] - $row_consultafact["nc"];
$todos += $todosaldo;
						//$date_added= date('d/m/Y', strtotime($row['date_added']));
						
	if($elsaldo!=0 && $vence < $hoy) { 
				  if ($t < 2) { ?>
					<tr>						
						<td colspan="8" style="border-top: double"><?php echo $row_consult["nombre"]." ".$row_consult["nit"]; ?></td>
					</tr>	
				<?php 
							 }
 ?>	
	
				<?php
		if ($t < 2) {
 ?>	
				<tr class="info">
					<th>Factura</th>
					<th>Fecha</th>
					<th>Vencimiento</th>
					<th>Valor</th>
					<th>Mora</th>
					<th>Vlr Mora</th>
					<th class='text-right'>Total</th>
					<th class='text-right'></th>
				</tr>	
				<?php 
							 }
 ?>					
						<tr class="text-left">						
						<td id="impe"><?php echo $factura; ?></td>
						<td id="impe"><?php echo $fecha; ?></td>
						<td id="impe"><?php echo $vence; ?></td>
						<td id="impe"><?php echo $valorf; ?></td>
						<td id="impe"><?php echo $dmora;?></td>
						<td id="impe"><?php echo $valor; ?></td>
						<td id="impe" class='text-right'><?php echo number_format($todosaldo); ?></td>
					<td id="impe"><span class="pull-right" id="parte1">
					<a href="verfactura.php?campo=f&numero=<?php echo $factura; ?>" class="btn btn-default" title='Detalle' ><i class="glyphicon glyphicon-eye-open"></i></a>
					</span></td>
					</tr>
					<?php  } ?>								
			  <?php } while ($row_consultafact = mysqli_fetch_assoc($consultafact)); ?>
			  <?php } while ($row_consult = mysqli_fetch_assoc($consult)); ?>
			  </table>
			  
			  <div style="background-color: cadetblue">
		    <div class="btn-group pull-right">
				<h4 style="font-weight: bold"><?php echo "Saldo total ".number_format($todos); ?></h4>
			</div>
		</div>
			</div>
		  </div>
		  </div>
		  </div>
		  </div>
		  </div>
<?php
	include("config/footer.php");
	?>
</body>
</html>
<?php
mysqli_free_result($consultafact);
mysqli_free_result($consult);
?>