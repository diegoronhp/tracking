<?php

	
	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../Connections/tracking.php");//Contiene funcion que conecta a la base de datos
  session_start();
  
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
		 $aColumns = array('linea');//Columnas de busqueda
		 $sTable = "sim";
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		$sWhere22 .=" order by equipos.imei ASC";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 1; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query = mysqli_query($con, "SELECT count(*) AS numrows, id_sim FROM sim");
		$row = mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './sime.php';
		//main query to fetch the data		
		$sql="SELECT id_sim, imei_sim, linea, empresa_sim FROM sim WHERE (linea LIKE '%$q%' AND id_sim NOT IN (SELECT id_sim FROM movequipos WHERE estado = 'a')) order by id_sim DESC LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		
		
        $laplaca = $_SESSION['placa'];
		if ($_SESSION['new']=="nuevo") {
			$destino = "new_placa1.php";
            $_SESSION['id_equipo'];
			$cliente_equipo = $_SESSION['id_equipo'];
			$cliente_placa = $_SESSION['id_clien'];
		} else {
			$destino = "Connections/edit_placas.php";			
		}
				
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
					
			<form class="form-horizontal" method="post" id="edit_placa" name="edit_placa" action="<?php echo $destino; ?>">
			        <input type="hidden" value="<?php echo $laplaca; ?>" id="placa" name="placa">
			        <input type="hidden" value="movequipos" id="tabla" name="tabla">
			        <input type="hidden" value="id_sim" id="campo" name="campo">
			  <table class="table">
				<tr  class="info">
					<th>Linea</th>
					<th>Imei</th>
					<th>Empresa</th>
					<th class='text-right'></th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_sim=$row['id_sim'];
						$imei_sim=$row['imei_sim'];
						$linea=$row['linea'];
						$empresa_sim=$row['empresa_sim'];
						//$date_added= date('d/m/Y', strtotime($row['date_added']));
						
					?>
					<?php if(!empty ($q)) { ?>
					<input type="hidden" value="<?php echo $id_sim; ?>" id="id_sim" name="id_sim">
					<input type="hidden" value="<?php echo $linea; ?>" id="cambio" name="cambio">
					<tr>
						<td><?php echo $linea; ?></td>					
						<td><?php echo $imei_sim; ?></td>
						<td><?php echo $empresa_sim;?></td>
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