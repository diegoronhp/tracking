<?php
require_once('Connections/tracking.php'); 
require_once('config/login.php');
//require_once('Connections/gps.php');

    $active_fact="";
	$active_productos="";
	$active_gps="";
	$active_usuarios="active";	
	$title="USUARIOS";


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
	   <h4><i class='glyphicon glyphicon-user'></i> Nuevo usuario</h4>
		</div>
		<div class="panel-body">
        <form class="form-horizontal" method="post" role="form" id="usuraio" name="usuario" action="Connections/new_usu.php">
         <div class="form-group row">
          <div class="col-md-5">
          <label for="ex1"> Nombre</label>
          <input class="form-control" id="nombre" name="nombre" value="" type="text" required>
           </div> 
		  <div class="col-md-4">
          <label for="ex1"> Usuario</label>
          <input class="form-control" id="usuario" name="usuario" value="" type="text">
          </div>
          <div class="col-md-3">
          <label for="ex1"> Clave</label>
          <input class="form-control" id="clave" name="clave" value="" type="text">
          </div>
          </div>
		  <div class="modal-footer">
		  <button type="submit" class="btn btn-primary" id="actualizar_datos">CREAR USUARIO</button>
			<a href="usuario.php" class="btn btn-default" title='Cancelar' ><i class=""> CANCELAR </i></a><br /><br />
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
mysql_free_result($usu);
// mysql_free_result($cliente);

?>
