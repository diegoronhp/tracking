<?php
require_once('Connections/tracking.php'); 
require_once('config/login.php');
header('Content-Type: text/html; charset=ISO-8859-1');
//require_once('Connections/gps.php');

    $active_facturas="active";
	$active_productos="";
	$active_gps="";
	$active_usuarios="";	
	$title="FACTURACION";

$numero="'".base64_decode($_REQUEST["numero"])."'";

$query_consultafact = "SELECT * FROM facturacion WHERE numero=$numero";
$consultafact = mysqli_query($track, $query_consultafact) or die(mysqli_error($track));
$row_consultafact = mysqli_fetch_assoc($consultafact);

$cliente="'".$row_consultafact["id_cliente"]."'";


$query_consultanom = "SELECT * FROM clientes WHERE id_cliente=$cliente";
$consultanom = mysqli_query($track, $query_consultanom) or die(mysqli_error($track));
$row_consultanom = mysqli_fetch_assoc($consultanom);
						  
function nombremes($mes){
 setlocale(LC_TIME, 'spanish');  
 $nombre=strftime("%B",mktime(0, 0, 0, $mes, 1, 2000)); 
 return $nombre;
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

<style type="text/css">
	#popup {
		opacity: 0;
		margin-top: -100px;
		overflow-y: scroll;
		position:fixed;
		z-index: 1050;
	}
	#popup:target {
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
	.popup-contenedor {
		position: relative;
		margin:7% auto;
		padding:30px 50px;
		background-color: #fafafa;
		color:#333;
		border-radius: 3px;
		width:50%;
	}
	a.popup-cerrar {
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
    
	a.popup-link {
	    text-align: center;
	    display: block;
	    margin: 30px 0;
	}
	
	#popnw {
		opacity: 0;
		margin-top: -100px;
		overflow-y: scroll;
		position:fixed;
		z-index: 1050;
	}
	#popnw:target {
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
	.popnw-contenedor {
		position: relative;
		margin:7% auto;
		padding:30px 50px;
		background-color: #fafafa;
		color:#333;
		border-radius: 3px;
		width:50%;
	}
	a.popnw-cerrar {
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
    
	a.popnw-link {
	    text-align: center;
	    display: block;
	    margin: 30px 0;
	}

</style>


</head>

<body>

	
<?php include("config/menu.php");?>


<div class="container">

	<div class="panel panel-info">
		<div class="panel-heading">
		    <div class="btn-group pull-right">
	        	<?php if ($_GET['tm']!="b") { ?>	        
	        	<a href="facturacion.php" class="btn btn-default" title='Continuar facturando' ><i class="glyphicon glyphicon-list-alt"> Continuar </i></a>
	        	<?php
                 $impr='factura_pdf_ricoh.php';
                 $impe='factura_pdf_epson.php';} else {
                 $impe='factura_pdf_epson.php';
                 $impr='facturane_pdf.php';}?>	      
				<!-- <button type='button' class="btn btn-info" data-toggle="modal" data-target="#popnw"><span class="glyphicon glyphicon-plus" ></span> Nuevo Cliente</button> -->
			</div>
			<h4><i class='glyphicon glyphicon-list-alt'></i> Se ha generado satisfactoriamente la Factura No. <?php echo $row_consultafact["numero"];?></h4>
		</div>
		<div class="panel-body">
		
			
			
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th class="text-center">Cliente</th>
					<th class="text-center">Cantidad</th>
					<th class="text-center">Valor</th>
					<th class='text-right'></th>
					
				</tr>
				<tr>
						<td class="text-center"><?php echo $row_consultanom["nombre"];?></td>
						<td class="text-center"><?php echo $row_consultafact["cantidada"]+$row_consultafact["cantidadc"];?></td>
						<td class="text-center"><?php echo number_format($row_consultafact["valor_total"]);?></td>
						<td>
					<span class="pull-right">
					
					
					
			        <a href="informes/<?php echo $impr;?>?numero=<?php echo $row_consultafact["numero"];?>" class="btn btn-default" title='Imprimir Factura' ><i class="glyphicon glyphicon-list-alt"> Ricoh</i> </a>			  
			        <a href="informes/<?php echo $impe;?>?numero=<?php echo $row_consultafact["numero"];?>" class="btn btn-default" title='Imprimir Factura' target="_blank" ><i class="glyphicon glyphicon-list-alt"> Epson</i> </a>
					
					<a href="informes/placa_fact.php?numero=<?php echo $row_consultafact["numero"]; ?>&id_cliente=<?php echo $row_consultafact["id_cliente"]; ?>&id_grupo=<?php echo $row_consultafact["id_grupo"]; ?>" class="btn btn-default" title='Anexo' >  <i class="glyphicon glyphicon-export"></i> </a>
					</span>
					</td>
						
					</tr>
			  </table>
		
  </div>
</div>
	 
	 		 
	</div>



	
	<hr>
	<?php
	include("config/footer.php");
	?>



</body>
</html>
<?php
mysqli_free_result($consultanom);

mysqli_free_result($consultafact);
?>
