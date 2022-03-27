<?php
require_once('Connections/tracking.php'); 
require_once('config/login.php');
//require_once('Connections/gps.php');
    $active_vehiculos="active";
	$title="VEHICULOS";

// escaping, additionally removing everything that could be (html/javascript-) code
	//	include 'ajax/pagination.php'; include pagination file
		//pagination variables

	unset($_SESSION["grupo"]);

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

<!-- <script src="https://ajax.googleapis.com/ajax/libs/jquery/3.2.1/jquery.min.js"></script>
  <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"></script> -->

  

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
	        	<?php if( $row_usu["vehiculos"] == "e") { ?>
	        	<a href="#popnw" class="btn btn-default" title='Nuevo vehiculo' ><i class="glyphicon glyphicon-plus"> Nuevo </i></a>
			  <?php } ?>	        	        
				<!-- <button type='button' class="btn btn-info" data-toggle="modal" data-target="#popnw"><span class="glyphicon glyphicon-plus" ></span> Nuevo Cliente</button> -->
			</div>
			<h4><i></i> Vehiculos 
			<a href="informes/todo_moviles.php" class="btn btn-default" title='Excel' >  <i class="glyphicon glyphicon-export"></i> </a></h4>
		</div>
		<div class="panel-body">
		<form class="form-horizontal" role="form" id="dato">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Placa</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Buscar por placa" onkeyup='load(1);'>
							</div>
							<div class="col-md-3">
								<button type="button" class="btn btn-default" onclick='load(1);'>
									<span class="glyphicon glyphicon-search" ></span> Buscar</button>
								<span id="loader"></span>
							</div>
							
						</div>
				
				
				
			</form>
				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->
			


  </div>
</div>
	<hr>
	<?php
	include("config/footer.php");
	?>

<script type="text/javascript" src="js/vehiculos.js"></script><!-- MUESTRA RESULTADOS -->

	 

 <div class="modal-wrapper" id="popnw">
		<div class="popnw-contenedor">
		<a class="popnw-cerrar" href="#">X</a>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Ingrese la placa</h4>
			<form class="form-horizontal" method="post" id="new_placa" name="new_placa" action="clienteplaca.php">
			  <div class="form-group">
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="placa" name="placa" required >
				</div>
			  </div>
		  <div class="modal-footer">
		  <button type="submit" class="btn btn-primary" id="actualizar_datos">SIGUIENTE</button>
			<a href="vehiculos.php" class="btn btn-default" title='Cancelar' ><i> CANCELAR </i></a><br /><br />
		  </div>
		  </form>
			
			
		  </div>
		</div> 

	


</body>
</html>
<?php
mysql_free_result($usu);
// mysql_free_result($cliente);

?>
