<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
	
	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../Connections/tracking.php");//Contiene funcion que conecta a la base de datos
    require_once('../config/login.php');
  
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
		 $aColumns = array('imei');//Columnas de busqueda
		 $sTable = "equipos";
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
		$sWhere.=" order by equipos.fecha DESC";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM equipos $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './gps.php';
		//main query to fetch the data
		$sql="SELECT equipos.id_equipo, equipos.id_marca, equipos.id_modelo, equipos.imei, equipos.ubicacion, equipos.fecha, equipos.origen, marca_gps.id_marca, modelo_gps.id_modelo, marca_gps.marca, modelo_gps.modelo FROM equipos JOIN marca_gps ON equipos.id_marca = marca_gps.id_marca JOIN modelo_gps ON equipos.id_modelo = modelo_gps.id_modelo $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>Imei</th>
					<th>Marca</th>
					<th>Modelo</th>
					<th>Ubicacion</th>
					<th>Placa</th>
					<th>Estado Placa</th>
					<th>Fecha</th>
					<?php if( $row_usu["equipos"] == "e") { ?>
					<th class='text-right'></th>
			  <?php } ?>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_equipo=$row['id_equipo'];
						$imei=$row['imei'];
						$marca=$row['marca'];
						$ubicacion=$row['ubicacion'];
						$modelo=$row['modelo'];
						$fecha=$row['fecha'];
						//$date_added= date('d/m/Y', strtotime($row['date_added']));
					//mysql_select_db($database_track,$track);
                    $query_placa = "SELECT placa, estado FROM movequipos WHERE id_equipo=$id_equipo ORDER BY fecha DESC";
                    $placa = mysqli_query($track, $query_placa) or die(mysqli_error());
                    $row_placa = mysqli_fetch_assoc($placa);
                    $numrows = mysqli_num_rows($placa);
					if (isset($row_placa['placa'])) {
					$placas=$row_placa['placa'];
					if ($row_placa['estado']=='a'){
						$est_placas='Activo';
					} elseif ($row_placa['estado']=='i'){
						$est_placas='Inactivo';
					} else {						
						$est_placas='';
					}
					} else {
					$placas="SIN";						
					$est_placas='SIN';					
					}
					?>
					<input type="hidden" value="<?php echo $imei; ?>" id="id_equipo<?php echo $id_equipo;?>">
					<!-- <input type="hidden" value="<?php echo $id_cliente;?>" id="id_cliente<?php echo $id_grupos;?>">
					<input type="hidden" value="<?php echo $nombre_grupo;?>" id="nombre_grupo<?php echo $id_grupos;?>"> -->
					
					<tr>
						<td><?php echo $imei; ?></td>
						<td><?php echo $marca; ?></td>
						<td><?php echo $modelo;?></td>
						<td><?php echo $ubicacion;?></td>
						<td>
						<?php if( $row_usu["vehiculos"] == "e") { ?><a href="edit_placa.php?placa=<?php echo $placas; ?>" class="" title='Editar cliente' >
			  <?php } ?><?php echo $placas;?>
			  <?php if( $row_usu["vehiculos"] == "e") { ?></a>
			  <?php } ?></td>
						<td><?php echo $est_placas;?></td>
						<td><?php echo $fecha;?></td>
						<?php if( $row_usu["equipos"] == "e") { ?>
						<td >
					<span class="pull-right">
					<!--  <a href="#" class="btn btn-default" title='Ver' onclick="obtener_datos('<?php echo $id_equipo;?>');" >  <i class="glyphicon glyphicon-eye-open"></i> </a> -->
					<a href="gps.php?id=<?php echo $id_equipo; ?>#popup" class="btn btn-default" title='Editar GPS' ><i class="glyphicon glyphicon-edit"></i> </a>
					<!--  <a href="#" class="btn btn-default" title='Historial' onclick="obtener_datos('<?php echo $id_equipo;?>');" >  <i class="glyphicon glyphicon-transfer"></i> </a> -->
					<!--  <a href="#popup" class='btn btn-default' title='Borrar cliente' onclick="eliminar('<?php echo $id_grupos; ?>')"><i class="glyphicon glyphicon-trash"></i> </a> -->
					<!--  <a href="#" class='btn btn-default' title='Borrar cliente' onclick="eliminar('<?php echo $id_grupos; ?>')"><i class="glyphicon glyphicon-trash"></i> </a> -->
					</span>
					</td>
			  <?php } ?>
					</tr>
					<?php
				}
				?>
				<tr>
					<td colspan=7><span class="pull-right">
					<?php
					 echo paginate($reload, $page, $total_pages, $adjacents);
					?></span></td>
				</tr>
			  </table>
			</div>
			<?php
		}
	}
?>