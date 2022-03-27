<?php
require_once('Connections/tracking.php'); 
require_once('config/login.php');
//require_once('Connections/gps.php');

    $active_fact="active";
	$active_productos="";
	$active_gps="";
	$active_usuarios="";	
	$title="FACTURACION";

$_SESSION['q1']="";
$_SESSION['q2']="";


?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta charset="windows-1252">

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
		   <!--  <div class="btn-group pull-right">
	        		        
	        	<a href="#popnw" class="btn btn-default" title='Nuevo cliente' onclick="obtener_datos('<?php echo $id_cliente;?>');" ><i class="glyphicon glyphicon-cd"> Facturacion </i></a>	        
				<button type='button' class="btn btn-info" data-toggle="modal" data-target="#popnw"><span class="glyphicon glyphicon-plus" ></span> Nuevo Cliente</button> 
			</div> -->
			<h4><i class='glyphicon glyphicon-list-alt'></i> Facturacion<?php echo $q1;?></h4>
		</div>
		<div class="panel-body">
		<!--  <form action="facturacion.php" method="post"><input type="tel" id="q1" name="q1" /><input type="submit" /></form>-->
			<form class="form-horizontal" method="post" role="form" id="facturacion" name="facturacion" action="facturacion.php">
				
						<div class="form-group">
						<label for="q1" class="col-md-2 control-label">Mes:</label>
                            <select class="form-control" id="q1" name="q1" required style="width: auto" >
                               <option value=""></option>
                               <option value="1">Enero</option>
                               <option value="2">Febrero</option>
                               <option value="3">Marzo</option>
                               <option value="4">Abril</option>
                               <option value="5">Mayo</option>
                               <option value="6">Junio</option>
                               <option value="7">Julio</option>
                               <option value="8">Agosto</option>
                               <option value="9">Septiembre</option>
                               <option value="10">Octubre</option>
                               <option value="11">Noviembre</option>
                               <option value="12">Diciembre</option>
                            </select><br />
							<label for="q2" class="col-md-2 control-label">A&ntilde;o:</label>
								<input type="number" class="form-control" id="q2" name="q2" style="width: auto" required />
								&nbsp;&nbsp;<button type="submit" class="btn btn-primary" id="facturacion">
									<span class="glyphicon glyphicon-search" ></span> Consultar</button>
						</div> 
			</form>
		
  </div>
</div>
	 
	 		 
	</div>

<?php 
				//include("modal/edit_clientes.php");
				//include("modal/editar_clientes.php"); 
			?>

 
	
	<hr>
	<?php
	include("config/footer.php");
	?>

<script type="text/javascript" src="js/afacturar.js"></script><!-- MUESTRA RESULTADOS -->


</body>
</html>
<?php
mysql_free_result($usu);
// mysql_free_result($cliente);

?>
