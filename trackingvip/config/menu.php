 <?php 

// mysql_select_db($database_track,$track);
$query_lineap = "SELECT MAX(DATEDIFF( now(),recarga.fecha)) as dias FROM recarga LEFT JOIN movequipos ON movequipos.id_sim = recarga.id_linea LEFT JOIN sim ON sim.id_sim = recarga.id_linea WHERE movequipos.estado = 'a' AND id_linea IN (SELECT id_sim FROM `movequipos` WHERE estado = 'a') ORDER BY dias DESC";
$lineap = mysqli_query($track, $query_lineap) or die(mysql_error());
$row_lineap = mysqli_fetch_assoc($lineap);

if($row_lineap["dias"]>55){
	$active_lineapre="parpadea textpar";
	$elcolor="textpar";
} else {
	$active_lineapre="";
}
?>
		

<style type="text/css">
		
   .textpar {
  color:red;
	}
	.parpadea {

	  animation-name: parpadeo;
	  animation-duration: 1.5s;
	  animation-timing-function: linear;
	  animation-iteration-count: infinite;

	  -webkit-animation-name:parpadeo;
	  -webkit-animation-duration: 1.5s;
	  -webkit-animation-timing-function: linear;
	  -webkit-animation-iteration-count: infinite;
	}

	@-moz-keyframes parpadeo{  
	  0% { opacity: 1.0; }
	  50% { opacity: 0.0; }
	  100% { opacity: 1.0; }
	}

	@-webkit-keyframes parpadeo {  
	  0% { opacity: 1.0; }
	  50% { opacity: 0.0; }
	   100% { opacity: 1.0; }
	}

	@keyframes parpadeo {  
	  0% { opacity: 1.0; }
	   50% { opacity: 0.0; }
	  100% { opacity: 1.0; }
	}

	
	
 .navbar-default {
  background-color: #3498db;
  border-color: #2980b9;
}
.navbar-default .navbar-brand {
  color: #ecf0f1;
}
.navbar-default .navbar-brand:hover,
.navbar-default .navbar-brand:focus {
  color: #ecdbff;
}
.navbar-default .navbar-text {
  color: #ecf0f1;
}
.navbar-default .navbar-nav > li > a {
  color: #ecf0f1;
}
.navbar-default .navbar-nav > li > a:hover,
.navbar-default .navbar-nav > li > a:focus {
  color: #ecdbff;
}
.navbar-default .navbar-nav > .active > a,
.navbar-default .navbar-nav > .active > a:hover,
.navbar-default .navbar-nav > .active > a:focus {
  color: #ecdbff;
  background-color: #2980b9;
}
.navbar-default .navbar-nav > .open > a,
.navbar-default .navbar-nav > .open > a:hover,
.navbar-default .navbar-nav > .open > a:focus {
  color: #ecdbff;
  background-color: #2980b9;
}
.navbar-default .navbar-toggle {
  border-color: #2980b9;
}
.navbar-default .navbar-toggle:hover,
.navbar-default .navbar-toggle:focus {
  background-color: #2980b9;
}
.navbar-default .navbar-toggle .icon-bar {
  background-color: #ecf0f1;
}
.navbar-default .navbar-collapse,
.navbar-default .navbar-form {
  border-color: #ecf0f1;
}
.navbar-default .navbar-link {
  color: #ecf0f1;
}
.navbar-default .navbar-link:hover {
  color: #ecdbff;
}

@media (max-width: 767px) {
  .navbar-default .navbar-nav .open .dropdown-menu > li > a {
    color: #ecf0f1;
  }
  .navbar-default .navbar-nav .open .dropdown-menu > li > a:hover,
  .navbar-default .navbar-nav .open .dropdown-menu > li > a:focus {
    color: #ecdbff;
  }
  .navbar-default .navbar-nav .open .dropdown-menu > .active > a,
  .navbar-default .navbar-nav .open .dropdown-menu > .active > a:hover,
  .navbar-default .navbar-nav .open .dropdown-menu > .active > a:focus {
    color: #ecdbff;
    background-color: #2980b9;
  }
	

</style>

 <nav class="navbar navbar-default ">
  <div class="container-fluid">
    <!-- Brand and toggle get grouped for better mobile display -->
    <div class="navbar-header">
      <button type="button" class="navbar-toggle collapsed" data-toggle="collapse" data-target="#bs-example-navbar-collapse-1" aria-expanded="false">
        <span class="sr-only">Toggle navigation</span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
        <span class="icon-bar"></span>
      </button>
      <a class="navbar-brand" href="#">TRACKING VIP</a>
    </div>

    <!-- Collect the nav links, forms, and other content for toggling -->
    <div class="collapse navbar-collapse" id="bs-example-navbar-collapse-1">
      <ul class="nav navbar-nav">
      <?php if( $row_usu["facturacion"] != "n") { ?>
       <li class="dropdown"><a class="dropdown-toggle" data-toggle="dropdown" href="#"><i class='glyphicon glyphicon-list-alt'></i> Facturas <span class="caret"></span></a>
        <ul class="dropdown-menu">
         <?php if( $row_usu["facturacion"] == "e") { ?>
          <li><a href="fact.php">Mensualidad</a></li>
			  <?php } ?>
         <?php if( $row_usu["facturacion"] == "e") { ?>
          <li><a href="clientefactura.php">Nueva</a></li>
			  <?php } ?>
          <li><a href="consultafactura.php">Consultas</a></li>
          <li><a href="estado_ctas.php">Estado Cuenta</a></li>
          <!-- <li><a href="#">Page 1-3</a></li> -->
        </ul></li>
			  <?php } ?>
        <!-- <li class="<?php echo $active_fact;?>"><a href="fact.php"><i class='glyphicon glyphicon-list-alt'></i> Facturas <span class="sr-only">(current)</span></a></li> -->
        <?php if( $row_usu["equipos"] != "n") { ?>
        <li class="<?php echo $active_gps;?>"><a href="gps.php"><i class='glyphicon glyphicon-cd'></i> GPS</a></li>
			  <?php } ?>
        <?php if( $row_usu["cliente"] != "n") { ?>
		<li class="<?php echo $active_clientes;?>"><a href="clientes.php"><i class='glyphicon glyphicon-user'></i> Clientes</a></li>
			  <?php } ?>
        <?php if( $row_usu["grupos"] != "n") { ?>
		<li class="<?php echo $active_grupos;?>"><a href="grupos.php"><i class='glyphicon glyphicon-screenshot'></i> Grupos</a></li>
			  <?php } ?>
        <?php if( $row_usu["vehiculos"] != "n") { ?>
		<li class="<?php echo $active_vehiculos;?>"><a href="vehiculos.php"><i class='glyphicon glyphicon-bed'></i> Vehiculos</a></li>
			  <?php } ?>
        <?php if( $row_usu["lineas"] != "n") { ?>
		<li class="<?php echo $active_linea;?>"><a href="linea.php"><i class='glyphicon glyphicon-earphone'></i> Lineas</a></li>
			  <?php } ?>
        <?php if( $row_usu["lineaspre"] != "n") { ?>
		<li class="<?php echo $active_lineapre;?> <?php echo $active_lp;?>"><a href="lineapre.php" class="<?php echo $elcolor;?>"><i class='glyphicon glyphicon-usd'></i> Lineas Prepago</a></li>
			  <?php } ?>
		<?php if( $row_usu["usuarios"] != "n") { ?>
		<li class="<?php echo $active_usuarios;?>"><a href="usuario.php"><i  class='glyphicon glyphicon-user'></i> Usuarios</a></li>
		<?php } ?>
		<!-- <li class="<?php if(isset($active_perfil)){echo $active_perfil;}?>"><a href="perfil.php"><i  class='glyphicon glyphicon-cog'></i> Configuraci&oacute;n</a></li> -->
       </ul>
      <ul class="nav navbar-nav navbar-right">
       <!-- <li><a href="" target='_blank'><i class='glyphicon glyphicon-envelope'></i> Soporte</a></li> -->
		<li><a href="<?php echo $logoutAction ?>"><i class='glyphicon glyphicon-off'> <?php echo $row_usu["nombre"]; ?></i>  -  Salir</a></li>
      </ul>
    </div><!-- /.navbar-collapse -->
  </div><!-- /.container-fluid -->
</nav>