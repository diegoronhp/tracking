<?php
//error_reporting(E_ALL);
//ini_set('display_errors', '1');
require_once('Connections/tracking.php');
require_once('config/login.php');
header('Content-Type: text/html; charset=ISO-8859-1');
//require_once('Connections/cliente.php');

    $active_facturas="";
	$active_productos="";
	$active_clientes="active";
	$active_usuarios="";	
	$title="Clientes";

if (isset($_GET['id'])) {
$elid = $_GET['id'];

// mysql_select_db($database_track, $track);
$query_cliente = "SELECT * FROM clientes WHERE id_cliente = $elid";
$cliente = mysqli_query($track, $query_cliente) or die(mysqli_error());
$row_cliente = mysqli_fetch_assoc($cliente);
$totalRows_cliente = mysqli_num_rows($cliente);
}

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
	        	<?php if( $row_usu["cliente"] == "e") { ?>
	        	<a href="#popnw" class="btn btn-default" title='Nuevo cliente' onclick="obtener_datos('<?php echo $id_cliente;?>');" ><i class="glyphicon glyphicon-user"> Nuevo Cliente </i></a>	        
				<!-- <button type='button' class="btn btn-info" data-toggle="modal" data-target="#popnw"><span class="glyphicon glyphicon-plus" ></span> Nuevo Cliente</button> -->
			  <?php } ?>	        
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar Clientes</h4>
		</div>
		<div class="panel-body">
		
			
			
			<form class="form-horizontal" role="form" id="dato">
				
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">Cliente</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="Nombre del cliente" onkeyup='load(1);'>
							</div>
							<div class="col-md-3">
								<button type="button" class="btn btn-default" onclick='load(1);'>
									<span class="glyphicon glyphicon-search" ></span> Buscar</button>
								<span id="loader"></span>
							</div>
							
						</div>
				
				
				
			</form>
				<div id="resultados"></div><!--  Carga los datos ajax -->
				<div class='outer_div'></div><!--  Carga los datos ajax -->
		
  </div>
</div>
	 
	 		 
	</div>

<?php 
				//include("modal/edit_clientes.php");
				//include("modal/editar_clientes.php"); 
			?>

 <!-- <a href="#popup" class="popup-link">Ver mas información</a> -->
     <div class="modal-wrapper" id="popup" tabindex="-1" role="dialog" aria-labelledby="myModalLabel">
		<div class="popup-contenedor">
		<a class="popup-cerrar" href="#">X</a>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Editar cliente</h4>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="edit_clientes" name="edit_clientes" action="Connections/edit_clientes.php">
			<div id="resultados_ajax2"></div>
			<div class="form-group">
				<label for="mod_nit" class="col-sm-3 control-label">Nit</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_nit" name="mod_nit" value="<?php echo $row_cliente['nit'];?>"  required>
					<input type="hidden" name="mod_id" id="mod_id" value="<?php echo $row_cliente['id_cliente'];?>">
				</div> 
			  </div>
		  <div class="form-group">
				<label for="mod_dv" class="col-sm-3 control-label" >DV</label>
				<div class="col-sm-2">
				  <input type="text" class="form-control" id="mod_dv" name="mod_dv" value="<?php echo $row_cliente['dv'];?>">
				</div> 
			  </div>
			  <div	class="form-group">
			  <label for="mod_nombre" class="col-sm-3 control-label">Nombre</label>
			  <div class="col-sm-8">
			  	<input type="text" class="form-control" id="mod_nombre" name="mod_nombre" value="<?php echo $row_cliente['nombre'];?>" required>
			  </div>
				</div>
			   <div class="form-group">
				<label for="mod_telefono" class="col-sm-3 control-label">Teléfono</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_telefono" value="<?php echo $row_cliente['telefono'];?>" name="mod_telefono">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="mod_email" class="col-sm-3 control-label">Email</label>
				<div class="col-sm-8">
				 <input type="email" class="form-control" id="mod_email" name="mod_email"  value="<?php echo $row_cliente['correo'];?>" >
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_direccion" class="col-sm-3 control-label">Dirección</label>
				<div class="col-sm-8">
				  <textarea class="form-control" id="mod_direccion" name="mod_direccion"><?php echo $row_cliente['direccion'];?></textarea>
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_ciudad" class="col-sm-3 control-label">Ciudad</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="mod_ciudad" name="mod_ciudad" value="<?php echo $row_cliente['ciudad'];?>">
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_observaciones" class="col-sm-3 control-label" >Observaciones</label>
				<div class="col-sm-8">
				  <textarea class="form-control" rows="3" id="mod_observaciones" name="mod_observaciones"><?php echo $row_cliente['observaciones'];?></textarea>
				</div> 
			  </div><div class="form-group">
				<label for="mod_dia_corte" class="col-sm-3 control-label" >Dia Corte</label>
				<div class="col-sm-2">
				  <input type="text" class="form-control" id="mod_dia_corte" name="mod_dia_corte" value="<?php echo $row_cliente['dia_corte'];?>">
				</div> 
			  </div>
			  <div class="form-group">
				<label for="mod_cobro" class="col-sm-3 control-label">Cobro</label>
				<div class="col-sm-8">
					<?php
					if ($row_cliente['cobro']=="Anticipado") {
	$anti="selected";
}
					if ($row_cliente['cobro']=="Vencido") {
	$ven="selected";
}?>
				 <select class="form-control" id="mod_cobro" name="mod_cobro" required>
					<option value=""></option>
					<option value="Anticipado" <?php echo $anti;?>>Anticipado</option>
					<option value="Vencido" <?php echo $ven;?>>Vencido</option>
				  </select>
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-8">				
					<?php if ($row_cliente['estado']=="a") {
	$acti="selected";
}
					if ($row_cliente['estado']=="i") {
	$inac="selected";
}?>
				 <select class="form-control" id="mod_estado" name="mod_estado" required>
					<option value="">Selecciona estado</option>
					<option value="a" <?php echo $acti;?>>Activo</option>
					<option value="i" <?php echo $inac;?>>Inactivo</option>
				  </select>
				</div>
			  </div>
		  <div class="modal-footer">
			<a href="clientes.php" class="btn btn-default" title='Cancelar' ><i> CANCELAR </i></a>
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
		  </div>
		  </form>
			
		  </div>
			
			
		  </div>
		</div>
		  
	
	
	<div class="modal-wrapper" id="popnw">
		<div class="popnw-contenedor">
		<a class="popnw-cerrar" href="#">X</a>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Nuevo cliente</h4>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="edit_clientes" name="edit_clientes" action="Connections/new_clientes.php">
			<div id="resultados_ajax2"></div>
			<div class="form-group">
				<label for="mod_nit" class="col-sm-3 control-label">Nit</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="" name="mod_nit"  required>
					<input type="hidden" name="mod_id" id="mod_id" value="2">
				</div> 
			  </div>
		  <div class="form-group">
				<label for="mod_dv" class="col-sm-3 control-label" >DV</label>
				<div class="col-sm-2">
				  <input type="text" class="form-control" id="" name="mod_dv">
				</div> 
			  </div>
			  <div	class="form-group">
			  <label for="mod_nombre" class="col-sm-3 control-label">Nombre</label>
			  <div class="col-sm-8">
			  	<input type="text" class="form-control" id="" name="mod_nombre" required>
			  </div>
				</div>
			   <div class="form-group">
				<label for="mod_telefono" class="col-sm-3 control-label">Teléfono</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="" name="mod_telefono" required>
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="mod_email" class="col-sm-3 control-label">Email</label>
				<div class="col-sm-8">
				 <input type="email" class="form-control" id="" name="mod_email" required>
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_direccion" class="col-sm-3 control-label">Dirección</label>
				<div class="col-sm-8">
				  <textarea class="form-control" id="" name="mod_direccion" required ></textarea>
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_ciudad" class="col-sm-3 control-label">Ciudad</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="" name="mod_ciudad" required >
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_observaciones" class="col-sm-3 control-label">Observaciones</label>
				<div class="col-sm-8">
				  <textarea class="form-control" rows="3" id="" name="mod_observaciones"></textarea>
				</div> 
				</div> 
			  <div class="form-group">
				<label for="mod_dia_corte" class="col-sm-3 control-label" >Dia Corte</label>
				<div class="col-sm-2">
				  <input type="text" class="form-control" id="" name="mod_dia_corte" required>
				</div> 
			  </div>
			  
			  <div class="form-group">
				<label for="mod_cobro" class="col-sm-3 control-label">Cobro</label>
				<div class="col-sm-8">
				 <select class="form-control" id="mod_cobro" name="mod_cobro" required>
					<option value=""></option>
					<option value="Anticipado" selected>Anticipado</option>
					<option value="Vencido">Vencido</option>
				  </select>
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-8">
				 <select class="form-control" id="" name="mod_estado" required>
					<option value="">-- Selecciona estado --</option>
					<option value="a" selected>Activo</option>
					<option value="i">Inactivo</option>
				  </select>
				</div>
			  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Ingresar datos</button>
		  </div>
		  </form>
			
		  </div>
			
			
		  </div>
		</div>

	
	<hr>
	<?php
	include("config/footer.php");
	?>

<script type="text/javascript" src="js/clientes.js"></script><!--  MUESTRA RESULTADOS -->

</body>
</html>
<?php
mysqli_free_result($usu);
// mysql_free_result($cliente);

?>
