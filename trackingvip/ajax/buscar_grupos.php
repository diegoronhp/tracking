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
	
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('nombre');//Columnas de busqueda
		 $aColumns2 = array('grupos.nombre');//Columnas de busqueda
		 $sTable = "grupos";
		 $sWhere = "";
		 $sWhere2 = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
			$sWhere2 = "AND ";
			for ( $i=0 ; $i<count($aColumns2) ; $i++ )
			{
				$sWhere2 .= $aColumns2[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere2 = substr_replace( $sWhere2, "", -3 );
		}
		$sWhere.=" order by nombre";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './grupos.php';
		//main query to fetch the data
		$sql="SELECT grupos.id_grupos, grupos.nombre, grupos.id_cliente, clientes.id_cliente, clientes.nombre AS elnombre FROM  grupos INNER JOIN clientes WHERE grupos.id_cliente = clientes.id_cliente $sWhere2 LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		
				
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>Nombre</th>
					<th>Cliente </th>
					<!-- <th>Agregado</th> -->
					<?php if( $row_usu["grupos"] == "e") { ?>
					<th class='text-right'></th>
			  <?php } ?>
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$nombre_cliente=$row['nombre'];
						$nombre_grupo=$row['elnombre'];
						$id_grupos=$row['id_grupos'];
						//$date_added= date('d/m/Y', strtotime($row['date_added']));
						
					?>
					
					<input type="hidden" value="<?php echo $id_grupos; ?>" id="id_grupos<?php echo $id_grupos;?>">
					<input type="hidden" value="<?php echo $id_cliente;?>" id="id_cliente<?php echo $id_grupos;?>">
					<input type="hidden" value="<?php echo $nombre_grupo;?>" id="nombre_grupo<?php echo $id_grupos;?>">
					
					<tr>
						<td><?php echo $nombre_cliente; ?></td>
						<td><?php echo $nombre_grupo; ?></td>
						<!-- <td><?php echo $date_added;?></td> -->
					<?php if( $row_usu["grupos"] == "e") { ?>
					<td ><span class="pull-right">
					<a href="grupos.php?id=<?php echo $id_grupos; ?>#popup" class="btn btn-default" title='Editar grupo' ><i class="glyphicon glyphicon-edit"></i> </a>
					<!--  <a href="#" class='btn btn-default' title='Borrar cliente' onclick="eliminar('<?php echo $id_grupos; ?>')"><i class="glyphicon glyphicon-trash"></i> </a></span></td> -->
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