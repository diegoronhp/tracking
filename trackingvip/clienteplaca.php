<?php
require_once('Connections/tracking.php'); 
require_once('config/login.php');
//require_once('asignar/Connections/gps.php');

    $active_facturas="";
	$active_productos="";
	$active_gps="";
	$active_clientes="active";
	$active_usuarios="";	
	$title="GPS";

$campo='';
$_GET['campo'];
$campo=$_GET['campo'];
$_GET['tabla'];
$tabla=$_GET['tabla'];


$_SESSION['new']="";

if(isset($_GET['placa'])) {
$_GET['placa'];
$_SESSION['placa']=$_GET['placa'];
$laplaca=$_GET['placa'];
$cancela = "edit_placa.php?placa=".$_SESSION['placa'];
} else {
$_SESSION['placa'];
}



if(isset($_POST['placa'])) {
$_POST['placa'];
$_SESSION['new']="nuevo";
$_SESSION['placa']=$_POST['placa'];
$laplaca=$_POST['placa'];
$cancela = "vehiculos.php";
}

if(isset($_POST['grupo'])) {
$_SESSION['grupo']=$_POST['grupo'];
$cancela = "grupos.php";
}

if(isset($_POST['tipo'])) {
$_SESSION['tipo']=$_POST['tipo'];
$_SESSION['editgrupo']=$_POST['idgrupo'];
$_SESSION['editnombre']=$_POST['nombre'];
$cancela = "grupos.php";
}


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



</head>

<body>

	
<?php include("config/menu.php");?>


<div class="container">

	<div class="panel panel-info">
		<div class="panel-heading">
		    <div class="btn-group pull-right">
	        		        
	        	<a href="<?php echo $cancela; ?>" class="btn btn-default" title='Cancelar' ><i> CANCELAR </i></a>	        
				<!-- <button type='button' class="btn btn-info" data-toggle="modal" data-target="#popnw"><span class="glyphicon glyphicon-plus" ></span> Nuevo Cliente</button> -->
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Asignar CLIENTE <?php echo $laplaca; ?></h4>
		</div>
		<div class="panel-body">
			<form class="form-horizontal" role="form" id="dato">
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">CLIENTE</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="CLIENTE" onkeyup='load(1);'>
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
	<hr>
	<?php
	include("config/footer.php");
	?>

<script type="text/javascript" src="js/cliente_placa.js"></script><!-- MUESTRA RESULTADOS -->


</body>
</html>
<?php
mysql_free_result($usu);
// mysql_free_result($cliente);

?>
