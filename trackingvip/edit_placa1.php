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
$_GET['placa'];
$laplaca=$_GET['placa'];
$_GET['campo'];
$campo=$_GET['campo'];
$_GET['tabla'];
$tabla=$_GET['tabla'];


$query_placas = "SELECT * FROM movequipos WHERE placa = '$laplaca' ORDER BY fecha_modificado";
$placas = mysqli_query($track, $query_placas) or die(mysqli_error());
$row_placas = mysqli_fetch_assoc($placas);

$seleca = '';
$seleci = '';
$elestado = $row_placas["estado"];
if($elestado=="a") {
	$estado = "Activo";
	$seleca = ' selected';
} else {
	$estado="Inactivo";
	$seleci = ' selected';
}
$id_equipo=$row_placas["id_equipo"];
$id_cliente=$row_placas["id_cliente"];
$id_grupos=$row_placas["id_grupos"];
$id_sim=$row_placas["id_sim"];

$query_equipo = "SELECT * FROM equipos WHERE id_equipo = '$id_equipo'";
$equipo = mysqli_query($track, $query_equipo) or die(mysqli_error());
$row_equipo = mysqli_fetch_assoc($equipo);

$id_marca=$row_equipo["id_marca"];
$id_modelo=$row_equipo["id_modelo"];
$query_marca = "SELECT * FROM marca_gps WHERE id_marca = '$id_marca'";
$marca = mysqli_query($track, $query_marca) or die(mysqli_error());
$row_marca = mysqli_fetch_assoc($marca);

$query_modelo = "SELECT * FROM modelo_gps WHERE id_modelo = '$id_modelo'";
$modelo = mysqli_query($track, $query_modelo) or die(mysqli_error());
$row_modelo = mysqli_fetch_assoc($modelo);

$query_cliente = "SELECT * FROM clientes WHERE id_cliente = '$id_cliente'";
$cliente = mysqli_query($track, $query_cliente) or die(mysqli_error());
$row_cliente = mysqli_fetch_assoc($cliente);

$query_grupo = "SELECT * FROM grupos WHERE id_cliente = '$id_cliente'";
$grupo = mysqli_query($track, $query_grupo) or die(mysqli_error());
$row_grupo = mysqli_fetch_assoc($grupo);

$query_elgrupo = "SELECT * FROM grupos WHERE id_grupos = '$id_grupos'";
$elgrupo = mysqli_query($track, $query_elgrupo) or die(mysqli_error());
$row_elgrupo = mysqli_fetch_assoc($elgrupo);

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
			<form class="form-horizontal" method="post" id="edit_placa" name="new_factura" action="Connections/edit_placas.php">
			  <div class="form-group">
			<input type="hidden" value="<?php echo $laplaca; ?>" id="placa" name="placa">
			 <?php if($campo=="estado") { ?> 
				<label for="estado" class="col-sm-3 control-label">Estado</label>
				<div class="col-sm-3">
				 <select class="form-control" id="estado" name="estado" required>
					<option value="a"<?php echo $seleca; ?>>Activo</option>
					<option value="i"<?php echo $seleci; ?>>Inactivo</option>
				  </select>
			<input type="hidden" value="<?php echo $tabla; ?>" id="tabla" name="tabla">
			<input type="hidden" value="<?php echo $campo; ?>" id="campo" name="campo">
				</div>
			 <?php } ?> 
			 <?php if($campo=="id_grupos") { ?> 
				<label for="grupo" class="col-sm-3 control-label">Grupo</label>
				<div class="col-sm-3">
				 <select class="form-control" id="id_grupos" name="id_grupos" required>
					<option value="1"></option>
					<option value="1">Sin Grupo</option>
				<?php  if($row_grupo["id_grupos"]>1)
{
	do { ?> 
					<option value="<?php echo $row_grupo["id_grupos"]; ?>"><?php echo $row_grupo["nombre"]; ?></option>
			<?php } while ($row_grupo = mysqli_fetch_assoc($grupo)); 
} ?>
				  </select>
			<input type="hidden" value="<?php echo $tabla; ?>" id="tabla" name="tabla">
			<input type="hidden" value="<?php echo $campo; ?>" id="campo" name="campo">
				</div>
			 <?php } ?> 
			 <?php if($campo=="subgrupo") { ?> 
				<label for="subgrupo" class="col-sm-3 control-label">Grupo</label>
				<div class="col-sm-8">
				  <input type="text" class="form-control" id="subgrupo" name="subgrupo" >
			<input type="hidden" value="<?php echo $tabla; ?>" id="tabla" name="tabla">
			<input type="hidden" value="<?php echo $campo; ?>" id="campo" name="campo">
				</div>
			 <?php } ?> 
			 <?php if($campo=="tipo_contrato") { ?> 
				<label for="tipo_contrato" class="col-sm-3 control-label">Tipo Contrato</label>				
				<div class="col-sm-3">
				 <select class="form-control" id="tipo_contrato" name="tipo_contrato" required>
					<option value="COMPRA" selected>Compra</option>
					<option value="ARRIENDO">Arriendo</option>
				  </select>
			<input type="hidden" value="<?php echo $tabla; ?>" id="tabla" name="tabla">
			<input type="hidden" value="<?php echo $campo; ?>" id="campo" name="campo">
				</div>
			 <?php } ?>
			 <?php if($campo=="valor_mensual") { ?> 
				<label for="valor_mensual" class="col-sm-3 control-label">Valor Mensual</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="valor_mensual" name="valor_mensual" >
			<input type="hidden" value="<?php echo $tabla; ?>" id="tabla" name="tabla">
			<input type="hidden" value="<?php echo $campo; ?>" id="campo" name="campo">
				</div>
			 <?php } ?>
			 <?php if($campo=="avl") { ?> 
				<label for="avl" class="col-sm-3 control-label">AVL</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="avl" name="avl" >
			<input type="hidden" value="<?php echo $tabla; ?>" id="tabla" name="tabla">
			<input type="hidden" value="<?php echo $campo; ?>" id="campo" name="campo">
				</div>
			 <?php } ?>   
			 <?php if($campo=="plataforma") { ?> 
				<label for="plataforma" class="col-sm-3 control-label">Plataforma</label>				
				<div class="col-sm-3">
				 <select class="form-control" id="plataforma" name="plataforma" required>
					<option value="1" selected>1</option>
					<option value="2">2</option>
				  </select>
			<input type="hidden" value="<?php echo $tabla; ?>" id="tabla" name="tabla">
			<input type="hidden" value="<?php echo $campo; ?>" id="campo" name="campo">
				</div>
			 <?php } ?>  
			 <?php if($campo=="fecha") { ?>			 
             <div class="col-md-3">
             <label for="ex1">Fecha Activacion</label> 
             <input type="date" name="fecha" id="fecha" required>
			<input type="hidden" value="<?php echo $tabla; ?>" id="tabla" name="tabla">
			<input type="hidden" value="<?php echo $campo; ?>" id="campo" name="campo">
             </div>
			 <?php } ?>
			 <?php if($campo=="fecha_compra") { ?>			 
             <div class="col-md-3">
             <label for="ex1">Fecha Compra</label> 
             <input type="date" name="fecha_compra" id="fecha_compra" required>
			<input type="hidden" value="<?php echo $tabla; ?>" id="tabla" name="tabla">
			<input type="hidden" value="<?php echo $campo; ?>" id="campo" name="campo">
             </div>
			 <?php } ?> 
			 <?php if($campo=="propietario") { ?>
				<label for="propietario" class="col-sm-3 control-label">Propietario</label>
				<div class="col-sm-7">
				  <input type="text" class="form-control" id="propietario" name="propietario" >
			<input type="hidden" value="<?php echo $tabla; ?>" id="tabla" name="tabla">
			<input type="hidden" value="<?php echo $campo; ?>" id="campo" name="campo">
				</div>
			 <?php } ?> 
			 <?php if($campo=="tel_propietario") { ?> 
				<label for="tel_propietario" class="col-sm-3 control-label">Tel Propietario</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="tel_propietario" name="tel_propietario" >
			<input type="hidden" value="<?php echo $tabla; ?>" id="tabla" name="tabla">
			<input type="hidden" value="<?php echo $campo; ?>" id="campo" name="campo">
				</div>
			 <?php } ?> 
			 <?php if($campo=="ciudad") { ?> 
				<label for="ciudad" class="col-sm-3 control-label">Ciudad</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="ciudad" name="ciudad" >
			<input type="hidden" value="<?php echo $tabla; ?>" id="tabla" name="tabla">
			<input type="hidden" value="<?php echo $campo; ?>" id="campo" name="campo">
				</div>
			 <?php } ?>
			 <?php if($campo=="vehiculo") { ?> 
				<label for="vehiculo" class="col-sm-3 control-label">Vehiculo</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="vehiculo" name="vehiculo" >
			<input type="hidden" value="<?php echo $tabla; ?>" id="tabla" name="tabla">
			<input type="hidden" value="<?php echo $campo; ?>" id="campo" name="campo">
				</div>
			 <?php } ?>
			 <?php if($campo=="referencia1") { ?> 
				<label for="referencia1" class="col-sm-3 control-label">Referencia 1</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="referencia1" name="referencia1" >
			<input type="hidden" value="<?php echo $tabla; ?>" id="tabla" name="tabla">
			<input type="hidden" value="<?php echo $campo; ?>" id="campo" name="campo">
				</div>
			 <?php } ?>
			 <?php if($campo=="referencia2") { ?> 
				<label for="referencia2" class="col-sm-3 control-label">Referencia 2</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="referencia2" name="referencia2" >
			<input type="hidden" value="<?php echo $tabla; ?>" id="tabla" name="tabla">
			<input type="hidden" value="<?php echo $campo; ?>" id="campo" name="campo">
				</div>
			 <?php } ?>
			 <?php if($campo=="referencia3") { ?> 
				<label for="referencia3" class="col-sm-3 control-label">Referencia 3</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="referencia3" name="referencia3" >
			<input type="hidden" value="<?php echo $tabla; ?>" id="tabla" name="tabla">
			<input type="hidden" value="<?php echo $campo; ?>" id="campo" name="campo">
				</div>
			 <?php } ?>
			 <?php if($campo=="observaciones") { ?> 
				<label for="observaciones" class="col-sm-3 control-label">Observaciones</label>
				<div class="col-sm-4">
				  <input type="text" class="form-control" id="observaciones" name="observaciones" >
			<input type="hidden" value="<?php echo $tabla; ?>" id="tabla" name="tabla">
			<input type="hidden" value="<?php echo $campo; ?>" id="campo" name="campo">
				</div>
			 <?php } ?>   
			  </div>
		  <div class="modal-footer">
		  <button type="submit" class="btn btn-primary" id="actualizar_datos">MODIFICAR</button>
			<a href="edit_placa.php?placa=<?php echo $laplaca; ?>" class="btn btn-default" title='Cancelar' ><i> CANCELAR </i></a><br /><br />
		  </div>
		  </form>
		  <div class="form-group row">
		  <div class="col-md-2">
          <label for="ex1"> Estado</label> 
           <span class="">
					<a href="edit_placa1.php?placa=<?php echo $row_placas["placa"]; ?>&campo=estado&tabla=movequipos" class="" title='Editar' ><i><?php echo $estado; ?></i></a>
					</span>
         
          </div>
          <div class="col-md-5">
          <label for="ex1"> Cliente </label> 
           <span class="">
					<a href="clienteplaca.php?placa=<?php echo $row_placas["placa"]; ?>&campo=id_cliente&tabla=movequipos" class="" title='Editar' ><i><?php echo $row_cliente["nombre"]; ?></i></a>
					</span>
          </div><!-- 
		  <div class="col-md-5">
          <label for="ex1"> Grupo</label> 
           <span class="">
					<a href="edit_placa1.php?placa=<?php echo $row_placas["placa"]; ?>&campo=subgrupo&tabla=movequipos" class="" title='Editar' ><i><?php echo $row_grupo["nombre"]; ?></i></a>
					</span>
          </div>
          </div> -->
          
          
		  <div class="col-md-5">
          <label for="ex1"> Grupo Fact</label> 
           <span class="">
					<a href="edit_placa1.php?placa=<?php echo $row_placas["placa"]; ?>&campo=id_grupos&tabla=movequipos" class="" title='Editar' ><i><?php
						if ($row_placas["id_grupos"]==1) {
							echo "Pendiente"; }
						else {
							echo $row_elgrupo["nombre"];
						}?></i></a>
					</span>
          </div>
		  <div class="col-md-5">
          <label for="ex1"> Grupo</label> 
           <span class="">
					<a href="edit_placa1.php?placa=<?php echo $row_placas["placa"]; ?>&campo=subgrupo&tabla=movequipos" class="" title='Editar' ><i><?php
						if (empty($row_placas["subgrupo"])) {
							echo "Pendiente"; }
						else {
							echo $row_placas["subgrupo"];
						}?></i></a>
					</span>
          </div>
          </div>
          <div class="form-group row">
		  <div class="col-md-3">
          <label for="ex1"> Marca GPS</label> 
           <span class="">
					<a href="#" class="" title='Editar' ><i><?php echo $row_marca["marca"]; ?></i></a>
					</span>
          </div>
          <div class="col-md-3">
          <label for="ex1"> Modelo GPS</label> 
           <span class="">
					<a href="#" class="" title='Editar' ><i><?php echo $row_modelo["modelo"]; ?></i></a>
					</span>
          </div>
          <div class="col-md-3">
          <label for="ex1"> Tipo Contrato</label> 
           <span class="">
					<a href="edit_placa1.php?placa=<?php echo $row_placas["placa"]; ?>&campo=tipo_contrato&tabla=movequipos" class="" title='Editar' ><i><?php echo $row_placas["tipo_contrato"]; ?></i></a>
					</span>
          </div>
          <div class="col-md-2">
          <label for="ex1">Valor</label> 
           <span class="">
					<a href="edit_placa1.php?placa=<?php echo $row_placas["placa"]; ?>&campo=valor_mensual&tabla=movequipos" class="" title='Editar' ><i><?php echo $row_placas["valor_mensual"]; ?></i></a>
					</span>
          </div>
			  </div>
		  <div class="form-group row">
          <div class="col-md-3">
          <label for="ex1">Imei Equipo</label> 
           <span class="">
					<a href="gpse.php?placa=<?php echo $row_placas["placa"]; ?>&campo=id_equipo&tabla=movequipos" class="" title='Editar' id="gps" ><i><?php echo $row_equipo["imei"]; ?></i></a>
					</span>
          </div>
          <div class="col-md-3">
          <label for="ex1">AVL</label> 
           <span class="">
					<a href="edit_placa1.php?placa=<?php echo $row_placas["placa"]; ?>&campo=avl&tabla=movequipos" class="" title='Editar' ><i><?php echo $row_placas["avl"]; ?></i></a>
					</span>
          </div>
          <div class="col-md-3">
          <label for="ex1">Linea</label> 
           <span class="">
					<a href="sime.php?placa=<?php echo $row_placas["placa"]; ?>&campo=id_sim&tabla=movequipos" class="" title='Editar' id="sim" ><i><?php echo $row_sim["linea"]; ?></i></a>
					</span>
          </div>
          <div class="col-md-2">
          <label for="ex1">Plataforma</label> 
           <span class="">
					<a href="edit_placa1.php?placa=<?php echo $row_placas["placa"]; ?>&campo=plataforma&tabla=movequipos" class="" title='Editar' ><i><?php echo $row_placas["plataforma"]; ?></i></a>
					</span>
          </div>
			  </div>
			  
			  
		  <div class="form-group row">
          <div class="col-md-3">
          <label for="ex1">Imei Simcard</label> 
           <span class="">
					<a href="#" class="" title='Editar' ><i><?php echo $row_sim["imei_sim"]; ?></i></a>
					</span>
          </div>
          <div class="col-md-2">
          <label for="ex1">Operador</label> 
           <span class="">
					<a href="#" class="" title='Editar' ><i><?php echo $row_sim["empresa_sim"]; ?></i></a>
					</span>
          </div>
          <div class="col-md-3">
          <label for="ex1">Activacion</label> 
           <span class="">
					<a href="edit_placa1.php?placa=<?php echo $row_placas["placa"]; ?>&campo=fecha&tabla=movequipos" class="" title='Editar' ><i><?php
						if (empty($row_placas["fecha"])) {
							echo "Pendiente"; }
						else {
							echo $row_placas["fecha"];
						}?></i></a>
					</span>
          </div>
          <div class="col-md-3">
          <label for="ex1">Compra</label> 
           <span class="">
					<a href="edit_placa1.php?placa=<?php echo $row_placas["placa"]; ?>&campo=fecha_compra&tabla=movequipos" class="" title='Editar' ><i><?php
						if (empty($row_placas["fecha_compra"])) {
							echo "Pendiente"; }
						else {
							echo $row_placas["fecha_compra"];
						}?></i></a>
					</span>
          </div>
			  </div>
		  <div class="form-group row">
          <div class="col-md-5">
          <label for="ex1">Propietario</label> 
           <span class="">
					<a href="edit_placa1.php?placa=<?php echo $row_placas["placa"]; ?>&campo=propietario&tabla=movequipos" class="" title='Editar' ><i><?php
						if (empty($row_placas["propietario"])) {
							echo "Pendiente"; }
						else {
							echo $row_placas["propietario"];
						}?></i></a>
					</span>
          </div>
          <div class="col-md-2">
          <label for="ex1">Tel:</label> 
           <span class="">
					<a href="edit_placa1.php?placa=<?php echo $row_placas["placa"]; ?>&campo=tel_propietario&tabla=movequipos" class="" title='Editar' ><i><?php
						if (empty($row_placas["tel_propietario"])) {
							echo "Pendiente"; }
						else {
							echo $row_placas["tel_propietario"];
						}?></i></a>
					</span>
          </div>
          <div class="col-md-2">
          <label for="ex1">Ciudad</label> 
           <span class="">
					<a href="edit_placa1.php?placa=<?php echo $row_placas["placa"]; ?>&campo=ciudad&tabla=movequipos" class="" title='Editar' ><i><?php
						if (empty($row_placas["ciudad"])) {
							echo "Pendiente"; }
						else {
							echo $row_placas["ciudad"];
						}?></i></a>
					</span>
          </div>
          <div class="col-md-3">
          <label for="ex1">Vehiculo</label> 
           <span class="">
					<a href="edit_placa1.php?placa=<?php echo $row_placas["placa"]; ?>&campo=vehiculo&tabla=movequipos" class="" title='Editar' ><i><?php
						if (empty($row_placas["tipo_vehiculo"])) {
							echo "Pendiente"; }
						else {
							echo $row_placas["tipo_vehiculo"];
						}?></i></a>
					</span>
          </div>
			  </div>
		  <div class="form-group row">
          <div class="col-md-4">
          <label for="ex1">Referencia 1</label> 
           <span class="">
					<a href="edit_placa1.php?placa=<?php echo $row_placas["placa"]; ?>&campo=referencia1&tabla=movequipos" class="" title='Editar' ><i><?php
						if (empty($row_placas["referencia1"])) {
							echo "Pendiente"; }
						else {
							echo $row_placas["referencia1"];
						}?></i></a>
					</span>
          </div>
          <div class="col-md-4">
          <label for="ex1">Referencia 2</label> 
           <span class="">
					<a href="edit_placa1.php?placa=<?php echo $row_placas["placa"]; ?>&campo=referencia2&tabla=movequipos" class="" title='Editar' ><i><?php
						if (empty($row_placas["referencia2"])) {
							echo "Pendiente"; }
						else {
							echo $row_placas["referencia2"];
						}?></i></a>
					</span>
          </div>
          <div class="col-md-4">
          <label for="ex1">Referencia 3</label> 
           <span class="">
					<a href="edit_placa1.php?placa=<?php echo $row_placas["placa"]; ?>&campo=referencia3&tabla=movequipos" class="" title='Editar' ><i><?php
						if (empty($row_placas["referencia3"])) {
							echo "Pendiente"; }
						else {
							echo $row_placas["referencia3"];
						}?></i></a>
					</span>
          </div>
			  </div>
		  <div class="form-group row">
          <div class="col-md-12">
          <label for="ex1">Observaciones</label> 
           <span class="">
					<a href="edit_placa1.php?placa=<?php echo $row_placas["placa"]; ?>&campo=observaciones&tabla=movequipos" class="" title='Editar' ><i><?php
						if (empty($row_placas["observaciones"])) {
							echo "Pendiente"; }
						else {
							echo $row_placas["observaciones"];
						}?></i></a>
					</span>
          </div>
			  </div>
			  
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
mysqli_free_result($placas);
mysqli_free_result($equipo);
mysqli_free_result($cliente);
mysqli_free_result($grupo);
mysqli_free_result($sim);
mysqli_free_result($marca);
mysqli_free_result($modelo);
?>