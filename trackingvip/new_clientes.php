<?php
require_once('config/login.php');
require_once('Connections/cliente.php');

    $active_facturas="";
	$active_productos="";
	$active_clientes="active";
	$active_usuarios="";	
	$title="Clientes";

?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//ES" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1" />
<title><?php echo $title;?></title>

<script language="JavaScript" src="src/js/jquery-1.5.1.min.js"></script>
<script language="JavaScript" src="js/jquery-ui-1.8.13.custom.min.js"></script><link type="text/css" href="css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="stylesheet" />
<link rel="stylesheet" href="css/custom.css">
<link rel="stylesheet" href="css/login.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<style type="text/css">
	
	

	#popup {
		visibility: hidden;
		opacity: 0;
		margin-top: -200px;
		overflow-y: scroll;
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
		z-index: 999;
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
		font-size: 20px;
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

</style>


</head>

<body>

	
 <!-- <a href="#popup" class="popup-link">Ver mas información</a> -->
<div class="modal-wrapper" id="popup2">
		<div class="popup-contenedor">
		<a class="popup-cerrar" href="#">X</a>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Nuevo cliente</h4>
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="edit_clientes" name="edit_clientes" action="Connections/new_clientes.php">
			<div id="resultados_ajax2"></div>
			<div class="form-group">
				<label for="mod_nit" class="col-sm-3 control-label">Nit</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="" name="mod_nit"  required>
					<input type="hidden" name="mod_id" id="mod_id">
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
				  <input type="text" class="form-control" id="" name="mod_telefono">
				</div>
			  </div>
			  
			  <div class="form-group">
				<label for="mod_email" class="col-sm-3 control-label">Email</label>
				<div class="col-sm-8">
				 <input type="email" class="form-control" id="" name="mod_email">
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_direccion" class="col-sm-3 control-label">Dirección</label>
				<div class="col-sm-8">
				  <textarea class="form-control" id="" name="mod_direccion" ></textarea>
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_ciudad" class="col-sm-3 control-label">Ciudad</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="" name="mod_ciudad" >
				</div>
			  </div>
			  <div class="form-group">
				<label for="mod_dia_corte" class="col-sm-3 control-label" >Dia Corte</label>
				<div class="col-sm-2">
				  <input type="text" class="form-control" id="" name="mod_dia_corte">
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
			 
			 
			 
			
		  </div>
		  <div class="modal-footer">
			<button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
			<button type="submit" class="btn btn-primary" id="actualizar_datos">Ingresar datos</button>
		  </div>
		  </form>
			
			
		</div>
	</div>
	

	
	<hr>
	
</body>
</html>
<?php
mysql_free_result($usu);
mysql_free_result($cliente);

?>
