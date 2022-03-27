<?php
require_once('Connections/tracking.php'); 
require_once('config/login.php');
//require_once('Connections/gps.php');

    $active_facturas="";
	$active_productos="";
	$active_linea="";
	$active_usuarios="";
	$title="LINEAS PREPAGO";
	$active_lp="active";
if(isset($_GET['id'])) {
	$elid = $_GET['id'];
	
$query_consultlinea = "SELECT * FROM sim WHERE id_sim = $elid";
$conspre = mysqli_query($track, $query_consultlinea) or die(mysqli_error());
$row_conspre = mysqli_fetch_assoc($conspre);
	$lalinea = $row_conspre['linea'];
}


/*
mysqli_select_db($database_track,$track);
$query_marcas = "SELECT * FROM marca_gps ORDER BY marca";
$marcas = mysqli_query($query_marcas, $track) or die(mysqli_error());
$row_marcas = mysqli_fetch_assoc($marcas);

$query_modelo = "SELECT * FROM modelo_gps ORDER BY modelo";
$modelo = mysqli_query($query_modelo, $track) or die(mysqli_error());
$row_modelo = mysqli_fetch_assoc($modelo);
*/

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $title;?></title>

<script language="JavaScript" src="js/jquery-1.5.1.min.js"></script>
<script language="JavaScript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="stylesheet" />
<link rel="stylesheet" href="css/custom.css">
<link rel="stylesheet" href="css/login.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<style type="text/css">
	a {
		color: inherit;
	}
	#popew {
		opacity: 0;
		margin-top: -100px;
		overflow-y: scroll;
		position:fixed;
		z-index: 1050;
	}
	#popew:target {
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
	.popew-contenedor {
		position: relative;
		margin:7% auto;
		padding:30px 50px;
		background-color: #fafafa;
		color:#333;
		border-radius: 3px;
		width:50%;
	}
	a.popew-cerrar {
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
    
	a.popew-link {
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
	        	<!-- <?php if( $row_usu["lineas"] == "e") { ?>
	        	<a href="#popnw" class="btn btn-default" title='Nueva LINEA' ><i class="glyphicon glyphicon-earphone"> Nueva SIM </i></a>	
			  <?php } ?>	                
				
				
				<button type='button' class="btn btn-info" data-toggle="modal" data-target="#popnw"><span class="glyphicon glyphicon-plus" ></span> Nuevo Cliente</button> -->
			</div>
			<h4>Control Lineas Prepago <a href="informes/todo_prepago.php" class="btn btn-default" title='Excel' >  <i class="glyphicon glyphicon-export"></i> </a></h4>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" role="form" id="dato">
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label"></label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="BUSCAR LINEA PREPAGO" onkeyup='load(1);'>
							</div>
							<div class="col-md-3">
								<button type="button" class="btn btn-default" onclick='load(1);'>
									<span class="glyphicon glyphicon-search" ></span> Buscar</button>
								<span id="loader"></span>
							</div>
							
						</div>
						<?php if(isset($_GET['ing'])) { ?>
				<div class="alert alert-danger">
  <strong>Atencion!</strong> No fue posible realizar el registro, esta linea ya tiene recarga en la fecha asignada.
</div>
		<?php } ?>		
				
			</form>
				<div id="resultados"></div><!-- Carga los datos ajax -->
				<div class='outer_div'></div><!-- Carga los datos ajax -->
		
  </div>
</div>
	 
	 		 
	</div>
	<div class="modal-wrapper" id="popew">
		<div class="popew-contenedor">
		<a class="popew-cerrar" href="lineapre.php">X</a>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-new-window'></i> Registrar recarga linea <?php echo $lalinea; ?></h4>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="edit_sim" name="edit_sim" action="Connections/new_linea.php">
				<input type="hidden" id="registro" name="registro" value="5" />
				<input type="hidden" id="id_linea" name="id_linea" value="<?php echo $elid; ?>" />
				<input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $row_usu["id_usuario"]; ?>" />
			<div id="resultados_ajax2"></div>
			<div class="form-group">
				<label for="mod_nit" class="col-sm-3 control-label">VALOR </label>
				<div class="col-sm-5">
				  <input type="number" class="form-control" id="valor" name="valor" value="" required>
				</div> 
			  </div>
		  <div class="form-group">
		  <label for="marca" class="col-sm-3 control-label">Fecha</label>
				<div class="col-sm-5">
				  <input type="date" class="form-control" id="fecha" name="fecha" value="" required>
				</div> 
			  </div>
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Enviar</button>
			<a href="lineapre.php" class="btn btn-default" title='Cancelar' ><i> CANCELAR </i></a>
		  </div>
		  </form>
		</div>
	</div>


	
	<hr>
	<?php
	include("config/footer.php");
	?>

<script type="text/javascript" src="js/lineapre.js"></script><!-- MUESTRA RESULTADOS -->


</body>
</html>
<?php
mysqli_free_result($usu);
/* mysqli_free_result($sim); */

?>
