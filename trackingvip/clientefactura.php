<?php
require_once('Connections/tracking.php');
require_once('config/login.php');
//require_once('Connections/cliente.php');

    $active_facturas="active";
	$active_productos="";
	$active_clientes="";
	$active_usuarios="";	
	$title="Factura";
if(isset($_GET['e'])){
	$noesta = 5;
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
	        		        
	        	<a href="clientes.php" class="btn btn-default" title='Cancelar' ><i class="glyphicon glyphicon-list-alt"> CANCELAR </i></a>	        
				<!-- <button type='button' class="btn btn-info" data-toggle="modal" data-target="#popnw"><span class="glyphicon glyphicon-plus" ></span> Nuevo Cliente</button> -->
			</div>
			<h4><i class='glyphicon glyphicon-list-alt'></i> Nueva Factura</h4>
		</div>
		<div class="panel-body"><br /><br />
		<form class="form-horizontal" method="post" id="new_factura" name="new_factura" action="Nfactura.php">
				
						<div class="form-group row">
							<div class="col-md-2">
							<label for="q" style="text-align: right">&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;NIT Cliente</label>
							</div>
							<div class="col-md-4">
								<input type="number" class="form-control" id="nit" name="nit" required>
							</div>
							<div class="col-md-3"><button type="submit" class="btn btn-primary" id="actualizar_datos">CONTINUAR</button>
							</div>
							
						</div>
				
				
				
			</form>
  </div>
</div>
	 
	 		 
	</div>
	<hr>
	
	
	
	<!-- Modal -->
  <div class="modal fade" id="myModal" role="dialog">
    <div class="modal-dialog">
    
      <!-- Modal content-->
      <div class="modal-content">
        <div class="modal-header">
          <button type="button" class="close" data-dismiss="modal">&times;</button>
        </div>
        <div class="modal-body">
          <p align="center" style="color: brown; font-size: 1.5em">No se encuentra NIT en clientes.<br />
Por favor confirmar la informacion.</p>
        </div>
        <div class="modal-footer">
          <button type="button" class="btn btn-default" data-dismiss="modal">Cerrar</button>
        </div>
      </div>
      
    </div>
  </div>
	
	<?php
	include("config/footer.php");
	?>
<?php
	if(isset($noesta)) {
echo '<script>
   $(document).ready(function()
   {
      $("#myModal").modal("show");
   });
</script>';
	}
?>
</body>
</html>
<?php
mysql_free_result($usu);
// mysql_free_result($cliente);

?>
