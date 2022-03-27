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
	if (isset($_GET['id'])){
		$id_cliente=intval($_GET['id']);
		$query=mysqli_query($con, "select * from clientes where id_cliente='".$id_cliente."'");
		$count=mysqli_num_rows($query);
	}  
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('placa');//Columnas de busqueda
		 $sTable = "movequipos";
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
		$sWhere.=" order by placa";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM movequipos $sWhere");
		$row= mysqli_fetch_array($count_query);
		$numrows = $row['numrows'];
		$total_pages = ceil($numrows/$per_page);
		$reload = './vehiculos.php';
		//main query to fetch the data
		$sql="SELECT m.id_movequipos, m.id_equipo, m.id_cliente, m.estado, m.id_grupos, m.placa, m.valor_mensual, m.fecha, m.tipo_contrato, m.avl, m.ciudad, m.plataforma, m.id_sim, m.propietario, m.tel_propietario, m.referencia1, m.referencia2, m.referencia3, m.observaciones, m.fecha_modificado, c.id_cliente, c.nombre, e.id_equipo, e.imei, e.id_marca, e.id_modelo, s.id_sim, s.imei_sim, s.linea, s.empresa_sim, s.tipo, g.id_grupos FROM movequipos m JOIN clientes c ON m.id_cliente = c.id_cliente JOIN grupos g ON m.id_grupos = g.id_grupos JOIN equipos e ON m.id_equipo = e.id_equipo JOIN sim s ON m.id_sim = s.id_sim $sWhere LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql);
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th><center>Placa</center></th>
					<th><center>Cliente</center></th>
					<th><center>Avl</center></th>
					<th><center>Modelo</center></th>
					<th><center>Linea</center></th>
					<th><center>Imei Sim</center></th>
					<th><center>Operador</center></th>
					<th><center>Tipo</center></th>
					<th><center>Contrato</center></th>
					<th><center>Estado</center></th>
					<!-- <th>Agregado</th> -->
					<?php if( $row_usu["vehiculos"] == "e") { ?>
					<th class='text-right'></th>
			  <?php } ?>  					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
                        $placa=$row['placa'];
						$nombre_cliente=$row['nombre'];
						$elmodelo=$row['id_modelo'];
						$imeisim=$row['imei_sim'];
						$contrato=$row['tipo_contrato'];
						$empresa_sim=$row['empresa_sim'];
						//$telefono_cliente=$row['telefono'];
						//$email_cliente=$row['correo'];
						$propietario=$row['propietario'];
						$avl=$row['avl'];
						$plataforma=$row['plataforma'];
						$emsim=$row['empresa_sim'];
						$status_cliente=$row['estado'];
						$linea=$row['linea'];
						if ($status_cliente=="a"){$estado="Activo";}
						else {$estado="Inactivo";}
						//$date_added= date('d/m/Y', strtotime($row['date_added']));
                    $query_modelos = "SELECT id_modelo, modelo FROM modelo_gps WHERE id_modelo=$elmodelo";
                    $modelos = mysqli_query($track, $query_modelos) or die(mysqli_error());
                    $row_modelos = mysqli_fetch_assoc($modelos);
                    $numrows = mysqli_num_rows($modelos);
					$modelo=$row_modelos['modelo'];
					
					if ($row['tipo']=='1'){
						$tipo='Postpago';
					} elseif ($row['tipo']=='2'){
						$tipo='Prepago';
					}
					
					?>
								
					<tr>
						
						<td><?php echo $placa; ?></td>
						<td><?php echo $nombre_cliente; ?></td>
						<td><?php echo $avl;?></td>
						<td><?php echo $modelo;?></td>
						<td><?php echo $linea;?></td>
						<td><?php echo $imeisim;?></td>
						<td><?php echo $emsim; ?></td>
						<td><?php echo $tipo;?></td>
						<td><?php echo $contrato; ?></td>
						<td><?php echo $estado." ".$plataforma;?></td>
						<!-- <td><?php echo $date_added;?></td> -->
					<td >
					<?php if( $row_usu["vehiculos"] == "e") { ?>
					<span class="pull-right">
					<a href="edit_placa.php?placa=<?php echo $placa; ?>" class="btn btn-default" title='Editar cliente' ><i class="glyphicon glyphicon-edit"></i></a>
					<!-- <a href="#" class='btn btn-default' title='Borrar cliente' onclick="eliminar('<?php echo $id_cliente; ?>')"><i class="glyphicon glyphicon-trash"></i> </a> -->
					</span>
			  <?php } ?>        </td>
						
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