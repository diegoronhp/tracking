<?php

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
	/* if (isset($_GET['id_grupos'])){
		$id_grupos=intval($_GET['id_grupos']);
		$query=mysqli_query($con, "select grupos.id_grupos, grupos.nombre, clientes.nombre AS elnombre FROM  grupos INNER JOIN clientes WHERE grupos.id_cliente = clientes.id_cliente AND grupos.id_grupos='".$id_grupos."'");
		
		$count=mysqli_num_rows($query);
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM grupos WHERE id_grupos='".$id_grupos."'")){
			?>
			<div class="alert alert-success alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Aviso!</strong> Datos eliminados exitosamente.
			</div>
			<!-- inicio editar -->
			
			<!-- fin editar -->
			
			<?php 
		}else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> Lo siento algo ha salido mal intenta nuevamente.
			</div>
			<?php
			
		}
			
		} else {
			?>
			<div class="alert alert-danger alert-dismissible" role="alert">
			  <button type="button" class="close" data-dismiss="alert" aria-label="Close"><span aria-hidden="true">&times;</span></button>
			  <strong>Error!</strong> No se pudo eliminar éste  cliente. Existen facturas vinculadas a éste producto. 
			</div>
			<?php
		}		
		
	} */

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
		$sWhere.=" order by sim.linea DESC";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM sim $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './linea.php';
		//main query to fetch the data
		$sql="SELECT sim.id_sim, sim.imei_sim, sim.linea, sim.empresa_sim, sim.estado, sim.tipo, sim.nombre_plan, sim.valor_mensual FROM sim $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
						
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>Id Sim</th>
					<th><center>Imei</center></th>
					<th><center>Linea</center></th>
					<th><center>Tipo</center></th>
					<th><center>Empresa</center></th>
					<th><center>Nombre del Plan</center></th>
					<th><center>Valor Mensual</center></th>
					<th>Estado</th>
					<th>Placa</th>
					<th>Est. Placa</th>		    
		<?php if( $row_usu["lineas"] == "e") { ?>
					<th class='text-right'></th>
			  <?php } ?>					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_sim=$row['id_sim'];
						$imei_sim=$row['imei_sim'];
						$linea=$row['linea'];
						$empresa_sim=$row['empresa_sim'];
						$nombre_plan=$row['nombre_plan'];
						$valor_mensual=$row['valor_mensual'];
						$estado=$row['estado'];
						//$date_added= date('d/m/Y', strtotime($row['date_added']));
                    $query_placa = "SELECT placa, estado FROM movequipos WHERE id_sim=$id_sim ORDER BY estado ASC";
                    $placa = mysqli_query($track, $query_placa) or die(mysqli_error());
                    $row_placa = mysqli_fetch_assoc($placa);
                    $numrows = mysqli_num_rows($placa);
					$placas=$row_placa['placa'];
					if ($row_placa['estado']=='a'){
						$est_placas='Activo';
					} elseif ($row_placa['estado']=='i'){
						$est_placas='Inactivo';
					} else {						
						$est_placas='';
					}
					if ($row['tipo']=='1'){
						$tipo='Postpago';
					} elseif ($row['tipo']=='2'){
						$tipo='Prepago';
					}
						
					?>
					
					<input type="hidden" value="<?php echo $id_sim; ?>" id="id_sim<?php echo $id_sim;?>">
					<!-- <input type="hidden" value="<?php echo $id_cliente;?>" id="id_cliente<?php echo $id_grupos;?>">
					<input type="hidden" value="<?php echo $nombre_grupo;?>" id="nombre_grupo<?php echo $id_grupos;?>"> -->
					
					<tr>
						<td><?php echo $id_sim; ?></td>
						<td><?php echo $imei_sim; ?></td>
						<td><?php echo $linea; ?></td>
						<td><?php echo $tipo;?></td>
						<td><?php echo $empresa_sim;?></td>
						<td><?php echo $nombre_plan;?></td>
						<td><?php echo $valor_mensual;?></td>
						<td><?php echo $estado;?></td>
						<td><a href="edit_placa.php?placa=<?php echo $placas; ?>" class="" title='Editar placa' ><?php echo $placas;?></a></td>
						<td><?php echo $est_placas;?></td>
						<?php if( $row_usu["lineas"] == "e") { ?>
						<td >
					<span class="pull-right">
					<!--  <a href="#" class="btn btn-default" title='Ver' onclick="obtener_datos('<?php echo $id_sim;?>');" >  <i class="glyphicon glyphicon-eye-open"></i> </a> -->
					<a href="linea.php?id=<?php echo $id_sim; ?>#popew"  class="btn btn-default" title='Editar' onclick="obtener_datos('<?php echo $id_sim;?>');" ><i class="glyphicon glyphicon-edit"></i> </a>
					<!--  <a href="#" class="btn btn-default" title='Historial' onclick="obtener_datos('<?php echo $id_sim;?>');" >  <i class="glyphicon glyphicon-transfer"></i> </a>  -->
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