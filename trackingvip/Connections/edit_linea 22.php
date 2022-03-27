<?php
error_reporting(E_ALL);
ini_set('display_errors', '1');
require_once('tracking.php');
require_once('../config/login.php');

function GetSQLValueString($theValue, $theType, $theDefinedValue = "", $theNotDefinedValue = "") 
	{
		if (PHP_VERSION < 6) 
			{
				$theValue = get_magic_quotes_gpc() ? stripslashes($theValue) : $theValue;
			}
		//  $theValue = function_exists("mysqli_real_escape_string") ? mysqli_real_escape_string($track,$theValue) : mysqli_escape_string($track,$theValue);
	  switch ($theType) 
		{
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

$colname_movil = "-1";
if (isset($_SESSION['MM_Username'])) 
	{
		$colname_usu = $_SESSION['MM_Username'];
	}

$query_usu = sprintf("SELECT * FROM usuarios WHERE usuario = %s", GetSQLValueString($colname_usu, "text"));
$usu = mysqli_query($track, $query_usu) or die(mysqli_error());
$row_usu = mysqli_fetch_assoc($usu);
$totalRows_usu = mysqli_num_rows($usu);

mysqli_select_db($track, $database_track);
$query_sim = "SELECT * FROM sim";
$sim = mysqli_query($track, $query_sim) or die(mysqli_error());
$row_sim = mysqli_fetch_assoc($sim);
$totalRows_sim = mysqli_num_rows($sim);

if (empty($_POST['id_sim'])) 
	{
        $errors[] = "ID vac