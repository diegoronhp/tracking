<?php
require_once('Connections/tracking.php'); 
require_once('config/login.php');
//require_once('Connections/gps.php');

    $active_facturas="";
	$active_productos="";
	$active_linea="active";
	$active_usuarios="";	
	$title="LINEAS";

if (isset($_GET['id'])) 
	{
		$elid = $_GET['id'];

		$query_sim = "SELECT * FROM sim WHERE id_sim = $elid";
		$sim = mysqli_query($track, $query_sim) or die(mysqli_error($track));
		$row_sim = mysqli_fetch_assoc($sim);
		$totalRows_sim = mysqli_num_rows($sim);

		if ($row_sim['empresa_sim']=="AVANTEL") 
			{
				$seleca = "selected";
			}
		if ($row_sim['empresa_sim']=="CLARO") 
			{
				$selecc = "selected";
			}
		if ($row_sim['empresa_sim']=="MOVISTAR") 
			{
				$selecm = "selected";
			}
		if ($row_sim['empresa_sim']=="TIGO") 
			{
				$select = "selected";
			}
		if ($row_sim['empresa_sim']=="ETB") 
			{
				$selece = "selected";
			}
		if ($row_sim['estado']=="Activo") 
			{
				$selecac = "selected";
			}
		if ($row_sim['estado']=="Inactivo") 
			{
				$selecin = "selected";
			}
		if ($row_sim['tipo']==1) 
			{
				$selecpos = "selected";
			} elseif($row_sim['tipo']==2) 
				{
					$selecpre = "selected";
				}
	}
/*
mysqli_select_db($database_track,$track);
$query_marcas = "SELECT * FROM marca_gps ORDER BY marca";
$marcas = mysqli_query($query_marcas, $track) or die(mysqli_error($track));
$row_marcas = mysqli_fetch_assoc($marcas);

$query_modelo = "SELECT * FROM modelo_gps ORDER BY modelo";
$modelo = mysqli_query($query_modelo, $track) or die(mysqli_error($track));
$row_modelo = mysqli_fetch_assoc($modelo);
*/

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

<style type="text/css">
	#popew {
				opacity: 0;
				margin-top: -100px;
				overflow-y: scroll;
				position:fixed;
				z-index: 1050;
			}
	#popew:target 
			{
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
	.popew-contenedor 
			{
				position: relative;
				margin:7% auto;
				padding:30px 50px;
				background-color: #fafafa;
				color:#333;
				border-radius: 3px;
				width:50%;
			}
	a.popew-cerrar 
			{
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
    
	a.popew-link 
			{
	   			text-align: center;
	    		display: block;
	    		margin: 30px 0;
			}
	
	#popnw 
			{
				opacity: 0;
				margin-top: -100px;
				overflow-y: scroll;
				position:fixed;
				z-index: 1050;
			}
	#popnw:target 
			{
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
	.popnw-contenedor 
			{
				position: relative;
				margin:7% auto;
				padding:30px 50px;
				background-color: #fafafa;
				color:#333;
				border-radius: 3px;
				width:50%;
			}
	a.popnw-cerrar 
			{
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
    
	a.popnw-link 
			{
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
	        	<?php if( $row_usu["lineas"] == "e") { ?>
	        	<a href="#popnw" class="btn btn-default" title='Nueva LINEA' ><i class="glyphicon glyphicon-earphone"> Nueva SIM </i></a>	
			  <?php } ?>	                
				<!-- <button type='button' class="btn btn-info" data-toggle="modal" data-target="#popnw"><span class="glyphicon glyphicon-plus" ></span> Nuevo Cliente</button> -->
			</div>
			<h4><i class='glyphicon glyphicon-search'></i> Buscar SIM <a href="informes/todo_lineas.php" class="btn btn-default" title='Excel' >  <i class="glyphicon glyphicon-export"></i> </a></h4>
		</div>
		
		<div class="panel-body">
			<form class="form-horizontal" role="form" id="dato">
						<div class="form-group row">
							<label for="q" class="col-md-2 control-label">SIM</label>
							<div class="col-md-5">
								<input type="text" class="form-control" id="q" placeholder="LINEA SIM" onkeyup='load(1);'>
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

<!-- *************************************************Nueva Linea ********************************************-->

	<div class="modal-wrapper" id="popnw">
	
		<div class="popnw-contenedor">
		
			<a class="popnw-cerrar" href="#">X</a>
				<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-new-window'></i> Nueva Linea Celular</h4>
			<div class="modal-body">
				<form class="form-horizontal" method="post" id="new_gps" name="new_gps" action="Connections/guardar_linea.php">
				<div id="resultados_ajax2"></div>
			
				<div class="form-group">
					<label for="imei_sim" class="col-sm-3 control-label">IMEI SIM</label>
						<div class="col-sm-8">
							<input type="text" class="form-control" id="imei_sim" name="imei_sim" required>
						</div> 
				</div>
				
			<div class="form-group">
				<label for="linea" class="col-sm-3 control-label">Linea</label>
					<div class="col-sm-8">
						<input type="text" class="form-control" id="linea" name="linea" required>
					</div> 
			</div>
				
			<div class="form-group">
				<label for="empresa_sim" class="col-sm-3 control-label">Operador</label>				
					<div class="col-sm-8">
						<select class="form-control" id="empresa_sim" name="empresa_sim" required>
							<option value=""></option>
								<?php 
								$sql2=$track->query("select * from operadores");
								while ($fila=$sql2->fetch_array()) 
									{
										echo "<option value='".$fila['operador_plan']."'>".$fila['operador_plan']."</option>";
									}
								?>
						</select>
					</div>
			</div>
				
			<div class="form-group">
				<label for="nombre_plan" class="col-sm-3 control-label">Nombre del Plan</label>				
					<div class="col-sm-8">
						<select class="form-control" id="nombre_plan" name="nombre_plan" required>
							<option value=""></option>
							<?php 
								$sql1=$track->query("select * from planes order by nombre_plan ASC ");
								while ($fila=$sql1->fetch_array()) 
									{
										echo "<option value='".$fila['nombre_plan']."'>".$fila['nombre_plan']."</option>";
									}
							?>								 
						</select>
					</div>
			</div>
				
			<div class="form-group">
				<label for="valor_mensual" class="col-sm-3 control-label">Valor Mensual</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="valor_mensual" name="valor_mensual" required>
					</div> 
			</div>
				
			<div class="form-group">
				<label for="tipo" class="col-sm-3 control-label">Tipo</label>
					<div class="col-sm-8">
						<select class="form-control" id="tipo" name="tipo" required>
							<option value="2">Prepago</option>
							<option value="1">Postpago</option>
						</select>
					</div>
			</div>
				
			<div class="form-group">
				<label for="estado" class="col-sm-3 control-label">Estado</label>
					<div class="col-sm-8">
						<select class="form-control" id="estado" name="estado" required>
							<option value="Activo">Activo</option>
							<option value="Inactivo">Inactivo</option>
						</select>
					</div>
			</div>
				
			</div>
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" id="actualizar_datos">Ingresar datos</button>
					<a href="linea.php" class="btn btn-default" title='Cancelar' ><i> CANCELAR </i></a>
				</div>
				</form>
			</div>
	</div>

<!-- ****************************************************Editar Linea ***************************************** -->
	
	<div class="modal-wrapper" id="popew">
	
		<div class="popew-contenedor">
			<a class="popew-cerrar" href="linea.php">X</a>
				<h4 class="modal-title" id="myModalLabel"><i class='glyphicon glyphicon-new-window'></i> Editar Linea</h4>
			  <div class="modal-body">
			
			<form class="form-horizontal" method="post" id="edit_sim" name="edit_sim" action="Connections/edit_linea.php">
				<div id="resultados_ajax2"></div>
				
				<div class="form-group">
					<label for="mod_nit" class="col-sm-3 control-label">ID SIM</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" value="<?php echo $row_sim['id_sim']; ?>" id="id_sim" name="id_sim" readonly required>
					</div>
				</div>
				
				<div class="form-group">
					<label for="mod_nit" class="col-sm-3 control-label">IMEI SIM</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="imei_sim" name="imei_sim" value="<?php echo $row_sim['imei_sim'];?>" required>
					</div> 
				</div>
				
				<div class="form-group">
					<label for="marca" class="col-sm-3 control-label">Linea</label>
					<div class="col-sm-8">
					  <input type="text" class="form-control" id="linea" name="linea" value="<?php echo $row_sim['linea'];?>" required>
					</div> 
				</div>
				
				<div class="form-group">
					<label for="modelo" class="col-sm-3 control-label">Operador</label>				
					<div class="col-sm-8">
						<select class="form-control" id="empresa_sim" name="empresa_sim" required>
							<option value=""></option>
							<option value="AVANTEL" <?php echo $seleca;?>>AVANTEL</option>
							<option value="CLARO" <?php echo $selecc;?>>CLARO</option>
							<option value="MOVISTAR" <?php echo $selecm;?>>MOVISTAR</option>
							<option value="MOVISTAR" <?php echo $select;?>>TIGO</option>
							<option value="MOVISTAR" <?php echo $selece;?>>ETB</option>
					  </select>
					</div>
				</div>
				
				<div class="form-group">
					<label for="estado" class="col-sm-3 control-label">Tipo</label>
					<div class="col-sm-8">
						<select class="form-control" id="tipo" name="tipo" required>
							<option value="1" <?php echo $selecpos;?>>Postpago</option>
							<option value="2" <?php echo $selecpre;?>>Prepago</option>
						</select>
					</div>
				</div>
				
				<div class="form-group">
					<label for="estado" class="col-sm-3 control-label">Estado</label>
					<div class="col-sm-8">
						<select class="form-control" id="estado" name="estado" required>
							<option value="Activo" <?php echo $selecac;?>>Activo</option>
							<option value="Inactivo" <?php echo $selecin;?>>Inactivo</option>
						</select>
					</div>
				</div>
				</div>
				
				<div class="modal-footer">
					<button type="submit" class="btn btn-primary" id="actualizar_datos">Actualizar datos</button>
						<a href="linea.php" class="btn btn-default" title='Cancelar' ><i> CANCELAR </i></a>
				</div>
			
			</form>
		</div>
	</div>

	<hr>
	<?php
		include("config/footer.php");
	?>
<script type="text/javascript" src="js/linea.js"></script><!-- MUESTRA RESULTADOS -->
</body>
</html>
<?php
mysqli_free_result($usu);
/* mysqli_free_result($sim); */
?>