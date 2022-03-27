<?php

		require_once("dompdf/dompdf_config.inc.php");



$hostname_track = "localhost";
$database_track = "tucontac_tracking";
$username_track = "tucontac_track1";
$password_track = "tracking@1";
$track = mysql_pconnect($hostname_track, $username_track, $password_track) or trigger_error(mysql_error(),E_USER_ERROR);
session_start();



function basico($numero) {
$valor = array('uno','dos','tres','cuatro','cinco','seis','siete','ocho','nueve','diez','once','doce','trece','catorce','quince','dieciseis','diecisiete','dieciocho','diecinueve','veinte','veintiuno','veintidos','veintitres','veinticuatro','veinticinco','veintiseis','veintisiete','veintiocho','veintinueve');
return $valor[$numero - 1];
}

function decenas($n) {
$decenas = array (30=>'treinta',40=>'cuarenta',50=>'cincuenta',60=>'sesenta',
70=>'setenta',80=>'ochenta',90=>'noventa');
if( $n <= 29) return basico($n);
$x = $n % 10;
if ( $x == 0 ) {
return $decenas[$n];
} else return $decenas[$n - $x].' y '. basico($x);
}

function centenas($n) {
$cientos = array (100 =>'cien',200 =>'doscientos',300=>'trecientos',
400=>'cuatrocientos', 500=>'quinientos',600=>'seiscientos',
700=>'setecientos',800=>'ochocientos', 900 =>'novecientos');
if( $n >= 100) {
if ( $n % 100 == 0 ) {
return $cientos[$n];
} else {
$u = (int) substr($n,0,1);
$d = (int) substr($n,1,2);
return (($u == 1)?'ciento':$cientos[$u*100]).' '.decenas($d);
}
} else return decenas($n);
}

function miles($n) {
if($n > 999) {
if( $n == 1000) {return 'mil';}
else {
$l = strlen($n);
$c = (int)substr($n,0,$l-3);
$x = (int)substr($n,-3);
if($c == 1) {$cadena = 'mil '.centenas($x);}
else if($x != 0) {$cadena = centenas($c).' mil '.centenas($x);}
else $cadena = centenas($c). ' mil';
return $cadena;
}
} else return centenas($n);
}

function millones($n) {
if($n == 1000000) {return 'un millon';}
else {
$l = strlen($n);
$c = (int)substr($n,0,$l-6);
$x = (int)substr($n,-6);
if($c == 1) {
$cadena = ' millon ';
} else {
$cadena = ' millones ';
}
return miles($c).$cadena.(($x > 0)?miles($x):'');
}
}
function convertir($n) {
switch (true) {
case ( $n >= 1 && $n <= 29) : return basico($n); break;
case ( $n >= 30 && $n < 100) : return decenas($n); break;
case ( $n >= 100 && $n < 1000) : return centenas($n); break;
case ($n >= 1000 && $n <= 999999): return miles($n); break;
case ($n >= 1000000): return millones($n);
}
}




$numero=$_GET['numero'];
$elnumero="'".$numero."'";

mysql_select_db($database_track, $track);
$query_consultafact = "SELECT *, clientes.nombre FROM facturacion JOIN clientes ON facturacion.id_cliente = clientes.id_cliente JOIN grupos ON facturacion.id_grupos = grupos.id_grupos WHERE facturacion.numero = $elnumero";
$consultafact = mysql_query($query_consultafact, $track) or die(mysql_error());
$row_consultafact = mysql_fetch_assoc($consultafact);

$date = strtotime($row_consultafact["fecha_fact"]);
$afact = date("Y", $date); // Year (2003)
$mfact = date("m", $date); // Month (12)
$dfact = date("d", $date); // day (14)

$datev = strtotime($row_consultafact["vencimiento"]);
$aven = date("Y", $datev); // Year (2003)
$mven = date("m", $datev); // Month (12)
$dven = date("d", $datev); // day (14)

$impresion="Factura ".$row_consultafact["numero"].".pdf";
$eltotal=$row_consultafact["total"];

$retencion=$row_consultafact["conretencion"];
if($retencion=='n'){
	$retefuente=0;
} else {
	$retefuente=$row_consultafact["retefuente"];
}
/* $eltotal=$row_consultafact["total"]-$row_consultafact["retefuente"]-$row_consultafact["reteica"]; */
$eltotal=$row_consultafact["total"];
$reteica=$row_consultafact["reteica"]; 
$iva=$row_consultafact["coniva"];
if($iva=='n'){
	$iva=0;
	$eltotal=$row_consultafact["total"];
} else {
	$iva=$row_consultafact["iva"];
} 
/*if($row_consultafact["coniva"]='n'){
	$iva='';
} 
if($row_consultafact["coniva"]='s'){
	$iva=number_format($row_consultafact["iva"]);
}
if($row_consultafact["conretencion"]='n'){
	$retencion='';
}
if($row_consultafact["conretencion"]='s'){
	$retencion=number_format($row_consultafact["retencion"]);
}
*/

$codigoHTML='

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">

<title>Documento sin título</title>
<style type="text/css">
  @page {
            margin-bottom: 0px;
        }
</style>
</head>
<body><br><br><br>
<table width="500";>
  <tbody>
    <tr>
      <td width="45" height="52"></td>
      <td colspan="5" max-width="450" valign="bottom" align="right"><div style="text-align: center; font-size: 6; max-width: 170px; float: left; margin-left: 220 px">AUTORIZACI&Oacute;N NUMERACI&Oacute;N <br>DE FACTURACI&Oacute;N<br>FORMULARIO 18762005187313<br>FECHA 10/10/2017<br>AUTORIZA DESDE TV 7001 HASTA TV 10499</div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4">'.$row_consultafact["nombre"].'</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td width="50">&nbsp;</td>
      <td width="266">'.$row_consultafact["nit"].$row_consultafact["dv"].'</td>
      <td colspan="2" width="60">'.$dfact.'&nbsp;&nbsp;&nbsp;&nbsp;'.$mfact.'&nbsp;&nbsp;&nbsp;&nbsp;'.$afact.'</td>
      <td colspan="2" width="114">'.$dven.'&nbsp;&nbsp;&nbsp;&nbsp;'.$mven.'&nbsp;&nbsp;&nbsp;&nbsp;'.$aven.'</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td>'.$row_consultafact["direccion"].'</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
	  </tr>
    <tr>
      <td>&nbsp;</td>
      <td height="29" valign="top">'.$row_consultafact["telefono"].'</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
	  </tr>
    <tr>
      <td>&nbsp;</td>
      <td height="1" valign="top">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
	  </tr>
	  <tr>
      <td>&nbsp;</td>
      <td colspan="5" height="310" valign="top">
<table border="0" style="table-layout:fixed; font-size: 9;">
  <tbody>';
/*  style="border-width: 1px;border: solid; border-color: #00FF00;"*/
if ($row_consultafact["cantidadc"] > 0){
$codigoHTML.='
    <tr>
      <td colspan="2" valign="top" width="325">'.$row_consultafact["descripcionc"].'<br>'.$row_consultafact["placasc"].'<br><br>
	  </td>
      <td valign="top" width="35">'.$row_consultafact["cantidadc"].'</td>
      <td valign="top" width="40" align="center">'.number_format($row_consultafact["valor_unic"]).'</td>
      <td valign="top" width="75" align="right">'.number_format($row_consultafact["subtotalc"]).'</td>
    </tr>';    
} 
if ($row_consultafact["cantidada"] > 0){
$codigoHTML.='
    <tr>
      <td colspan="2" valign="top" width="325">'.$row_consultafact["descripciona"].'<br>'.$row_consultafact["placasa"].'<br><br>
	  </td>
      <td valign="top" width="35">'.$row_consultafact["cantidada"].'</td>
      <td valign="top" width="40" align="center">'.number_format($row_consultafact["valor_unia"]).'</td>
      <td valign="top" width="75" align="right">'.number_format($row_consultafact["subtotala"]).'</td>
    </tr>';
}
if ($row_consultafact["cantidad1"] > 0){
$codigoHTML.='
    <tr>
      <td colspan="2" valign="top" width="325">'.$row_consultafact["descripcion1"].'<br>'.$row_consultafact["placas1"].'<br><br>
	  </td>
      <td valign="top" width="35">'.$row_consultafact["cantidad1"].'</td>
      <td valign="top" width="40" align="center">'.number_format($row_consultafact["valor_uni1"]).'</td>
      <td valign="top" width="75" align="right">'.number_format($row_consultafact["subtotal1"]).'</td>
    </tr>';
}
if ($row_consultafact["cantidad2"] > 0){
$codigoHTML.='
    <tr>
      <td colspan="2" valign="top" width="325">'.$row_consultafact["descripcion2"].'<br>'.$row_consultafact["placas2"].'<br><br>
	  </td>
      <td valign="top" width="35">'.$row_consultafact["cantidad2"].'</td>
      <td valign="top" width="40" align="center">'.number_format($row_consultafact["valor_uni2"]).'</td>
      <td valign="top" width="75" align="right">'.number_format($row_consultafact["subtotal2"]).'</td>
    </tr>';
}
if ($row_consultafact["cantidad3"] > 0){
$codigoHTML.='
    <tr>
      <td colspan="2" valign="top" width="325">'.$row_consultafact["descripcion3"].'<br>'.$row_consultafact["placas3"].'<br><br>
	  </td>
      <td valign="top" width="35">'.$row_consultafact["cantidad3"].'</td>
      <td valign="top" width="40" align="center">'.number_format($row_consultafact["valor_uni3"]).'</td>
      <td valign="top" width="75" align="right">'.number_format($row_consultafact["subtotal3"]).'</td>
    </tr>';
}
if ($row_consultafact["cantidad4"] > 0){
$codigoHTML.='
    <tr>
      <td colspan="2" valign="top" width="325">'.$row_consultafact["descripcion4"].'<br>'.$row_consultafact["placas4"].'<br><br>
	  </td>
      <td valign="top" width="35">'.$row_consultafact["cantidad4"].'</td>
      <td valign="top" width="40" align="center">'.number_format($row_consultafact["valor_uni4"]).'</td>
      <td valign="top" width="75" align="right">'.number_format($row_consultafact["subtotal4"]).'</td>
    </tr>';
}
$codigoHTML.='
  </tbody>
</table>
</td>
	  </tr>
    <tr>
      <td>&nbsp;</td>
      <td height="84">';
if ($row_consultafact["banco"]=="avvillas"){
$elbanco='<div style="padding: 5px; font-size: 10; border: thin; border-style: solid; text-decoration-style: solid;">Por favor consignar:<br>
En cualquier sucursal de los bancos del grupo Aval Cuenta Corriente 080079163 del banco Av Villas<br>
Formato de Recaudo<br>
Referencia No. 1: Diligenciar numero de CC o NIT<br>
Referencia No. 2: Diligenciar numero factura FV  </div>';} elseif ($row_consultafact["banco"]=="bogota"){
	$elbanco='<div style="padding: 5px; font-size: 10; border: thin; border-style: solid; text-decoration-style: solid;">Por favor consignar:<br>
En cualquier sucursal de los bancos del grupo Aval Cuenta Corriente 020319356 del banco Bogota.<br></div>';}
$codigoHTML.=$elbanco;
$codigoHTML.='</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" align="center"><div style="font-size: 8;"><br>NUEVA DIRECCION: CALLE 14 No. 54 - 30 PISO 2<br><br></div></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4"><div style="font-size: 8;"><br>'.strtoupper(convertir($eltotal)).' PESOS M/C<br><br></div></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center">'.number_format($row_consultafact["subtotal"]).'</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center">'.number_format($iva).'</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td><div style="font-size:10;">Retefuente<br>Reteica</div></td>
      <td align="center"><div style="font-size:10;">'.number_format($retefuente).'<br>'.number_format($reteica).'</div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center">'.number_format($eltotal).'</td>
    </tr>
  </tbody>
</table>
</body>
</html>';
mysql_free_result($consultafact);

$codigoHTML=utf8_encode($codigoHTML);
$dompdf=new DOMPDF();
$dompdf->load_html($codigoHTML);
ini_set("memory_limit","128M");
$dompdf->render();
$dompdf->stream($impresion);
?>