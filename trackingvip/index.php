<?php
require_once('Connections/tracking.php'); 


function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
{
  if (PHP_VERSION < 6) {
    $theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
  }
  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($track,$theValue) : mysqli_escape_string($track,$theValue);
  switch ($theType) {
    case "text":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;    
    case "long":
    case "int":
      $theValue = ($theValue != "") ? intval($theValue) : "NULL";
      break;
    case "double":
      $theValue = ($theValue != "") ? doubleval($theValue) : "NULL";
      break;
    case "date":
      $theValue = ($theValue != "") ? "'" . $theValue . "'" : "NULL";
      break;
    case "defined":
      $theValue = ($theValue != "") ? $theDefinedValue : $theNotDefinedValue;
      break;
  }
  return $theValue;
}

// *** Validate request to login to this site.
if (!isset($_SESSION)) {
  session_start();
}

/* $loginFormAction = $_SERVER['PHP_SELF'];
if (isset($_GET['accesscheck'])) {
  $_SESSION['PrevUrl'] = $_GET['accesscheck'];
} */
if (isset($_POST['usuario'])) {
    
require('Connections/tracking.php'); 
    
  $loginUsername=mysqli_real_escape_string($track,$_POST['usuario']);
  $password=mysqli_real_escape_string($track,$_POST['clave']);
  $MM_fldUserAuthorization = "estado";
  $MM_redirectLoginSuccess = "clientes.php";
  $MM_redirectLoginFailed = "index.php";
  $MM_redirecttoReferrer = false;
 // mysqli_select_db($database_track, $track);
  	
  $LoginRS_query="SELECT * FROM usuarios WHERE usuario='$loginUsername' AND clave='$password'"; 
   
			$userok = "";
   
			if($resulta = $track->query($LoginRS_query)) {
				while($row_LoginRS_query = $resulta->fetch_array()) {
 
					$userok = $row_LoginRS_query["usuario"];
					$passok = $row_LoginRS_query["clave"];
				}
				$resulta->close();
			}
			$track->close();
 
			if(isset($loginUsername) && isset($password)) {
 
				if($loginUsername == $userok && $password == $passok) {
					$_SESSION["logueado"] = TRUE;
					$_SESSION['MM_Username'] = $userok;
					Header("Location: clientes.php");
 
				}
				else {
					
				Header("Location: index.php?error=login");
		
				}
 
				
				// fin isset
			}

		} else {
?>
<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">

<title>TRACKING VIP</title>
<script language="JavaScript" src="src/js/jquery-1.5.1.min.js"></script>
<script language="JavaScript" src="js/jquery-ui-1.8.13.custom.min.js"></script>
<link type="text/css" href="css/ui-lightness/jquery-ui-1.8.13.custom.css" rel="stylesheet" />
<link rel="stylesheet" href="css/custom.css">
<link rel="stylesheet" href="css/login.css">
<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.6/css/bootstrap.min.css" integrity="sha384-1q8mTJOASx8j1Au+a5WDVnPi2lkFfwwEAa8hDDdjZlpLegxhjVME1fgjWPGmkzs7" crossorigin="anonymous">

</head>

<body>
<div class="container">
        <div class="card card-container" style="text-align: center">
            <img src="img/trackingvip.png" />
            <p id="profile-name" class="profile-name-card"></p>
            <form method="post" accept-charset="utf-8" action="index.php" name="conectar" id="conectar" autocomplete="off" role="form" class="form-signin">
			<?php
				// show potential errors / feedback (from login object)
				if (isset($login)) {
					if ($login->errors) {
						?>
						<div class="alert alert-danger alert-dismissible" role="alert">
						    <strong>Error!</strong> 
						
						<?php 
						foreach ($login->errors as $error) {
							echo $error;
						}
						?>
						</div>
						<?php
					}
					if ($login->messages) {
						?>
						<div class="alert alert-success alert-dismissible" role="alert">
						    <strong>Aviso!</strong>
						<?php
						foreach ($login->messages as $message) {
							echo $message;
						}
						?>
						</div> 
						<?php 
					}
				}
				?>
                <span id="reauth-email" class="reauth-email"></span>
                <input class="form-control" placeholder="Usuario" name="usuario" id="usuario" type="text" value="" autofocus="" required>
                <input class="form-control" id="clave" placeholder="Contraseña" name="clave" type="password" value="" autocomplete="off" required>
                <button type="submit" class="btn btn-lg btn-success btn-block btn-signin" name="ingresar" id="ingresar">Iniciar Sesión</button>
            </form><!-- /form -->
            
        </div><!-- /card-container -->
    </div><!-- /container -->





</body>
</html>
<?php
 
}
?>