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

$_GET['placa'];
$laplaca=$_GET['placa'];

$query_placas = "SELECT * FROM movequipos WHERE placa = '$laplaca' ORDER BY fecha_modificado";
$placas = mysqli_query($track, $query_placas) or die(mysqli_error());
$row_placas = mysqli_fetch_assoc($placas);

$elestado = $row_placas["estado"];
if($elestado=="a") {
	$estado ="Activo";
} else {
	$estado="Inactivo";
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

$query_grupo = "SELECT * FROM grupos WHERE id_grupos = '$id_grupos'";
$grupo = mysqli_query($track, $query_grupo) or die(mysqli_error());
$row_grupo = mysqli_fetch_assoc($grupo);

$query_sim = "SELECT * FROM sim WHERE id_sim = '$id_sim'";
$sim = mysqli_query($track, $query_sim) or die(mysqli_error());
$row_sim = mysqli_fetch_assoc($sim);


$query_cambios = "SELECT * FROM cambiosmov LEFT JOIN usuarios ON usuarios.id_usuario = cambiosmov.id_usuario WHERE placa = '$laplaca' ORDER BY fecha DESC";
$cambios = mysqli_query($track, $query_cambios) or die(mysqli_error());
$row_cambios = mysqli_fetch_assoc($cambios);


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
			<h4><i class='glyphicon glyphicon-list-alt'></i> <?php echo $row_placas["placa"]; ?> </h4>
		</div>
		<div class="panel-body">
		
		
		<div class="popup-contenedor">
		  <div class="modal-body">
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
							echo $row_grupo["nombre"];
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
			  
			  
           <?php if (isset($row_cambios["placa"])) {
			  ?>
            <div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>Dato</th>
					<th>Informacion</th>
					<th>Fecha</th>
					<th>Usuario</th>					
				</tr>
        			<?php	do { 
                        $dato=$row_cambios["cambio"]; 
                        $fecha=$row_cambios["fecha"];
						$usuario=$row_cambios["nombre"];
						//$date_added= date('d/m/Y', strtotime($row['date_added']));
				  

if ($row_cambios["campo"]=='placa') {
	$campo = 'Placa';
}
if ($row_cambios["campo"]=='id_equipo') {
	$campo = 'Equipo';
}
if ($row_cambios["campo"]=='id_cliente') {
	$campo = 'Cliente';
}
if ($row_cambios["campo"]=='id_grupos') {
	$campo = 'Grupo Fact';
}
if ($row_cambios["campo"]=='subgrupo') {
	$campo = 'Grupo';
}
if ($row_cambios["campo"]=='estado') {
	$campo = 'Estado';
}
if ($row_cambios["campo"]=='tipo_contrato') {
	$campo = 'Contrato';
}
if ($row_cambios["campo"]=='avl') {
	$campo = 'AVL';
}
if ($row_cambios["campo"]=='ciudad') {
	$campo = 'Ciudad';
}
if ($row_cambios["campo"]=='plataforma') {
	$campo = 'Plataforma';
}
if ($row_cambios["campo"]=='id_sim') {
	$campo = 'Linea';
}
if ($row_cambios["campo"]=='valor_mensual') {
	$campo = 'Valor Mensual';
}
if ($row_cambios["campo"]=='propietario') {
	$campo = 'Propietario';
}
if ($row_cambios["campo"]=='tipo_vehiculo') {
	$campo = 'Tipo V.';
}
if ($row_cambios["campo"]=='tel_propietario') {
	$campo = 'Telefono';
}
if ($row_cambios["campo"]=='referencia1') {
	$campo = 'Referencia 1';
}
if ($row_cambios["campo"]=='referencia2') {
	$campo = 'Referencia 2';
}
if ($row_cambios["campo"]=='referencia3') {
	$campo = 'Referencia 3';
}
if ($row_cambios["campo"]=='observaciones') {
	$campo = 'Observaciones';
}
if ($row_cambios["campo"]=='fecha') {
	$campo = 'Fecha Instalado';
}
if ($row_cambios["campo"]=='fecha_compra') {
	$campo = 'Fecha Compra';
}
						
					?>
					<tr>
						<td><?php echo $campo; ?></td>
						<td><?php echo $dato; ?></td>
						<td><?php echo $fecha; ?></td>
						<td><?php echo $usuario; ?></td>
						
					</tr>
<?php } while ($row_cambios = mysqli_fetch_assoc($cambios));	
			  ?>
			  </table>	
			</div>
			<?php }
			  ?>
			  
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
mysqli_free_result($cambios);
?>