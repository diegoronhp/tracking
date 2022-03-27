<?php

	
	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../Connections/tracking.php");//Contiene funcion que conecta a la base de datos
  session_start();


$_SESSION['concepto'];
$concepto=$_SESSION['concepto'];
  
    $con=@mysqli_connect($hostname_track, $username_track, $password_track, $database_track);
    if(!$con){
        die("imposible conectarse: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Conexión falló: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }

	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('numero');//Columnas de busqueda
		 $sTable = "facturacion";
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $ii=0 ; $ii<count($aColumns) ; $ii++ )
			{
				$sWhere .= $aColumns[$ii]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		$sWhere.=" order by numero";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 1; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		
		$count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row = mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './b_factura.php';
		//main query to fetch the data
		
		$sql="SELECT f.numero, f.fecha_fact, f.vencimiento, f.id_cliente, f.total, c.id_cliente, c.nombre FROM $sTable f JOIN clientes c ON f.id_cliente = c.id_cliente $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
				
		
		
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
					
			<form class="form-horizontal" method="post" id="cliente_placa" name="cliente_placa" action="verfactura.php">
					<input type="hidden" value="f" id="campo" name="campo">
					<input type="hidden" value="<?php echo $concepto; ?>" id="concepto" name="concepto">
			  <table class="table">
				<tr  class="info">
					<th>Cliente</th>
					<th>Factura</th>
					<th>Fecha</th>
					<th>Vencimiento</th>
					<th>Valor</th>
					<th class='text-right'></th>					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$cliente=$row['nombre'];
						$numero=$row['numero'];
						$fecha=$row['fecha_fact'];
						$vencimiento=$row['vencimiento'];
						$valor=number_format($row['total']);
						//$date_added= date('d/m/Y', strtotime($row['date_added']));
						
					?>
					<?php if(!empty ($q)) { ?>
					<input type="hidden" value="<?php echo $numero; ?>" id="numero" name="numero">
					<tr>
						<td><?php echo $cliente; ?></td>
						<td><?php echo $numero; ?></td>
						<td><?php echo $fecha; ?></td>
						<td><?php echo $vencimiento;?></td>
						<td><?php echo $valor?></td>
						<td >
					<span class="pull-right">
					<button type="submit" class="btn btn-primary" id="actualizar_datos">ASIGNAR</button>
					</span>
					</td>				
					</tr>
					<?php } ?>
					<?php
				}
				?>
				<tr>
					<td colspan=7><span class="pull-right">
					<?php
					/*echo paginate($reload, $page, $total_pages, $adjacents);*/
					?></span></td>
				</tr>
			  </table>
		  </form>			
			</div>
			<?php
		}
	}
?>