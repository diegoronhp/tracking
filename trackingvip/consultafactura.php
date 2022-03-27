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
<head><meta http-equiv="Content-Type" content="text/html; charset=windows-1252">

<title><?php echo $title;?></title>

<script language="JavaScript" src="src/js/jquery-1.5.1.min.js"></script>
<script language="JavaScript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="stylesheet" />
<link rel="stylesheet" href="css/custom.css">
<link rel="stylesheet" href="css/login.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

<style type="text/css">
	#popfac {
		opacity: 0;
		margin-top: -100px;
		overflow-y: scroll;
		position:fixed;
		z-index: 1050;
	}
	#popfac:target {
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
	.popfac-contenedor {
		position: relative;
		margin:7% auto;
		padding:30px 50px;
		background-color: #fafafa;
		color:#333;
		border-radius: 3px;
		width:50%;
	}
	a.popfac-cerrar {
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
    
	a.popfac-link {
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
	        	<?php if( $row_usu["facturacion"] == "e") { ?>
	        	<a href="#popfac" class="btn btn-default" title='Nuevo documento' ><i class="glyphicon glyphicon-plus"> Nuevo Documento </i></a>        
				<!-- <button type='button' class="btn btn-info" data-toggle="modal" data-target="#popnw"><span class="glyphicon glyphicon-plus" ></span> Nuevo Cliente</button> -->
			  <?php } ?>	        
			</div>
			<h4><i class='glyphicon glyphicon-list-alt'></i> Consulta Factura
			<a href="informes/todo_fact.php" class="btn btn-default" title='Excel' >  <i class="glyphicon glyphicon-export"></i> </a></h4>
		</div>
		<div class="panel-body"><br /><br />
		<form class="form-horizontal" method="post" id="new_factura" name="new_factura" action="verfactura.php">		
			  <div class="form-group row">
				<label for="opcion" class="col-sm-2 control-label">Buscar</label>	
				<div class="col-sm-3">
				 <select class="form-control" onchange="ShowSelected();" id="campo" name="campo" required>
					<option value=""></option>
					<option value="f">Factura</option>
					<option value="n">Nit Cliente</option>
				  </select>
				</div>
				<div class="col-sm-5">
				  <input type="text" class="form-control" id="numero" name="numero" required >
				</div>
				</div>
						<div class="form-group row">
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
          <p align="center" style="color: brown; font-size: 1.5em">No se encuentra informacion.<br />
Por favor intente nuevamente.</p>
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


	
	 <div class="modal-wrapper" id="popfac">
		<div class="popfac-contenedor">
		<a class="popfac-cerrar" href="#">X</a>
			<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-edit'></i> Tipo de documento</h4><br />
			<form class="form-horizontal" method="post" id="tipo_doc" name="tipo_doc" action="b_factura.php">		
			  <div class="form-group row">	
				<div class="col-sm-6">
				 <select class="form-control" id="tipo" name="tipo" required>
					<option value=""></option>
					<option value="r">Recibo de caja</option>
					<option value="n">Nota Credito</option>
				  </select>
				</div>
				</div>
		  <div class="modal-footer">
		  <button type="submit" class="btn btn-primary" id="enviar">SIGUIENTE</button>
			<a href="consultafactura.php" class="btn btn-default" title='Cancelar' ><i> CANCELAR </i></a><br /><br />
		  </div>
		  </form>
			
			
		  </div>
		</div>
		
		 
		  
		   <script>	
	
function ShowSelected()
{
/* Para obtener el valor */
var cod = document.getElementById("campo").value;
if(cod == "n")
	{
      numero.type = "number";
  }
  else if(cod == "f") // Si no está activada
  {
      numero.type = "text";
  }
	
}
	

</script> 
</body>
</html>
<?php
mysql_free_result($usu);
// mysql_free_result($cliente);

?>
