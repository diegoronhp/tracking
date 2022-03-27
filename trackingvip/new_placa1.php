<?php

require_once('Connections/tracking.php'); 
require_once('config/login.php');
//require_once('Connections/gps.php');

    $active_vehiculos="active";
    $active_facturas="";
	$active_productos="";
	$active_gps="";
	$active_usuarios="";	
	$title="VEHICULOS";

$campo='';
$laplaca=$_SESSION['placa'];
$id_equipo=$_SESSION['id_equipo'];
$id_cliente=$_SESSION['id_clien'];
$id_sim=$_POST['id_sim'];

/*mysqli_select_db($database_track,$track);
$query_placas = "SELECT * FROM movequipos WHERE placa = '$laplaca' ORDER BY fecha_modificado";
$placas = mysqli_query($query_placas, $track) or die(mysqli_error());
$row_placas = mysqli_fetch_assoc($placas);*/



$query_equipo = "SELECT * FROM equipos WHERE id_equipo = '$id_equipo'";
$equipo = mysqli_query($track, $query_equipo) or die(mysqli_error());
$row_equipo = mysqli_fetch_assoc($equipo);

$id_marca=$row_equipo["id_marca"];
$id_modelo=$row_equipo["id_modelo"];
$query_marca = "SELECT * FROM marca_gps WHERE id_marca = '$id_marca'";
$marca = mysqli_query($track, $query_marca) or die(mysqli_error());
$row_marca = mysqli_fetch_assoc($marca);

$query_modelo = "SELECT * FROM modelo_gps WHERE id_modelo = '$id_modelo'";
$modelo = mysqli_query($track,$query_modelo) or die(mysqli_error());
$row_modelo = mysqli_fetch_assoc($modelo);

$query_cliente = "SELECT * FROM clientes WHERE id_cliente = '$id_cliente'";
$cliente = mysqli_query($track, $query_cliente) or die(mysqli_error());
$row_cliente = mysqli_fetch_assoc($cliente);


$query_sim = "SELECT * FROM sim WHERE id_sim = '$id_sim'";
$sim = mysqli_query($track, $query_sim) or die(mysqli_error());
$row_sim = mysqli_fetch_assoc($sim);

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
	<script src="config/ckeditor/ckeditor.js"></script>
	<script src="config/ckeditor/samples/js/sample.js"></script>
	<link rel="stylesheet" href="config/ckeditor/samples/css/samples.css">
	<link rel="stylesheet" href="config/ckeditor/samples/toolbarconfigurator/lib/codemirror/neo.css">


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
			<h4><i class='glyphicon glyphicon-list-alt'></i> <?php echo $laplaca ?> </h4>
		</div>
		<div class="panel-body">
		<div class="popup-contenedor">
		  <div class="modal-body">
			<form class="form-horizontal" method="post" id="new_placa" name="new_placa" action="Connections/new_placa.php">				
			  <div class="form-group row">
             <label for="cliente" class="col-sm-2 control-label">Cliente</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="referencia1" name="referencia1" value="<?php echo $row_cliente["nombre"]; ?>" readonly >
			<input type="hidden" value="<?php echo $id_cliente; ?>" id="id_cliente" name="id_cliente">
				</div>
				</div>
			  <div class="form-group row">
             <label for="marca" class="col-sm-2 control-label">Marca GPS</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $row_marca["marca"]; ?>" readonly >
				</div>			
				<label for="modelo" class="col-sm-2 control-label">Modelo GPS</label>
		  <div class="col-md-4">
				  <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $row_modelo["modelo"]; ?>" readonly >
				</div>
				</div>				
			  <div class="form-group row">
             <label for="marca" class="col-sm-2 control-label">Imei GPS</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="marca" name="marca" value="<?php echo $row_equipo["imei"]; ?>" readonly >
			<input type="hidden" value="<?php echo $id_equipo; ?>" id="id_equipo" name="id_equipo">
				</div>			
				<label for="modelo" class="col-sm-2 control-label">Imei Linea</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="linea" name="linea" value="<?php echo $row_sim["imei_sim"]; ?>" readonly >
			<input type="hidden" value="<?php echo $id_sim; ?>" id="id_sim" name="id_sim">
				</div>
				</div>
				
			  <div class="form-group row">
             <label for="marca" class="col-sm-2 control-label">Linea</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="lalinea" name="lalinea" value="<?php echo $row_sim["linea"]; ?>" readonly >
				</div>			
				<label for="modelo" class="col-sm-2 control-label">Operador</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="linea" name="linea" value="<?php echo $row_sim["empresa_sim"]; ?>" readonly >
				</div>
				</div>
				<div class="form-group row">
			<input type="hidden" value="<?php echo $laplaca; ?>" id="placa" name="placa">
				<label for="estado" class="col-sm-2 control-label">Estado</label>
		  <div class="col-md-4">
				 <select class="form-control" id="estado" name="estado" required>
					<option value="a" selected>Activo</option>
					<option value="i">Inactivo</option>
				  </select>
				</div>
				<label for="subgrupo" class="col-sm-2 control-label">Grupo</label>
		  <div class="col-md-4">
				  <input type="text" class="form-control" id="subgrupo" name="subgrupo" >
				</div>
				</div>				
			  <div class="form-group row">
				<label for="tipo_contrato" class="col-sm-2 control-label">Tipo Contrato</label>	
				<div class="col-sm-4">
				 <select class="form-control" id="tipo_contrato" name="tipo_contrato" required>
					<option value="COMPRA" selected>Compra</option>
					<option value="ARRIENDO">Arriendo</option>
				  </select>
				</div>
				<label for="valor_mensual" class="col-sm-2 control-label">Valor Mensual</label>
				<div class="col-sm-4">
				  <input type="number" class="form-control" id="valor_mensual" name="valor_mensual" min="5000" max="50000" required>
				</div>
				</div>				
			  <div class="form-group row">
				<label for="avl" class="col-sm-2 control-label">AVL</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="avl" name="avl" required>
				</div>
				<label for="plataforma" class="col-sm-2 control-label">Plataforma</label>		
				<div class="col-sm-4">
				 <select class="form-control" id="plataforma" name="plataforma" required>
					<option value="1" selected>1</option>
					<option value="2">2</option>
				  </select>
				</div>
				</div>				
			  <div class="form-group row">
             <label for="ex1" class="col-sm-2 control-label">Activacion</label> 
				<div class="col-md-4">
             <input type="date" name="fecha" id="fecha" required>
             </div>
             <label for="ex1" class="col-sm-2 control-label">Compra</label> 
				<div class="col-md-4">
             <input type="date" name="fecha_compra" id="fecha_compra" required>
             </div>
				</div>				
			  <div class="form-group row">
             <label for="propietario" class="col-sm-2 control-label">Propietario</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="propietario" name="propietario" required>
				</div>
            <label for="tel_propietario" class="col-sm-2 control-label">Tel Propietario</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="tel_propietario" name="tel_propietario" >
				</div>
				</div>				
			  <div class="form-group row">
             <label for="ciudad" class="col-sm-2 control-label">Ciudad</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="ciudad" name="ciudad" required>
				</div>
            <label for="vehiculo" class="col-sm-2 control-label">Vehiculo</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="tipo_vehiculo" name="tipo_vehiculo" >
				</div>
				</div>				
			  <div class="form-group row">
             <label for="referencia1" class="col-sm-2 control-label">Referencia 1</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="referencia1" name="referencia1" >
				</div>
				</div>
            <div class="form-group row">
             <label for="referencia1" class="col-sm-2 control-label">Referencia 2</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="referencia2" name="referencia2" >
				</div>
				</div>
            <div class="form-group row">
             <label for="referencia1" class="col-sm-2 control-label">Referencia 3</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="referencia3" name="referencia3" >
				</div>
				</div>
            <div class="form-group row">
             <label for="observaciones" class="col-sm-2 control-label">Observaciones</label>
				<div class="col-sm-9">
				  <input type="text" class="form-control" id="observaciones" name="observaciones" >
				</div>
				</div>
		  <div class="modal-footer">
		  <button type="submit" class="btn btn-primary" id="actualizar_datos">ENVIAR</button>
			<a href="vehiculos.php" class="btn btn-default" title='Cancelar' ><i> CANCELAR </i></a><br /><br />
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

</body>
</html>
<?php
mysqli_free_result($equipo);
mysqli_free_result($cliente);
mysqli_free_result($sim);
mysqli_free_result($marca);
mysqli_free_result($modelo);
?>