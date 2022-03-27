<?php

	
	//include('is_logged.php');//Archivo verifica que el usario que intenta acceder a la URL esta logueado
	/* Connect To Database*/
	require_once ("../config/db.php");//Contiene las variables de configuracion para conectar a la base de datos
	require_once ("../Connections/tracking.php");//Contiene funcion que conecta a la base de datos
    require_once('../config/login.php');
	header('Content-Type: text/html; charset=ISO-8859-1');
  
	
    $con=@mysqli_connect($hostname_track, $username_track, $password_track, $database_track);
    if(!$con){
        die("imposible conectarse: ".mysqli_error($con));
    }
    if (@mysqli_connect_errno()) {
        die("Conexión falló: ".mysqli_connect_errno()." : ". mysqli_connect_error());
    }

	$action = (isset($_REQUEST['action'])&& $_REQUEST['action'] !=NULL)?$_REQUEST['action']:'';
	if (isset($_GET['id'])){
		$id_cliente=intval($_GET['id']);
		$query=mysqli_query($con, "select * from clientes where id_cliente='".$id_cliente."'");
		$count=mysqli_num_rows($query);
		if ($count==0){
			if ($delete1=mysqli_query($con,"DELETE FROM clientes WHERE id_cliente='".$id_cliente."'")){
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
		
		
		
	}  
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('nombre');//Columnas de busqueda
		 $sTable = "clientes";
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
		$sWhere.=" order by nombre";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 10; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './clientes.php';
		//main query to fetch the data
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>Nit</th>
					<th>DV</th>
					<th>Nombre</th>
					<th>Telefono</th>
					<th>Email</th>
					<th>Direccion</th>
					<th>Ciudad</th>
					<th>Estado</th>
					<th>Obs</th>
					<th>Corte</th>
					<!-- <th>Agregado</th> -->
					<?php if( $row_usu["cliente"] == "e") { ?>
					<th class='text-right'></th>
			  <?php } ?>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$id_cliente=$row['id_cliente'];
						$nit_cliente=$row['nit'];
						$dv_cliente=$row['dv'];
						$nombre_cliente=$row['nombre'];
						$telefono_cliente=$row['telefono'];
						$email_cliente=$row['correo'];
						$direccion_cliente=$row['direccion'];
						$ciudad_cliente=$row['ciudad'];
						$status_cliente=$row['estado'];
						$observaciones=$row['observaciones'];
						$dia_corte_cliente=$row['dia_corte'];
						if ($status_cliente=="a"){$estado="Activo";}
						else {$estado="Inactivo";}
						//$date_added= date('d/m/Y', strtotime($row['date_added']));
						
					?>
					
					<input type="hidden" value="<?php echo $nit_cliente; ?>" id="nit_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $dv_cliente;?>" id="dv_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $nombre_cliente;?>" id="nombre_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $telefono_cliente;?>" id="telefono_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $email_cliente;?>" id="email_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $direccion_cliente;?>" id="direccion_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $ciudad_cliente;?>" id="ciudad_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $status_cliente;?>" id="status_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $observaciones_cliente;?>" id="observaciones_cliente<?php echo $id_cliente;?>">
					<input type="hidden" value="<?php echo $dia_corte_cliente;?>" id="dia_corte_cliente<?php echo $id_cliente;?>">
					
					<tr>
						
						<td><?php echo $nit_cliente; ?></td>
						<td align="center"><?php echo $dv_cliente; ?></td>
						<td><?php echo $nombre_cliente; ?></td>
						<td><?php echo $telefono_cliente; ?></td>
						<td><?php echo $email_cliente;?></td>
						<td><?php echo $direccion_cliente;?></td>
						<td><?php echo $ciudad_cliente;?></td>
						<td><?php echo $estado;?></td>
						<td><?php echo $observaciones;?></td>
						<td align="center"><?php echo $dia_corte_cliente;?></td>
						<!-- <td><?php echo $date_added;?></td> -->
						<?php if( $row_usu["cliente"] == "e") { ?>
					<td ><span class="pull-right">
					<a href="clientes.php?id=<?php echo $id_cliente; ?>#popup" class="btn btn-default" title='Editar cliente' onclick="obtener_datos('<?php echo $id_cliente;?>');" ><i class="glyphicon glyphicon-edit"></i></a>
					<!-- <a href="#" class='btn btn-default' title='Borrar cliente' onclick="eliminar('<?php echo $id_cliente; ?>')"><i class="glyphicon glyphicon-trash"></i> </a> -->
					</span></td>
			  <?php } ?>
						
					</tr>	
						
						
					
					<?php
				}
				?>
				<tr>
					<td colspan=10><span class="pull-right">
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