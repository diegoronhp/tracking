<?php
require_once('Connections/tracking.php'); 
require_once('config/login.php');
//require_once('Connections/gps.php');

    $active_fact="";
	$active_productos="";
	$active_gps="";
	$active_usuarios="active";	
	$title="USUARIOS";


$query_consult = "SELECT * FROM usuarios ORDER BY estado ASC ";
$consult = mysqli_query($track, $query_consult) or die(mysqli_error($track));
$row_consult = mysqli_fetch_assoc($consult);


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
.bluecol {
    color: blue;
}	
.greencol {
    color: green;
}		
.redcol {
    color: red;
}	
</style>
</head>
<body>
<?php include("config/menu.php");?>
	<div class="container">
	<div class="panel panel-info">
	   <div class="panel-heading">
		    <div class="btn-group pull-right">		    
		<?php if( $row_usu["usuarios"] == "e") { ?>
		    <a href="new_usu.php" class="btn btn-default" title='Nuevo usuario' ><i class="glyphicon glyphicon-plus"> Nuevo </i></a>
			  <?php } ?>
			</div>
	   <h4><i class='glyphicon glyphicon-user'></i> Usuarios</h4>
		</div>
		<div class="panel-body">
       
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>Nombre</th>
					<th>Usuario</th>
					<th>Clave</th>
					<th>Estado</th>
					<th class="text-center">Clientes</th>
					<th class="text-center">Facturacion</th>
					<th class="text-center">Equipos</th>
					<th class="text-center">Lineas</th>
					<th class="text-center">Vehiculos</th>
					<th class="text-center">Grupos</th>
					<th class="text-center">Lineas P.</th>
					<th class="text-center">Usuarios</th>
					<th></th>
			  </tr>
				<?php   do {
						$id_usuario=$row_consult["id_usuario"];
						$nombre=$row_consult["nombre"];
						$usuario=$row_consult["usuario"];
						$clave=$row_consult["clave"];
						$elestado=$row_consult["estado"];
						$cliente=$row_consult["cliente"];
						$lineas=$row_consult["lineas"];
						$lineasp=$row_consult["lineaspre"];
						$vehiculos=$row_consult["vehiculos"];
						$grupos=$row_consult["grupos"];
						$facturacion=$row_consult["facturacion"];
						$equipos=$row_consult["equipos"];
						$usuarios=$row_consult["usuarios"];
						if ($elestado=="a"){$estado="Activo";}
						else {$estado="Inactivo";}
	                    if( $cliente == "e") {
							$imac = "edit bluecol";
							$texc = "Edicion";
						} elseif ( $cliente == "v") {
							$imac = "eye-open greencol";
							$texc = "Consulta";
						} else {$imac = "ban-circle redcol";
							$texc = "Sin permisos";}
	                    if( $facturacion == "e") {
							$imaf = "edit bluecol";
							$texf = "Edicion";
						} elseif ( $facturacion == "v") {
							$imaf = "eye-open greencol";
							$texf = "Consulta";
						} else {$imaf = "ban-circle redcol";
							$texf = "Sin permisos";}
	                    if( $equipos == "e") {
							$imae = "edit bluecol";
							$texe = "Edicion";
						} elseif ( $equipos == "v") {
							$imae = "eye-open greencol";
							$texe = "Consulta";
						} else {$imae = "ban-circle redcol";
							$texe = "Sin permisos";}
	                    if( $usuarios == "e") {
							$imau = "edit bluecol";
							$texu = "Edicion";
						} elseif ( $usuarios == "v") {
							$imau = "eye-open greencol";
							$texu = "Consulta";
						} else {$imau = "ban-circle redcol";
							$texu = "Sin permisos";}
	
	
	                    if( $lineas == "e") {
							$imal = "edit bluecol";
							$texl = "Edicion";
						} elseif ( $lineas == "v") {
							$imal = "eye-open greencol";
							$texl = "Consulta";
						} else {$imal = "ban-circle redcol";
							$texl = "Sin permisos";}
	
	                    if( $lineasp == "e") {
							$imalp = "edit bluecol";
							$texlp = "Edicion";
						} elseif ( $lineasp == "v") {
							$imalp = "eye-open greencol";
							$texlp = "Consulta";
						} else {$imalp = "ban-circle redcol";
							$texlp = "Sin permisos";}
	
	                    if( $vehiculos == "e") {
							$imav = "edit bluecol";
							$texv = "Edicion";
						} elseif ( $vehiculos == "v") {
							$imav = "eye-open greencol";
							$texv = "Consulta";
						} else {$imav = "ban-circle redcol";
							$texv = "Sin permisos";}
	
	
	                    if( $grupos == "e") {
							$imag = "edit bluecol";
							$texg = "Edicion";
						} elseif ( $grupos == "v") {
							$imag = "eye-open greencol";
							$texg = "Consulta";
						} else {$imag = "ban-circle redcol";
							$texg = "Sin permisos";}
					?>
					<tr>
					<td><?php echo $nombre; ?></td>
						<td><?php echo $usuario; ?></td>
						<td><?php echo $clave;?></td>
						<td><?php echo $estado;?></td>
						<td class="text-center"><i title='<?php echo $texc; ?>' class="glyphicon glyphicon-<?php echo $imac; ?>"></i></td>
						<td class="text-center"><i title='<?php echo $texf; ?>'  class="glyphicon glyphicon-<?php echo $imaf; ?>"></i></td>
						<td class="text-center"><i title='<?php echo $texe; ?>'  class="glyphicon glyphicon-<?php echo $imae; ?>"></i></td>				
						
						<td class="text-center"><i title='<?php echo $texl; ?>'  class="glyphicon glyphicon-<?php echo $imal; ?>"></i></td>
						
						<td class="text-center"><i title='<?php echo $texv; ?>'  class="glyphicon glyphicon-<?php echo $imav; ?>"></i></td>
						
						<td class="text-center"><i title='<?php echo $texg; ?>'  class="glyphicon glyphicon-<?php echo $imag; ?>"></i></td>
						
						<td class="text-center"><i title='<?php echo $texlp; ?>'  class="glyphicon glyphicon-<?php echo $imalp; ?>"></i></td>
						
						<td class="text-center"><i title='<?php echo $texu; ?>'  class="glyphicon glyphicon-<?php echo $imau; ?>"></i></td>
		<?php if( $row_usu["usuarios"] == "e") { ?>
					<td ><span class="pull-right">
					<a href="edit_usuario.php?id=<?php echo $id_usuario; ?>" class="btn btn-default" title='Editar usuario' ><i class="glyphicon glyphicon-edit"></i></a>
					<!-- <a href="#" class='btn btn-default' title='Borrar cliente' onclick="eliminar('<?php echo $id_cliente; ?>')"><i class="glyphicon glyphicon-trash"></i> </a> -->
					</span></td>
			  <?php } ?>
					</tr>
			  <?php } while ($row_consult = mysqli_fetch_assoc($consult)); ?>
			  </table>
			</div>
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
mysqli_free_result($usu);
// mysqli_free_result($cliente);

?>