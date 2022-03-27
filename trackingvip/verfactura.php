<?php


require_once('Connections/tracking.php'); 
require_once('config/login.php');
  header('Content-Type: text/html; charset=ISO-8859-1'); 
//require_once('Connections/gps.php');
$_GET['campo'];
$_GET['numero'];
$_POST['campo'];
$_POST['numero'];
$_POST['concepto'];


if ($_GET['campo']=='f') {
	$numero=$_GET['numero'];
	$busqueda="numero='".$_GET['numero']."'";
	$busqueda1="factura='".$_GET['numero']."'";
}
if (isset($_POST['concepto'])) {
	$concepto=$_POST['concepto'];
} else {
	$concepto="no";
}

if ($_POST['campo']=='f') {
	$numero=$_POST['numero'];
	$busqueda="numero='".$_POST['numero']."'";
	$busqueda1="factura='".$_POST['numero']."'";
} elseif ($_POST['campo']=='n') {
	$nit=$_POST['numero'];
	
$query_consult = "SELECT * FROM clientes WHERE nit=$nit";
$consult = mysqli_query($track, $query_consult) or die(mysqli_error());
$row_consult = mysqli_fetch_assoc($consult);
	$busqueda="id_cliente='".$row_consult["id_cliente"]."'";	
}


if (!isset($row_consult["id_cliente"]) && isset($nit)) {
 header ("Location: http://trackingvip.co/trackingvip/consultafactura.php?e=erte8");
      }


$query_consultafact = "SELECT * FROM facturacion WHERE $busqueda";
$consultafact = mysqli_query($track, $query_consultafact) or die(mysqli_error());
$row_consultafact = mysqli_fetch_assoc($consultafact);

if (!isset($row_consultafact["id_cliente"])) {
 header ("Location: http://trackingvip.co/trackingvip/consultafactura.php?e=erte8");
      }


$busca = $row_consultafact["id_cliente"];
$query_consultafact1 = "SELECT numero, fecha_fact, facturacion.id_cliente, rc, nc, facturacion.estado, total, vencimiento, clientes.nombre FROM facturacion LEFT OUTER JOIN clientes ON clientes.id_cliente = facturacion.id_cliente LEFT JOIN (SELECT SUM(valor) AS rc, factura FROM movfacturas WHERE concepto = 'Recibo de Caja' GROUP BY factura) AS trc ON trc.factura = facturacion.numero LEFT JOIN (SELECT SUM(valor) AS nc, factura FROM movfacturas WHERE concepto = 'Nota Credito' GROUP BY factura) AS tnc ON tnc.factura = facturacion.numero WHERE facturacion.id_cliente = $busca AND facturacion.estado = 'a' ORDER BY vencimiento ASC";
$consultafact1 = mysqli_query($track, $query_consultafact1) or die(mysqli_error());
$row_consultafact1 = mysqli_fetch_assoc($consultafact1);




$elid=$row_consultafact["id_cliente"];
$query_consultanom = "SELECT * FROM clientes WHERE id_cliente=$elid";
$consultanom = mysqli_query($track, $query_consultanom) or die(mysqli_error());
$row_consultanom = mysqli_fetch_assoc($consultanom);


if (isset($busqueda1)) {
$query_estadofact = "SELECT *, nombre FROM movfacturas LEFT JOIN usuarios ON usuarios.id_usuario = movfacturas.id_usuario  WHERE $busqueda1";
$estadofact = mysqli_query($track, $query_estadofact) or die(mysqli_error());
$row_estadofact = mysqli_fetch_assoc($estadofact);

$query_estadofactrs = "SELECT SUM(valor) as lasuma FROM movfacturas WHERE $busqueda1 AND concepto='Recibo de Caja'";
$estadofactrs = mysqli_query($track, $query_estadofactrs) or die(mysqli_error());
$row_estadofactrs = mysqli_fetch_assoc($estadofactrs);

$query_estadofactns = "SELECT SUM(valor) as lasuma FROM movfacturas WHERE $busqueda1 AND concepto='Nota Credito'";
$estadofactns = mysqli_query($track, $query_estadofactns) or die(mysqli_error());
$row_estadofactns = mysqli_fetch_assoc($estadofactns);

}


$totalr =$row_estadofactrs["lasuma"];
$totaln =$row_estadofactns["lasuma"];
$total=$totalr+$totaln;
$saldo=number_format($row_consultafact["total"]-$total);



if ($row_consultafact["motivo"]=="mensualidad") {
$impr='factura_pdf_ricoh.php';
$impe='factura_pdf_epson.php';} else {
$impr='facturane_pdf.php';
$impe='factura_pdf_epson.php';}

$id_usuario = $row_usu["id_usuario"];



/*

$iva=round($row_consultotal["total"]*19/119);

			  if ($row_consultotala["total"] > 0) {
$subtotala=$row_consultotala["total"]-round($row_consultotala["total"]*19/119);
$valor_unia=$subtotala/$row_consultotala["cantidad"];
				} else {
				  $subtotala = 0;
				  $valor_unia = 0;
			  }

              if ($row_consultotalap["total"] > 0) {
$valora=($row_consultotalap["total"]/30/$row_consultotalap["cantidad"])*$row_consulplacasap["losdias"];
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
$valorc=($row_consultotalcp["total"]/30/$row_consultotalcp["cantidad"])*$row_consulplacascp["losdias"];
$subtotal1=$valorc-round($valorc*19/119);
$valor_uni1=$subtotal1/$row_consultotalcp["cantidad"];
} else {
				  $subtotal1 = 0;
				  $valor_uni1 = 0;
			  }

$subtotal=$subtotala+$subtotalc+$subtotalap+$subtotalcp;
$retefuente=round($subtotal*0.04);
$reteica=round($subtotal*0.009);
$total=$subtotal+$iva-$retefuente-$reteica;
$valortotal=$subtotal+$iva;

*/
    $active_facturas="active";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$title="Facturacion";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<style type="text/css">
	#popfac {
		opacity: 0;
		margin-top: -100px;
		overflow-y: scroll;
		position:fixed;
		z-index: 1050;
	}
	#popfac:target {
		visibility:visible;
		opacity: 1;
		background-color: rgba(0,0,0,0.8);
		position: fixed;  
		top:0;
		left:0;
		right:0;
		bottom:0;
		margin:0;
		-webkit-transition:all 1s;
		-moz-transition:all 1s;
		transition:all 1s;
	}
	.popfac-contenedor {
		position: relative;
		margin:7% auto;
		padding:30px 50px;
		background-color: #fafafa;
		color:#333;
		border-radius: 3px;
		width:50%;
	}
	a.popfac-cerrar {
		position: absolute;
		top:3px;
		right:3px;
		padding:7px 10px;
		font-size: 15px;
		text-decoration: none;
		line-height: 1;
		color: midnightblue;
	}
 
    /* estilos para el enlace */
    
	a.popfac-link {
	    text-align: center;
	    display: block;
	    margin: 30px 0;
	}

</style>



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
</head>
<body>	
<?php include("config/menu.php");?>
<div class="container">
	<div class="panel panel-info">
		<div class="panel-heading">
		   <div class="btn-group pull-right" id="parte1">
		   	<?php if ($_POST['campo']=='f' || $_GET['campo']=='f'){
	        if ($concepto=='no' ){
			  ?>
			  <a href="informes/<?php echo $impr;?>?numero=<?php echo $row_consultafact["numero"];?>" class="btn btn-default" title='Imprimir Factura' target="_blank" ><i class="glyphicon glyphicon-list-alt"> Ricoh</i> </a>			  
			  <a href="informes/<?php echo $impe;?>?numero=<?php echo $row_consultafact["numero"];?>" target="_blank" class="btn btn-default" title='Imprimir Factura' ><i class="glyphicon glyphicon-list-alt"> Epson</i> </a>
			<?php }
              }
			  ?>  
			  
			  
			   <?php if( $row_usu["facturacion"] == "e") { ?>
	        	<a href="#popfac" class="btn btn-default" title='Nuevo documento' ><i class="glyphicon glyphicon-plus"> Nuevo Documento </i></a>
			  <?php } ?>	 
			        
				<!-- <button type='button' class="btn btn-info" data-toggle="modal" data-target="#popnw"><span class="glyphicon glyphicon-plus" ></span> Nuevo Cliente</button> -->
			</div>
			
			<?php if (isset($busqueda1)) { ?>
			
		   <div class="btn-group pull-right">	
			  <h4>Saldo:<?php echo $saldo; ?>&nbsp;&nbsp;&nbsp;</h4>
			</div>
			<?php } ?>        
		   <div class="btn-group pull-right">
			  <?php if ($totaln > 0){
			  ?>
			  <h4>Nota Credito:<?php echo number_format($totaln); ?>&nbsp;&nbsp;&nbsp;</h4>			  
			<?php }
			  ?>
			</div>
		   <div class="btn-group pull-right">		   
			<?php if ($totalr > 0){
			  ?>
			  <h4>Recibos caja:<?php echo number_format($totalr); ?>&nbsp;&nbsp;&nbsp;</h4>			  
			<?php }
			  ?>
			</div>
			
			<h4><i class='glyphicon glyphicon-list-alt'></i>
			<?php if ($_POST['campo']=='f' || $_GET['campo']=='f') {
			  ?> Factura <?php echo $row_consultafact["numero"]; ?> - 
			<?php }
			  ?><?php echo $row_consultanom["nombre"]." ";
			  if (isset($_GET['numero'])) {
?><a href="informes/placa_fact.php?numero=<?php echo $numero;?>" class="btn btn-default" title='Excel' >  <i class="glyphicon glyphicon-export"></i> </a><?php }?></h4>
		</div>
		<div class="panel-body">		
		<div class="popup-contenedor">
		  <div class="modal-body"><!-- 
			<form class="form-horizontal" method="post" id="new_factura" name="new_factura" action="Connections/new_factura.php"> -->
        <?php if (isset($_POST['concepto']) && $concepto!='no'){
			  ?>
			<form class="form-horizontal" method="post" id="new_placa" name="new_placa" action="Connections/new_documento.php">	
			<input type="hidden" value="<?php echo $row_consultafact["numero"]; ?>" id="factura" name="factura">
			<input type="hidden" value="<?php echo $id_usuario; ?>" id="id_usuario" name="id_usuario">
			<input type="hidden" value="<?php echo $concepto; ?>" id="concepto" name="concepto">
			  <div class="form-group row">
             <label for="concepto" class="col-sm-2 control-label"><?php echo $concepto; ?></label>
				</div>	
			  <div class="form-group row">
				<label for="modelo" class="col-sm-2 control-label">Valor</label>
		  <div class="col-md-4">
				  <input type="text" class="form-control" id="valor" name="valor" value="" required>
				</div>
             <label for="ex1" class="col-sm-2 control-label">Fecha</label> 
				<div class="col-md-4">
             <input type="date" name="fecha" id="fecha" required>
             </div>
				</div>				
            <div class="form-group row">
             <label for="observaciones" class="col-sm-2 control-label">Observaciones</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="observaciones" name="observaciones" required >
				</div>
				</div>
		  <div class="modal-footer">
		  <button type="submit" class="btn btn-primary" id="actualizar_datos">ENVIAR</button>
			<a href="consultafactura.php" class="btn btn-default" title='Cancelar' ><i> CANCELAR </i></a><br /><br />
		  </div>
		  <div class="modal-footer">
				</div>
		  </form>
			<?php }
			  ?> 
			<?php if ($_POST['campo']=='f' || $_GET['campo']=='f') {
			  ?>
		  <div class="form-group row">
		  <div class="col-md-3">
          <label for="ex1">Fecha Factura:</label> 
           <span class="">
			   <i><?php echo $row_consultafact["fecha_fact"]; ?></i>
					</span>         
          </div>
		  <div class="col-md-3">
          <label for="ex1">Fecha Vencimiento:</label> 
           <span class="">
			   <i><?php echo $row_consultafact["vencimiento"]; ?></i>
					</span>         
          </div>
		  <div class="col-md-2">
          <label for="ex1">Nit:</label> 
           <span class="">
			   <i><?php echo $row_consultanom["nit"]; ?></i>
					</span>         
          </div>
		  <div class="col-md-1">
          <label for="ex1">DV:</label> 
           <span class="">
			   <i><?php echo $row_consultanom["dv"]; ?></i>
					</span>         
          </div>
          </div>
		  <div class="form-group row">
		  <div class="col-md-3">
          <label for="ex1">Sub Total:</label> 
           <span class="">
			   <i><?php echo number_format($row_consultafact["subtotal"]); ?></i>
					</span>         
          </div>
		  <div class="col-md-2">
          <label for="ex1">Iva:</label> 
           <span class="">
			   <i>
			   <?php if($row_consultafact["coniva"]=='s'){
			   echo number_format($row_consultafact["iva"]);
} else { echo '0'; }?>
				</i>
					</span>         
          </div>
		  <div class="col-md-2">
          <label for="ex1">RtFte:</label> 
           <span class="">
			   <i>
			   <?php if($row_consultafact["conretencion"]=='s'){
			   echo number_format($row_consultafact["retefuente"]);
} else { echo '0'; }?>
				</i>
					</span>         
          </div>
		  <div class="col-md-2">
          <label for="ex1">ReteIca:</label> 
           <span class="">
			   <i>
			   <?php if($row_consultafact["conretencion"]=='s'){
			   echo number_format($row_consultafact["reteica"]);
} else { echo '0'; }?>
				</i>
					</span>         
          </div>
		  <div class="col-md-3">
          <label for="ex1">Total:</label> 
           <span class="">
			   <i><?php echo number_format($row_consultafact["total"]); ?></i>
					</span>         
          </div>
          </div>
          <?php if ($row_consultafact["subtotalc"]>0) { ?>
			<hr align="center" noshade="noshade" size="4" width="90%" />
		  <div class="form-group row">
			  <div class="col-md-10">
				  <label for="ex1">Compra:</label></br>
           <span class="">
			   <i><?php echo $row_consultafact["descripcionc"]; ?></i>
					</span> 
          </div>
				</div>
		  <div class="form-group row">
			  <div class="col-md-2">
				  <label for="ex1">Cantidad:</label>
           <span class="">
			   <i><?php echo $row_consultafact["cantidadc"]; ?></i>
					</span> 
          </div>
			  <div class="col-md-2">
				  <label for="ex1">Valor:</label>
           <span class="">
			   <i><?php echo number_format($row_consultafact["subtotalc"]); ?></i>
					</span> 
          </div>
			  <div class="col-md-6">
				  <label for="ex1">Placas:</label>
           <span class="">
			   <i><?php echo $row_consultafact["placasc"]; ?></i>
					</span> 
          </div>
				</div>
          <?php } ?>
          <?php if ($row_consultafact["subtotala"]>0) { ?>
			<hr align="center" noshade="noshade" size="4" width="90%" />
		  <div class="form-group row">
			  <div class="col-md-10">
				  <label for="ex1">Arriendo:</label></br>
           <span class="">
			   <i><?php echo $row_consultafact["descripciona"]; ?></i>
					</span> 
          </div>
				</div>
		  <div class="form-group row">
			  <div class="col-md-2">
				  <label for="ex1">Cantidad:</label>
           <span class="">
			   <i><?php echo $row_consultafact["cantidada"]; ?></i>
					</span> 
          </div>
			  <div class="col-md-2">
				  <label for="ex1">Valor:</label>
           <span class="">
			   <i><?php echo number_format($row_consultafact["subtotala"]); ?></i>
					</span> 
          </div>
			  <div class="col-md-6">
				  <label for="ex1">Placas:</label>
           <span class="">
			   <i><?php echo $row_consultafact["placasa"]; ?></i>
					</span> 
          </div>
				</div>
          <?php } ?>
          <?php if ($row_consultafact["subtotal1"]>0) { ?>
			<hr align="center" noshade="noshade" size="4" width="90%" />
		  <div class="form-group row">
			  <div class="col-md-10">
				  <label for="ex1">Detalle 1:</label></br>
           <span class="">
			   <i><?php echo $row_consultafact["descripcion1"]; ?></i>
					</span> 
          </div>
				</div>
		  <div class="form-group row">
			  <div class="col-md-2">
				  <label for="ex1">Cantidad:</label>
           <span class="">
			   <i><?php echo $row_consultafact["cantidad1"]; ?></i>
					</span> 
          </div>
			  <div class="col-md-2">
				  <label for="ex1">Valor:</label>
           <span class="">
			   <i><?php echo number_format($row_consultafact["subtotal1"]); ?></i>
					</span> 
          </div>
			  <div class="col-md-6">
				  <label for="ex1">Placas:</label>
           <span class="">
			   <i><?php echo $row_consultafact["placas1"]; ?></i>
					</span> 
          </div>
				</div>
          <?php } ?>
          <?php if ($row_consultafact["subtotal2"]>0) { ?>
			<hr align="center" noshade="noshade" size="4" width="90%" />
		  <div class="form-group row">
			  <div class="col-md-10">
				  <label for="ex1">Detalle 2:</label></br>
           <span class="">
			   <i><?php echo $row_consultafact["descripcion2"]; ?></i>
					</span> 
          </div>
				</div>
		  <div class="form-group row">
			  <div class="col-md-2">
				  <label for="ex1">Cantidad:</label>
           <span class="">
			   <i><?php echo $row_consultafact["cantidad2"]; ?></i>
					</span> 
          </div>
			  <div class="col-md-2">
				  <label for="ex1">Valor:</label>
           <span class="">
			   <i><?php echo number_format($row_consultafact["subtotal2"]); ?></i>
					</span> 
          </div>
			  <div class="col-md-6">
				  <label for="ex1">Placas:</label>
           <span class="">
			   <i><?php echo $row_consultafact["placas2"]; ?></i>
					</span> 
          </div>
				</div>
          <?php } ?>
          <?php if ($row_consultafact["subtotal3"]>0) { ?>
			<hr align="center" noshade="noshade" size="4" width="90%" />
		  <div class="form-group row">
			  <div class="col-md-10">
				  <label for="ex1">Detalle 3:</label></br>
           <span class="">
			   <i><?php echo $row_consultafact["descripcion3"]; ?></i>
					</span> 
          </div>
				</div>
		  <div class="form-group row">
			  <div class="col-md-2">
				  <label for="ex1">Cantidad:</label>
           <span class="">
			   <i><?php echo $row_consultafact["cantidad3"]; ?></i>
					</span> 
          </div>
			  <div class="col-md-2">
				  <label for="ex1">Valor:</label>
           <span class="">
			   <i><?php echo number_format($row_consultafact["subtotal3"]); ?></i>
					</span> 
          </div>
			  <div class="col-md-6">
				  <label for="ex1">Placas:</label>
           <span class="">
			   <i><?php echo $row_consultafact["placas3"]; ?></i>
					</span> 
          </div>
				</div>
          <?php } ?>
          <?php if ($row_consultafact["subtotal4"]>0) { ?>
			<hr align="center" noshade="noshade" size="4" width="90%" />
		  <div class="form-group row">
			  <div class="col-md-10">
				  <label for="ex1">Detalle 4:</label></br>
           <span class="">
			   <i><?php echo $row_consultafact["descripcion4"]; ?></i>
					</span> 
          </div>
				</div>
		  <div class="form-group row">
			  <div class="col-md-2">
				  <label for="ex1">Cantidad:</label>
           <span class="">
			   <i><?php echo $row_consultafact["cantidad4"]; ?></i>
					</span> 
          </div>
			  <div class="col-md-2">
				  <label for="ex1">Valor:</label>
           <span class="">
			   <i><?php echo number_format($row_consultafact["subtotal4"]); ?></i>
					</span> 
          </div>
			  <div class="col-md-6">
				  <label for="ex1">Placas:</label>
           <span class="">
			   <i><?php echo $row_consultafact["placas4"]; ?></i>
					</span>
          </div>
				</div>
          <?php } ?> <br />
			<?php }
			  ?>
			  
			  
			<?php if ($_POST['campo']=='n') {
			  ?>          
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>Factura</th>
					<th>Fecha</th>
					<th>Vencimiento</th>
					<th>Valor</th>
					<th class='text-center'>Saldo</th>
					<!-- <th>Agregado</th> -->
					<th class='text-right'></th>
					
				</tr>
				<?php   do { 
				        $rc=$row_consultafact1["rc"];
						$nc=$row_consultafact1["nc"];
						$cliente=$row_consultafact1["nombre"];
						$saldop=number_format($row_consultafact1["total"]-$rc-$nc);
				  
				  
						$factura=$row_consultafact1["numero"];
						$fecha=$row_consultafact1["fecha_fact"];
						$vence=$row_consultafact1["vencimiento"];
						$valor=number_format($row_consultafact1["total"]);
						$estado=$row_consultafact1["estado"];
						if ($estado=="a"){$elestado="Activo";}
						else {$elestado="Inactivo";}
						//$date_added= date('d/m/Y', strtotime($row['date_added']));
						
					?>
					<tr>						
						<td><?php echo $factura; ?></td>
						<td><?php echo $fecha; ?></td>
						<td><?php echo $vence; ?></td>
						<td><?php echo $valor; ?></td>
						<td class='text-center'><?php echo $saldop;?></td>
					<td ><span class="pull-right">
					<a href="verfactura.php?campo=f&numero=<?php echo $factura; ?>" class="btn btn-default" title='Detalle' ><i class="glyphicon glyphicon-eye-open"></i></a>
					</span></td>
						
					</tr>						
			  <?php } while ($row_consultafact1 = mysqli_fetch_assoc($consultafact1)); ?>
			  </table>
			</div>
			<?php }
			  ?>
          
           <?php if ($total>0) {
			  ?>
            <div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>Documento</th>
					<th>Valor</th>
					<th>Fecha</th>
					<th>Elaborado</th>
					<th>Usuario</th>
					
				</tr>
        			<?php	do { 
                        $concepto=$row_estadofact["concepto"];
						$valor=number_format($row_estadofact["valor"]);
						$fecha=$row_estadofact["fecha"];
						$elaborado=$row_estadofact["elaborado"];
						$usuario=$row_estadofact["nombre"];
						$observaciones=$row_estadofact["observaciones"];
						//$date_added= date('d/m/Y', strtotime($row['date_added']));
						
					?>
					<tr>
						<td style="font-weight: bold"><?php echo $concepto; ?></td>
						<td><?php echo $valor; ?></td>
						<td><?php echo $fecha; ?></td>
						<td><?php echo $elaborado; ?></td>
						<td><?php echo $usuario;?></td>
						
					</tr>
					<tr>
						<td colspan="5">Observaciones:<br />
                        <?php if(empty($observaciones)) {
						echo "- -";
					} else {
						echo $observaciones; 
					}?><br /><br />
                    </td>
					</tr>
<?php } while ($row_estadofact = mysqli_fetch_assoc($estadofact));	
			  ?>
			  </table>	
			</div>
			<?php }
			  ?>
		  </div>
		  </div>
		  </div>
		  </div>
		
	 <div class="modal-wrapper" id="popfac">
		<div class="popfac-contenedor">
		<a class="popfac-cerrar" href="#">X</a>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Tipo de documento</h4><br />
			<form class="form-horizontal" method="post" id="tipo_doc" name="tipo_doc" action="b_factura.php">		
			  <div class="form-group row">	
				<div class="col-sm-6">
				 <select class="form-control" id="tipo" name="tipo" required>
					<option value=""></option>
					<option value="r">Recibo de caja</option>
					<option value="n">Nota Credito</option>
				  </select>
				</div>
				</div>
		  <div class="modal-footer">
		  <button type="submit" class="btn btn-primary" id="enviar">SIGUIENTE</button>
			<a href="consultafactura.php" class="btn btn-default" title='Cancelar' ><i> CANCELAR </i></a><br /><br />
		  </div>
		  </form>
			
			
		  </div>
		</div> 

<?php
	include("config/footer.php");
	?>

</body>
</html>
<?php
mysqli_free_result($consultanom);
mysqli_free_result($consultafact);
if ($_POST['campo']=='n') {
mysqli_free_result($consult);
}
?>