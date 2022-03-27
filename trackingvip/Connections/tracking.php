<?php
# FileName="Connection_php_mysql.htm"
# Type="MYSQL"
# HTTP="true"
$hostname_track = "localhost";
$database_track = "tracking_tracking";
$username_track = "tracking_track1";
$password_track = "tracking@1";
/* $track = mysqli_connect($hostname_track, $username_track, $password_track, $database_track) or trigger_error(mysql_error(),E_USER_ERROR); */


$track = new mysqli($hostname_track, $username_track, $password_track, $database_track);
if ($track -> connect_errno) {
die( "Fallo la conexi«Ñn a MySQL: (" . $mysqli -> mysqli_connect_errno() 
. ") " . $mysqli -> mysqli_connect_error());
}


/*define('DB_HOST', 'localhost');//DB_HOST:  generalmente suele ser "127.0.0.1"
define('DB_USER', 'tucontac_track1');//Usuario de tu base de datos
define('DB_PASS', 'tracking@1');//ContraseÃ±a del usuario de la base de datos
define('DB_NAME', 'tucontac_tracking');//Nombre de la base de datos */


/*$username_moviles = "tucontac";
$password_moviles = "ab2b33z32KBk";*/
?>