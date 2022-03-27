<?php
require_once('Connections/tracking.php'); 
require_once('config/login.php');
//require_once('Connections/gps.php');

    $active_fact="";
	$active_productos="";
	$active_gps="";
	$active_usuarios="active";	
	$title="USUARIOS";

$_GET['id'];
$elid = $_GET['id'];

$query_consult = "SELECT * FROM usuarios WHERE id_usuario = $elid ";
$consult = mysqli_query($track, $query_consult) or die(mysqli_error());
$row_consult = mysqli_fetch_assoc($consult);


$id_usuario=$row_consult["id_usuario"];
$nombre=$row_consult["nombre"];
$usuario=$row_consult["usuario"];
$clave=$row_consult["clave"];
$elestado=$row_consult["estado"];
if ($elestado=="a"){
	$estado="Activo";
    $elesta = "selected";
}
else {$estado="Inactivo";	 
    $elesti = "selected";}


if ($row_consult["cliente"]=="e"){
    $selece = "selected";
} elseif ($row_consult["cliente"]=="v"){
    $selecv = "selected";
} elseif ($row_consult["cliente"]=="n"){
    $selecn = "selected";
}

if ($row_consult["facturacion"]=="e"){
    $selefe = "selected";
} elseif ($row_consult["facturacion"]=="v"){
    $selefv = "selected";
} elseif ($row_consult["facturacion"]=="n"){
    $selefn = "selected";
}

if ($row_consult["equipos"]=="e"){
    $seleee = "selected";
} elseif ($row_consult["equipos"]=="v"){
    $seleev = "selected";
} elseif ($row_consult["equipos"]=="n"){
    $seleen = "selected";
}

if ($row_consult["usuarios"]=="e"){
    $seleue = "selected";
} elseif ($row_consult["usuarios"]=="v"){
    $seleuv = "selected";
} elseif ($row_consult["usuarios"]=="n"){
    $seleun = "selected";
}

if ($row_consult["lineas"]=="e"){
    $selele = "selected";
} elseif ($row_consult["lineas"]=="v"){
    $selelv = "selected";
} elseif ($row_consult["lineas"]=="n"){
    $seleln = "selected";
}


if ($row_consult["lineaspre"]=="e"){
    $selelpe = "selected";
} elseif ($row_consult["lineaspre"]=="v"){
    $selelpv = "selected";
} elseif ($row_consult["lineaspre"]=="n"){
    $selelpn = "selected";
}

if ($row_consult["vehiculos"]=="e"){
    $seleve = "selected";
} elseif ($row_consult["vehiculos"]=="v"){
    $selevv = "selected";
} elseif ($row_consult["vehiculos"]=="n"){
    $selevn = "selected";
}

if ($row_consult["grupos"]=="e"){
    $selege = "selected";
} elseif ($row_consult["grupos"]=="v"){
    $selegv = "selected";
} elseif ($row_consult["grupos"]=="n"){
    $selegn = "selected";
}
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
</head>
<body>
<?php include("config/menu.php");?>
	<div class="container">
	<div class="panel panel-info">
	   <div class="panel-heading">
		    <div class="btn-group pull-right">	
			</div>
	   <h4><i class='glyphicon glyphicon-user'></i> Editar <?php echo $nombre; ?></h4>
		</div>
		<div class="panel-body">
		  <form class="form-horizontal" method="post" id="edit_usu" name="edit_usu" action="Connections/edit_usu.php">
		  <input type="hidden" id="id_usuario" name="id_usuario" value="<?php echo $id_usuario; ?>" />  
			<div class="form-group">
				<div class="col-sm-4">
				<label for="mod_nit" class="col-sm-3 control-label">Nombre</label>
					<input type="text" class="form-control" value="<?php echo $nombre; ?>" id="nombre" name="nombre" required>
			  </div>
				<div class="col-sm-3">
				<label for="mod_nit" class="col-sm-3 control-label">Usuario</label>
					<input type="text" class="form-control" value="<?php echo $usuario; ?>" id="usuario" name="usuario" required>
				</div>
				<div class="col-sm-3">
				<label for="mod_nit" class="col-sm-3 control-label">Clave</label>
					<input type="text" class="form-control" value="<?php echo $clave; ?>" id="clave" name="clave" required>
				</div>
			  </div>
			<div class="form-group">
			 <div class="col-sm-2">
			 <label for="mod_nit" class="col-sm-2 control-label">Clientes</label>
				 <select class="form-control" id="cliente" name="cliente" required>
					<option value="e" <?php echo $selece;?>>EDITAR</option>
					<option value="v" <?php echo $selecv;?>>CONSULTA</option>
					<option value="n" <?php echo $selecn;?>>NINGUNO</option>
				  </select>
				</div>
			 <div class="col-sm-2">
			 <label for="mod_nit" class="col-sm-2 control-label">Facturacion</label>
				 <select class="form-control" id="facturacion" name="facturacion" required>
					<option value="e" <?php echo $selefe;?>>EDITAR</option>
					<option value="v" <?php echo $selefv;?>>CONSULTA</option>
					<option value="n" <?php echo $selefn;?>>NINGUNO</option>
				  </select>
				</div>
			 <div class="col-sm-2">
			 <label for="mod_nit" class="col-sm-2 control-label">Equipos</label>
				 <select class="form-control" id="equipos" name="equipos" required>
					<option value="e" <?php echo $seleee;?>>EDITAR</option>
					<option value="v" <?php echo $seleev;?>>CONSULTA</option>
					<option value="n" <?php echo $seleen;?>>NINGUNO</option>
				  </select>
				</div>				
				
			 <div class="col-sm-2">
			 <label for="mod_nit" class="col-sm-2 control-label">Lineas</label>
				 <select class="form-control" id="lineas" name="lineas" required>
					<option value="e" <?php echo $selele;?>>EDITAR</option>
					<option value="v" <?php echo $selelv;?>>CONSULTA</option>
					<option value="n" <?php echo $seleln;?>>NINGUNO</option>
				  </select>
				</div>	
			 <div class="col-sm-2">
			 <label for="mod_nit" class="col-sm-2 control-label">Prepago</label>
				 <select class="form-control" id="lineaspre" name="lineaspre" required>
					<option value="e" <?php echo $selelpe;?>>EDITAR</option>
					<option value="v" <?php echo $selelpv;?>>CONSULTA</option>
					<option value="n" <?php echo $selelpn;?>>NINGUNO</option>
				  </select>
				</div>	
				</div>	
			<div class="form-group">		
				
			 <div class="col-sm-2">
			 <label for="mod_nit" class="col-sm-2 control-label">Vehiculos</label>
				 <select class="form-control" id="vehiculos" name="vehiculos" required>
					<option value="e" <?php echo $seleve;?>>EDITAR</option>
					<option value="v" <?php echo $selevv;?>>CONSULTA</option>
					<option value="n" <?php echo $selevn;?>>NINGUNO</option>
				  </select>
				</div>			
				
			 <div class="col-sm-2">
			 <label for="mod_nit" class="col-sm-2 control-label">Grupos</label>
				 <select class="form-control" id="grupos" name="grupos" required>
					<option value="e" <?php echo $selege;?>>EDITAR</option>
					<option value="v" <?php echo $selegv;?>>CONSULTA</option>
					<option value="n" <?php echo $selegn;?>>NINGUNO</option>
				  </select>
				</div>
				
				
				
			 <div class="col-sm-2">
			 <label for="mod_nit" class="col-sm-2 control-label">Usuarios</label>
				 <select class="form-control" id="usuarios" name="usuarios" required>
					<option value="e" <?php echo $seleue;?>>EDITAR</option>
					<option value="v" <?php echo $seleuv;?>>CONSULTA</option>
					<option value="n" <?php echo $seleun;?>>NINGUNO</option>
				  </select>
				</div>
			 <div class="col-sm-2">
			 <label for="mod_nit" class="col-sm-2 control-label">Estado</label>
				 <select class="form-control" id="estado" name="estado" required>
				 <option value=""></option>
					<option value="a" <?php echo $elesta;?>>Activo</option>
					<option value="i" <?php echo $elesti;?>>Inactivo</option>
				  </select>
				</div>
			  </div>
		  <div class="modal-footer">
		  <button type="submit" class="btn btn-primary" id="actualizar_datos">ACTUALIZAR</button>
			<a href="usuario.php" class="btn btn-default" title='Cancelar' ><i class="glyphicon glyphicon-list-alt"> CANCELAR </i></a><br /><br />
				</div>
			  </form>
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