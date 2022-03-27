<?php
	
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

    $_SESSION['q1']; 
    $_SESSION['q2']; 

    $month = $q2.'-'.$q1;
    //$aux = date('Y-m-d', strtotime("{$month} + 1 month"));
    $aux = date('Y-m-d', strtotime("{$month}"));
    $last_day = date('Y-m-d', strtotime("{$aux} - 1 day"));

    
	if($action == 'ajax'){
		// escaping, additionally removing everything that could be (html/javascript-) code
         $q = mysqli_real_escape_string($con,(strip_tags($_REQUEST['q'], ENT_QUOTES)));
		 $aColumns = array('clientes.nombre');//Columnas de busqueda
		 $sTable = "clientes";
		 $sWhere = "";
		if ( $_GET['q'] != "" )
		{
			$sWhere2 = "WHERE (";
			for ( $i=0 ; $i<count($aColumns) ; $i++ )
			{
				$sWhere .= $aColumns[$i]." LIKE '%".$q."%' OR ";
			}
			$sWhere = substr_replace( $sWhere, "", -3 );
			$sWhere .= ' AND';
		}
				
        $q1=$_SESSION['q1'];
        $q2=$_SESSION['q2'];
		$periodo=$q2.$q1;
		$sWhere2.="order by dia_corte DESC";
		include 'pagination.php'; //include pagination file
		//pagination variables
		$page = (isset($_REQUEST['page']) && !empty($_REQUEST['page']))?$_REQUEST['page']:1;
		$per_page = 10; //how much records you want to show
		$adjacents  = 4; //gap between pages after number of adjacents
		$offset = ($page - 1) * $per_page;
		//Count the total number of row in your table*/
		$count_query   = mysqli_query($con, "SELECT count(*) AS numrows FROM movequipos WHERE estado='a' AND CONCAT(movequipos.id_cliente,movequipos.id_grupos) NOT IN(SELECT CONCAT(id_cliente,id_grupos) AS facturado FROM facturacion WHERE periodo=$periodo AND motivo='mensualidad') GROUP BY id_cliente");
		$row= mysqli_fetch_array($count_query);
        $numrows = mysqli_num_rows($count_query);
		$total_pages = ceil($numrows/$per_page);
		$reload = './facturacion.php';
		//main query to fetch the data
		$sql="SELECT COUNT(*) AS cantidad, movequipos.id_cliente, SUM(movequipos.valor_mensual) AS total, movequipos.estado, movequipos.id_grupos, movequipos.fecha, clientes.id_cliente, clientes.dia_corte, clientes.nombre, clientes.estado, grupos.nombre AS elgrupo, clientes.nit, clientes.dv FROM movequipos JOIN clientes ON movequipos.id_cliente = clientes.id_cliente JOIN grupos ON movequipos.id_grupos = grupos.id_grupos WHERE $sWhere movequipos.estado='a' AND  movequipos.fecha < CONCAT($q2,'-',$q1,'-',clientes.dia_corte) AND clientes.estado='a' AND CONCAT(movequipos.id_cliente,movequipos.id_grupos) NOT IN(SELECT CONCAT(id_cliente,id_grupos) AS facturado FROM facturacion WHERE periodo=$periodo AND motivo='mensualidad' AND facturacion.estado = 'a') GROUP BY movequipos.id_cliente, movequipos.id_grupos order by dia_corte, clientes.nombre ASC LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql)
			or die("Error: ".mysqli_error($con));
		
		
		
		//main query to fetch the data
		/*$sql="SELECT COUNT(*) AS cantidad, movequipos.id_cliente, SUM(movequipos.valor_mensual) AS total, movequipos.estado, movequipos.id_grupos, movequipos.fecha, clientes.id_cliente, clientes.nombre, grupos.nombre AS elgrupo, clientes.nit, clientes.dv FROM movequipos JOIN clientes ON movequipos.id_cliente = clientes.id_cliente JOIN grupos ON movequipos.id_grupos = grupos.id_grupos WHERE $sWhere movequipos.estado='a' AND movequipos.fecha < '$last_day' GROUP BY movequipos.id_cliente, movequipos.id_grupos LIMIT $offset,$per_page";
		$query = mysqli_query($con, $sql)
			or die("Error: ".mysqli_error($con));
		*/
		
		
				
		//loop through fetched data
		if ($numrows>0){
			
			?>
			<div class="table-responsive">
			  <table class="table">
				<tr  class="info">
					<th>Cliente</th>
					<th>Grupo</th>
					<th class="text-center">Dia Corte</th>
					<th class="text-center">Cantidad</th>
					<th class="text-center">Valor</th>
					<th class='text-right'>Acciones</th>
					
				</tr>
				<?php
				while ($row=mysqli_fetch_array($query)){
						$nombre=$row['nombre'];
						$grupo=$row['elgrupo'];
						$cantidad=$row['cantidad'];
					    $diacorte=$row['dia_corte'];
					    $total=$row['total'];
					    $idcliente=$row['id_cliente'];
					    $idgrupo=$row['id_grupos'];
						//$fecha=$row['estado'];
						//$date_added= date('d/m/Y', strtotime($row['date_added']));
						
					?>
					
					<input type="hidden" value="<?php echo $imei; ?>" id="id_equipo<?php echo $id_equipo;?>">
					<!-- <input type="hidden" value="<?php echo $id_cliente;?>" id="id_cliente<?php echo $id_grupos;?>">
					<input type="hidden" value="<?php echo $nombre_grupo;?>" id="nombre_grupo<?php echo $id_grupos;?>"> -->
					
					<tr>
						<td><?php echo $nombre; ?></td>
						<td><?php echo $grupo; ?></td>
						<td class="text-center"><?php echo $diacorte; ?></td>
						<td class="text-center"><?php echo $cantidad;?></td>
						<td class="text-center"><?php echo number_format($total);?></td>
						<td >
					<span class="pull-right">
					<a href="factura.php?fecha=<?php echo $q2."-".$q1."-".$diacorte ; ?>&id_cliente=<?php echo $idcliente; ?>&id_grupo=<?php echo $idgrupo; ?>" class="btn btn-default" title='Facturar' ><i class="glyphicon glyphicon-list-alt"></i> </a>
					<a href="informes/detalle_moviles.php?fecha=<?php echo $q2."-".$q1."-".$diacorte ; ?>&id_cliente=<?php echo $idcliente; ?>&id_grupo=<?php echo $idgrupo; ?>" class="btn btn-default" title='Excel' >  <i class="glyphicon glyphicon-export"></i> </a>
					<!--  <a href="#" class="btn btn-default" title='Historial' onclick="obtener_datos('<?php echo $id_equipo;?>');" >  <i class="glyphicon glyphicon-transfer"></i> </a> -->
					<!--  <a href="#popup" class='btn btn-default' title='Borrar cliente' onclick="eliminar('<?php echo $id_grupos; ?>')"><i class="glyphicon glyphicon-trash"></i> </a> -->
					<!--  <a href="#" class='btn btn-default' title='Borrar cliente' onclick="eliminar('<?php echo $id_grupos; ?>')"><i class="glyphicon glyphicon-trash"></i> </a> -->
					</span>
					</td>
						
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