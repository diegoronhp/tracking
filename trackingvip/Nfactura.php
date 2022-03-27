<?php
require_once('Connections/tracking.php'); 
require_once('config/login.php');

$_POST['nit'];
$nit=$_POST['nit'];


$query_consultanom = "SELECT * FROM clientes WHERE nit=$nit";
$consultanom = mysqli_query($track, $query_consultanom) or die(mysqli_error($track));
$row_consultanom = mysqli_fetch_assoc($consultanom);


if (!isset($row_consultanom["nombre"])) {
 header ("Location: http://trackingvip.co/trackingvip/clientefactura.php?e=erte8");
      }

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
<head>
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
<script language="javascript">
function fAgrega()
{
document.getElementById("iva").value = (document.getElementById("subtotal").value*0.19).toFixed();
/*document.getElementById("retefuente").value = (document.getElementById("subtotal").value*0.04).toFixed();*/
document.getElementById("retefuente").value = parseInt(document.getElementById("subtotal").value*document.getElementById("porcentaje").value/100).toFixed();
document.getElementById("reteica").value = (document.getElementById("subtotal").value*9.66/1000).toFixed();
document.getElementById("total").value = parseInt(document.getElementById("subtotal").value) + parseInt(document.getElementById("iva").value) - parseInt(document.getElementById("retefuente").value) - parseInt(document.getElementById("reteica").value);
}
	

	
</script>
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
			<h4><i class='glyphicon glyphicon-list-alt'></i>Factura <?php echo $row_consultanom["nombre"]; ?></h4>
		</div>
		<div class="panel-body">
		
		
		<div class="popup-contenedor">
		  <div class="modal-body"><!-- 
			<form class="form-horizontal" method="post" id="new_factura" name="new_factura" action="Connections/new_factura.php"> -->
			<form class="form-horizontal" method="post" id="new_facturam" name="new_facturam" action="Connections/new_facturam.php">
			<input type="hidden" value="<?php echo $row_consultanom["id_cliente"]; ?>" id="id_cliente" name="id_cliente">
			<input type="hidden" value="a" id="estado" name="estado">
			<input type="hidden" value="1" id="id_grupo" name="id_grupo">
			<input type="hidden" value="otros" id="motivo" name="motivo">
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
          </div><!-- 
		  <div class="col-md-1">
          <label for="ex1"> Corte</label>
          <input class="form-control" id="ss2" value="<?php echo $row_consultanom["dia_corte"]; ?>" readonly type="text">
          </div>  -->         
		  </div>
		  <div class="form-group row">
			   <div class="col-md-2">
          <label for="ex1"> Sub Total</label>
          <input class="form-control" id="subtotal" name="subtotal" value="" type="text" onkeyup="fAgrega()";>
          </div>
          <div class="col-md-2">
          <input type="checkbox" value="s" id="coniva" name="coniva" checked><label for="ex1"> &nbsp;IVA</label>
          <input class="form-control" id="iva" name="iva" value="" type="text">
          </div>
          <div class="col-md-1">
          <label for="ex1">% Rtfe</label>
          <input class="form-control" id="porcentaje" name="porcentaje" value="" type="text" onkeyup="fAgrega()";>
          </div>
			   <div class="col-md-2">
          <input type="checkbox" value="s" id="conretencion" name="conretencion" checked><label for="ex1">&nbsp;ReteFuente</label>
          <input class="form-control" id="retefuente" name="retefuente" value="" type="text">
          </div>
          <div class="col-md-2">
          <input type="checkbox" value="s" id="conreteica" name="conreteica" checked><label for="ex1"> ReteIca</label>
          <input class="form-control" id="reteica" name="reteica" value="" type="text">
          </div>
			   <div class="col-md-2">
          <label for="ex1"> Total</label>
          <input class="form-control" id="total" name="total" value="" type="text">
          </div>
          </div>
				</div>
			<hr align="left" noshade="noshade" size="4" width="80%" />
		  <div class="form-group row">
			  <div class="col-md-10">
          <label for="ex1">Descripcion 1:</label> 
          <textarea class="form-control" rows="5" id="editor1" value="" name="descripcion1" required></textarea>
          <script type="text/javascript">
	CKEDITOR.replace( 'editor1' );
</script>
          </div>
				</div>
         <div class="form-group row">
			  <div class="col-md-7">
          <label for="ex1"> Detalle Placa:</label>
          <input class="form-control" id="placas1" name="placas1" value="" type="text">	
          </div>
          <div class="col-md-2">
          <label for="ex1"> Vlr Compra sin IVA</label>
          <input class="form-control" id="valor1" name="valor1" value="" type="text">
          </div>
         <div class="col-md-1">
          <label for="ex1"> Cantidad</label>
          <input class="form-control" id="cantidad1" name="cantidad1" value="" type="text">
          </div>
				</div>
		  <div class="form-group row">
			  <div class="col-md-10">
          <label for="ex1">Descripcion 2:</label> 
          <textarea class="form-control" rows="5" id="editor4" value="" name="descripcion2" required></textarea>
          <script type="text/javascript">
	CKEDITOR.replace( 'editor4' );
</script>
          </div>
				</div>
         <div class="form-group row">
			  <div class="col-md-7">
          <label for="ex1"> Detalle Placa:</label>
          <input class="form-control" id="placas2" name="placas2" value="" type="text">	
          </div>
          <div class="col-md-2">
          <label for="ex1"> Vlr Compra sin IVA</label>
          <input class="form-control" id="valor2" name="valor2" value="" type="text">
          </div>
         <div class="col-md-1">
          <label for="ex1"> Cantidad</label>
          <input class="form-control" id="cantidad2" name="cantidad2" value="" type="text">
          </div>
				</div>
				</div>	
			<hr align="left" noshade="noshade" size="4" width="80%" />	  
		  <div class="form-group row">
			  <div class="col-md-10">
          <label for="ex1">Descripcion 3:</label> 
          <textarea class="form-control" rows="5" id="editor2" value="" name="descripcion3" required></textarea>
          <script type="text/javascript">
	CKEDITOR.replace( 'editor2' );
</script>
          </div>
				</div>
         <div class="form-group row">
			  <div class="col-md-7">
          <label for="ex1"> Placa:</label>
          <input class="form-control" id="placas3" name="placas3" value="" type="text">	
          </div>
          <div class="col-md-2">
          <label for="ex1"> Vlr Compra sin IVA</label>
          <input class="form-control" id="valor3" name="valor3" value="" type="text">
          </div>
         <div class="col-md-1">
          <label for="ex1"> Cantidad</label>
          <input class="form-control" id="cantidad3" name="cantidad3" value="" type="text">
          </div>
				</div>
			<hr align="left" noshade="noshade" size="4" width="80%" />
		  <div class="form-group row">
			  <div class="col-md-10">
          <label for="ex1">Descripcion 4:</label>
          <textarea class="form-control" rows="5" id="editor3" value="" name="descripcion4" required></textarea>
          <script type="text/javascript">
	CKEDITOR.replace( 'editor3' );
</script>
          </div>
				</div>
				 <div class="form-group row">
			  <div class="col-md-7">
          <label for="ex1"> Detalle Placa:</label>
          <input class="form-control" id="placas4" name="placas4" value="" type="text">	
          </div>
          <div class="col-md-2">
          <label for="ex1"> Vlr Compra sin IVA</label>
          <input class="form-control" id="valor4" name="valor4" value="" type="text">
          </div>
         <div class="col-md-1">
          <label for="ex1"> Cantidad</label>
          <input class="form-control" id="cantidad4" name="cantidad4" value="" type="text">
          </div>
          </div>
			<hr align="left" noshade="noshade" size="4" width="80%" />
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
?>