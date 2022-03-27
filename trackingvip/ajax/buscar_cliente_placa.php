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
		$per_page = 1; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		
		$count_query = mysqli_query($con, "SELECT count(*) AS numrows FROM $sTable  $sWhere");
		$row = mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './clienteplaca.php';
		//main query to fetch the data
		
		$sql="SELECT * FROM  $sTable $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		$eldato = $_SESSION['tipo'];	
		$_SESSION['placa'];
        $laplaca = $_SESSION['placa'];
		if ($_SESSION['new']=="nuevo") {
			$destino = "gpse.php";
		} elseif (isset($_SESSION['grupo'])) {
			$destino = "Connections/new_grupo.php";
		} else {
			$destino = "Connections/edit_placas.php";			
		}
			if( isset($_SESSION['tipo'])) {
				$destino ="Connections/edit_grupo.php";
			}
		
		
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
					
			<form class="form-horizontal" method="post" id="cliente_placa" name="cliente_placa" action="<?php echo $destino; ?>">
			        <input type="hidden" value="<?php echo $laplaca; ?>" id="placa" name="placa">
			        <input type="hidden" value="<?php echo $_SESSION['grupo']; ?>" id="grupo" name="grupo">					
				    <input type="hidden" value="movequipos" id="tabla" name="tabla">					
				    <input type="hidden" value="id_cliente" id="campo" name="campo">
			        <!-- <input type="hidden" value="id_cliente" id="campo" name="campo"> 7-1-17-->
			  <table class="table">
				<tr  class="info"><th>Nit</th>
					<th>DV</th>
					<th>Nombre</th>
					<th>Teléfono</th>
					<th>Email</th>
					<th>Dirección</th>
					<th>Ciudad</th>
					<th>Corte</th>
					<!-- <th>Agregado</th> -->
					<th class='text-right'></th>
					
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
					<?php if(!empty ($q)) { ?>
					<input type="hidden" value="<?php echo $id_cliente; ?>" id="id_cliente" name="id_cliente">
					<input type="hidden" value="<?php echo $nombre_cliente; ?>" id="cambio" name="cambio">
					<tr><td><?php echo $nit_cliente; ?></td>
						<td align="center"><?php echo $dv_cliente; ?></td>
						<td><?php echo $nombre_cliente; ?></td>
						<td><?php echo $telefono_cliente; ?></td>
						<td><?php echo $email_cliente;?></td>
						<td><?php echo $direccion_cliente;?></td>
						<td><?php echo $ciudad_cliente;?></td>
						<td align="center"><?php echo $dia_corte_cliente;?></td>
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