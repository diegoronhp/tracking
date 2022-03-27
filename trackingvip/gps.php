<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('Connections/tracking.php'); 
require_once('config/login.php');
//require_once('Connections/gps.php');

    $active_facturas="";
	$active_productos="";
	$active_gps="active";
	$active_usuarios="";	
	$title="GPS";

if (isset($_GET['id'])) {
$elid = $_GET['id'];

//mysql_select_db($database_track,$track);
$query_equipo = "SELECT equipos.id_equipo, equipos.id_marca, equipos.id_modelo, equipos.imei, equipos.fecha, equipos.ubicacion, equipos.origen, marca_gps.id_marca, modelo_gps.id_modelo, marca_gps.marca, modelo_gps.modelo FROM equipos JOIN marca_gps ON equipos.id_marca = marca_gps.id_marca JOIN modelo_gps ON equipos.id_modelo = modelo_gps.id_modelo WHERE id_equipo = $elid";
$equipo = mysqli_query($track, $query_equipo) or die(mysqli_error($track));
$row_equipo = mysqli_fetch_assoc($equipo);

}

//mysql_select_db($database_track,$track);
$query_marcas1 = "SELECT * FROM marca_gps ORDER BY marca";
$marcas1 = mysqli_query($track, $query_marcas1) or die(mysqli_error($track));
$row_marcas1 = mysqli_fetch_assoc($marcas1);


//mysql_select_db($database_track,$track);
$query_marcas2 = "SELECT * FROM marca_gps ORDER BY marca";
$marcas2 = mysqli_query($track, $query_marcas2) or die(mysqli_error($track));
$row_marcas2 = mysqli_fetch_assoc($marcas2);

$query_modelo1 = "SELECT * FROM modelo_gps ORDER BY modelo";
$modelo1 = mysqli_query($track, $query_modelo1) or die(mysqli_error($track));
$row_modelo1 = mysqli_fetch_assoc($modelo1);


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
	
	#popnw1 {
		opacity: 0;
		margin-top: -100px;
		overflow-y: scroll;
		position:fixed;
		z-index: 1050;
	}
	#popnw1:target {
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
	.popnw1-contenedor {
		position: relative;
		margin:7% auto;
		padding:30px 50px;
		background-color: #fafafa;
		color:#333;
		border-radius: 3px;
		width:50%;
	}
	a.popnw1-cerrar {
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
    
	a.popnw1-link {
	    text-align: center;
	    display: block;
	    margin: 30px 0;
	}
	
	#popnw2 {
		opacity: 0;
		margin-top: -100px;
		overflow-y: scroll;
		position:fixed;
		z-index: 1050;
	}
	#popnw2:target {
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
	.popnw2-contenedor {
		position: relative;
		margin:7% auto;
		padding:30px 50px;
		background-color: #fafafa;
		color:#333;
		border-radius: 3px;
		width:50%;
	}
	a.popnw2-cerrar {
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
    
	a.popnw2-link {
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
        	<a href="inv.php" class="btn btn-default" title='Consultar Inventario' style="margin-right: 15px" ><i class="glyphicon glyphicon-list-alt"> Inventario GPS </i></a>
	        	<?php if( $row_usu["equipos"] == "e") { ?>
	        	<a href="#popnw" class="btn btn-default" title='Nuevo GPS' ><i class="glyphicon glyphicon-cd"> Nuevo GPS </i></a>
	        	<a href="#popnw1" class="btn btn-default" title='Nueva Marca' ><i class="glyphicon glyphicon-cd"> Nueva Marca </i></a>
	        	<a href="#popnw2" class="btn btn-default" title='Nuevo Modelo' ><i class="glyphicon glyphicon-cd"> Nuevo Modelo </i></a>       
				<!-- <button type='button' class="btn btn-info" data-toggle="modal" data-target="#popnw"><span class="glyphicon glyphicon-plus" ></span> Nuevo Cliente</button> -->
			  <?php } ?>	        
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar GPS</h4>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" role="form" id="dato">
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">GPS</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="IMEI GPS" onkeyup='load(1);'>
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
	 
	 		 
	</div>

<?php 
				//include("modal/edit_clientes.php");
				//include("modal/editar_clientes.php"); 
			?>

 <!-- <a href="#popup" class="popup-link">Ver mas información</a> -->
    <div class="modal-wrapper" id="popup" >
		<div class="popup-contenedor"><?php if (isset($_GET['id'])) { ?>
		<!-- <a class="popnw-cerrar" href="#">X</a> -->
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-new-window'></i> Editars GPS</h4>
			<form class="form-horizontal" method="post" id="new_gps" name="new_gps" action="Connections/edit_gps.php">
		  <div class="modal-body"><?php if (isset($_GET['desde'])) { ?>
			<input type="hidden" id="deinv" name="deinv" value="<?php echo $row_equipo["ubicacion"]; ?>">
			<?php }?>
			<div id="resultados_ajax2"></div>
			<div class="form-group">
				<label for="mod_nit" class="col-sm-3 control-label">ID</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="id_equipo" name="id_equipo" value="<?php echo $row_equipo["id_equipo"]; ?>" readonly>
				</div> 
			  </div>
			<div class="form-group">
				<label for="mod_nit" class="col-sm-3 control-label">IMEI</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="imei" name="imei" value="<?php echo $row_equipo["imei"]; ?>" required>
				</div> 
			  </div>
		  <div class="form-group">
		  <label for="marca" class="col-sm-3 control-label">Marca GPS</label>				
				<div class="col-sm-6">
				 <select class="form-control" id="id_marca" name="id_marca" required>
				<?php   do {
					 ?>	
					 <?php if($row_marcas1["id_marca"] == $row_equipo["id_marca"]) { ?>
					 <option value="<?php echo $row_marcas1["id_marca"]; ?>" selected ><?php echo $row_marcas1["marca"]; ?></option><?php } else { ?>			
					<option value="<?php echo $row_marcas1["id_marca"]; ?>" ><?php echo $row_marcas1["marca"]; ?></option><?php } ?>
			  <?php } while ($row_marcas1 = mysqli_fetch_assoc($marcas1));
					  ?>
				  </select>
				</div>
			  </div>
		  <div class="form-group">
		  <label for="modelo" class="col-sm-3 control-label">Modelo GPS</label>				
				<div class="col-sm-6">
				 <select class="form-control" id="id_modelo" name="id_modelo" required>
				 <option value=""></option>
				<?php   do { ?>				
					 <?php if($row_modelo1["id_modelo"] == $row_equipo["id_modelo"]) { ?>
					<option value="<?php echo $row_modelo1["id_modelo"]; ?>" selected><?php echo $row_modelo1["modelo"]; ?></option><?php } else { ?>
					<option value="<?php echo $row_modelo1["id_modelo"]; ?>"><?php echo $row_modelo1["modelo"]; ?></option>
					<?php } ?>
			  <?php } while ($row_modelo1 = mysqli_fetch_assoc($modelo1));
					  ?>
				  </select>
				</div>
			  </div>
		  <div class="form-group">
		  <label for="ubicacion" class="col-sm-3 control-label">Ubicacion GPS</label>			<?php
					if ($row_equipo["ubicacion"]=="VEHICULO") {
	$veh="selected";
}
					if ($row_equipo["ubicacion"]=="BODEGA") {
	$bod="selected";
}
					if ($row_equipo["ubicacion"]=="OFICINA") {
	$ofi="selected";
}
			  if ($row_equipo["ubicacion"]=="INACTIVO") {
	$inac="selected";
}?>	
				<div class="col-sm-6">
				 <select class="form-control" id="ubicacion" name="ubicacion" required>
				 <option value=""></option>
				 <option value="BODEGA" <?php echo $bod; ?>>BODEGA</option>
				 <option value="OFICINA" <?php echo $ofi; ?>>OFIC PRINCIPAL</option>
				 <option value="VEHICULO" <?php echo $veh; ?>>VEHICULO</option>
				 <option value="INACTIVO" <?php echo $inac; ?>>INACTIVO</option>
				  </select>
				</div>
			  </div>
		  <div class="form-group">
		  <label for="origen" class="col-sm-3 control-label">Origen GPS</label>					
				<div class="col-sm-6">
				<?php
					if ($row_equipo["origen"]=="COMPRA") {
	$com="selected";
}
					if ($row_equipo["origen"]=="HOMOLOGACION") {
	$hom="selected";
}?>
				 <select class="form-control" id="origen" name="origen" required>
				 <option value=""></option>
				 <option value="COMPRA" <?php echo $com; ?>>COMPRA</option>
				 <option value="HOMOLOGACION" <?php echo $hom; ?>>HOMOLOGACION</option>
				  </select>
				</div>
			  </div>
		  <div class="form-group"> 
		  <label for="fecha" class="col-sm-3 control-label">Fecha</label> 
          <div class="col-md-3">
           <input type="date" name="fecha" id="fecha" value="<?php echo $row_equipo["fecha"]; ?>" required>
          </div>
			  </div> 
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Ingresar datos</button>
			<a href="gps.php" class="btn btn-default" title='Cancelar' ><i> CANCELAR </i></a>
		  </div>
		  </form><?php } ?>
		</div>
	</div>
		  
	

	<div class="modal-wrapper" id="popnw">
		<div class="popnw-contenedor">
		<!-- <a class="popnw-cerrar" href="#">X</a> -->
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-new-window'></i> Nuevo GPS</h4>
			<form class="form-horizontal" method="post" id="new_gps" name="new_gps" action="Connections/new_gps.php">
		  <div class="modal-body">
			<div id="resultados_ajax2"></div>
			<div class="form-group">
				<label for="mod_nit" class="col-sm-3 control-label">IMEI</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="imei" name="imei" required>
				</div> 
			  </div>
		  <div class="form-group">
		  <label for="marca" class="col-sm-3 control-label">Marca GPS</label>				
				<div class="col-sm-6">
				 <select class="form-control" id="id_marca" name="id_marca" required>
				 <option value=""></option>
				<?php   do { ?>
					<option value="<?php echo $row_marcas1["id_marca"]; ?>"><?php echo $row_marcas1["marca"]; ?></option>
			  <?php } while ($row_marcas1 = mysqli_fetch_assoc($marcas1));
					  ?>
				  </select>
				</div>
			  </div>
		  <div class="form-group">
		  <label for="modelo" class="col-sm-3 control-label">Modelo GPS</label>				
				<div class="col-sm-6">
				 <select class="form-control" id="id_modelo" name="id_modelo" required>
				 <option value=""></option>
				<?php   do { ?>
					<option value="<?php echo $row_modelo1["id_modelo"]; ?>"><?php echo $row_modelo1["modelo"]; ?></option>
			  <?php } while ($row_modelo1 = mysqli_fetch_assoc($modelo1));
					  ?>
				  </select>
				</div>
			  </div>
		  <div class="form-group">
		  <label for="ubicacion" class="col-sm-3 control-label">Ubicacion GPS</label>				
				<div class="col-sm-6">
				 <select class="form-control" id="ubicacion" name="ubicacion" required>
				 <option value=""></option>
				 <option value="BODEGA">BODEGA</option>
				 <option value="OFICINA">OFIC PRINCIPAL</option>
				 <option value="VEHICULO">VEHICULO</option>
				  </select>
				</div>
			  </div>
		  <div class="form-group">
		  <label for="origen" class="col-sm-3 control-label">Origen GPS</label>					
				<div class="col-sm-6">
				 <select class="form-control" id="origen" name="origen" required>
				 <option value=""></option>
				 <option value="COMPRA">COMPRA</option>
				 <option value="HOMOLOGACION">HOMOLOGACION</option>
				  </select>
				</div>
			  </div>
		  <div class="form-group"> 
		  <label for="fecha" class="col-sm-3 control-label">Fecha</label> 
          <div class="col-md-3">
           <input type="date" name="fecha" id="fecha" required>
          </div>
			  </div> 
		  </div>
		  <div class="modal-footer">
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Ingresar datos</button>
			<a href="gps.php" class="btn btn-default" title='Cancelar' ><i> CANCELAR </i></a>
		  </div>
		  </form>
		</div>
	</div>
	
	
 <div class="modal-wrapper" id="popnw1">
		<div class="popnw1-contenedor">
		<a class="popnw1-cerrar" href="#">X</a>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Nueva marca</h4>
			<form class="form-horizontal" method="post" id="new_marca" name="new_marca" action="Connections/new_modelo.php">
			  <div class="form-group">
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="marca" name="marca" required >
				</div>
			  </div>
		  <div class="modal-footer">
		  <button type="submit" class="btn btn-primary" id="actualizar_datos">CREAR</button>
			<a href="gps.php" class="btn btn-default" title='Cancelar' ><i> CANCELAR </i></a><br /><br />
		  </div>
		  </form>
			
			
		  </div>
		</div> 
		

 <div class="modal-wrapper" id="popnw2">
		<div class="popnw2-contenedor">
		<a class="popnw2-cerrar" href="gps.php">X</a>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Nuevo Modelo</h4>
			<form class="form-horizontal" method="post" id="new_placa" name="new_placa" action="Connections/new_modelo.php">
		  <div class="form-group">
		  <label for="marca" class="col-sm-3 control-label">Marca GPS</label>				
				<div class="col-sm-6">
				 <select class="form-control" id="id_marca" name="id_marca" required>
				 <option value=""></option>
				<?php   do { ?>
					<option value="<?php echo $row_marcas2["id_marca"]; ?>"><?php echo $row_marcas2["marca"]; ?></option>
			  <?php } while ($row_marcas2 = mysqli_fetch_assoc($marcas2));
					  ?>
				  </select>
				</div>
			  </div>
			  <div class="form-group">
		  <label for="marca" class="col-sm-3 control-label">Modelo</label>	
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="modelo" name="modelo" required >
				</div>
			  </div>
		  <div class="modal-footer">
		  <button type="submit" class="btn btn-primary" id="actualizar_datos">CREAR</button>
			<a href="gps.php" class="btn btn-default" title='Cancelar' ><i> CANCELAR </i></a><br /><br />
		  </div>
		  </form>
		  </div>
		</div> 

	
	<hr>
	<?php
	include("config/footer.php");
	?>

<script type="text/javascript" src="js/gps.js"></script><!-- MUESTRA RESULTADOS -->


</body>
</html>
<?php
mysqli_free_result($usu);
mysqli_free_result($marcas1);
mysqli_free_result($marcas2);
mysqli_free_result($modelo1);
// mysql_free_result($cliente);

?>
