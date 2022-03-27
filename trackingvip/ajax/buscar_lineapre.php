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
		 $aColumns = array('sim.linea');//Columnas de busqueda
		 $sTable = "sim";
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere = " AND (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ')';
		}
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 20; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT COUNT(id_sim) AS numrows FROM sim WHERE id_sim IN (SELECT id_sim FROM movequipos WHERE estado = 'a') AND tipo = '2' $sWhere GROUP BY id_sim");
		$row= mysqli_fetch_array($count_query);		
    	$row_cnt = mysqli_num_rows($count_query);
		$numrows = $row_cnt;
		$total_pages = ceil($numrows/$per_page);
		$reload = './lineapre.php';
		//main query to fetch the data
		$sql="SELECT sim.id_sim, sim.linea, movequipos.placa, (SELECT MAX(recarga.fecha) FROM recarga WHERE sim.id_sim = recarga.id_linea GROUP BY id_linea) as lamax, (SELECT recarga.valor FROM recarga WHERE sim.id_sim = recarga.id_linea AND fecha = lamax) as valor, (DATEDIFF( now(),(SELECT MAX(recarga.fecha) FROM recarga WHERE sim.id_sim = recarga.id_linea GROUP BY id_linea))) as dias FROM `sim` LEFT JOIN recarga ON sim.id_sim = recarga.id_linea LEFT JOIN movequipos ON movequipos.id_sim = sim.id_sim WHERE movequipos.estado = 'a' AND sim.tipo = '2' $sWhere GROUP BY id_sim ORDER BY dias DESC LIMIT $offset,$per_page";
		// $sql="SELECT id_linea, recarga.fecha as fechas, valor, (DATEDIFF( now(),recarga.fecha)) as dias, movequipos.placa, sim.linea FROM recarga LEFT JOIN movequipos ON movequipos.id_sim = recarga.id_linea LEFT JOIN sim ON sim.id_sim = recarga.id_linea WHERE movequipos.estado = 'a' AND (id_linea,recarga.fecha) IN (SELECT id_linea, MAX(recarga.fecha) FROM recarga GROUP BY id_linea) AND id_linea IN (SELECT id_sim FROM `movequipos` WHERE tipo = '2')$sWhere ORDER BY dias DESC LIMIT $offset,$per_page";
		
		//SELECT sim.linea, movequipos.placa, (SELECT MAX(recarga.fecha) FROM recarga WHERE sim.id_sim = recarga.id_linea GROUP BY id_linea) as lamax, (SELECT recarga.valor FROM recarga WHERE sim.id_sim = recarga.id_linea AND fecha = lamax) as valor, (DATEDIFF( now(),(SELECT MAX(recarga.fecha) FROM recarga WHERE sim.id_sim = recarga.id_linea GROUP BY id_linea))) as dias FROM sim LEFT JOIN movequipos ON sim.id_sim = movequipos.id_sim WHERE sim.tipo = '2' ORDER BY dias DESC;
		
		$query = mysqli_query($con, $sql) or die(mysqli_error($con));
		
				
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>Linea</th>
					<th>Placa</th>
					<th>Valor</th>
					<th>Fecha</th>
					<th>Dias</th>	    
		<?php if( $row_usu["lineaspre"] == "e") { ?>
			  <?php } ?>					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
				if( $row_usu["lineaspre"] == "e") {						
					$idlinea=$row['id_sim'];
					$lalinea=$row['linea'];
					$lineap='<a href="lineapre.php?id='.$idlinea.'#popew">'.$lalinea.'</a>';
				} else {
					$lineap=$lalinea;
				}			
						$placal=$row['placa'];
						$valor=$row['valor'];
						$fechal=$row['lamax'];
						$diasp=$row['dias'];
					?>
					<!-- <tr style="background-color: indianred; color: white"> -->
				  <?php if($row['dias'] > 49 && $row['dias'] < 55 ) { ?>
					<tr style="background-color: khaki">
			  <?php } elseif($row['dias'] > 54) { ?>
					<tr style="background-color: indianred; color: white">
			  <?php } else { ?>
					<tr>
			  <?php } ?>
						<td><?php echo $lineap; ?></td>
						<td><?php echo $placal; ?></td>
						<td><?php echo $valor;?></td>
						<td><?php echo $fechal;?></td>
						<td><?php echo $diasp;?></td>
						
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