<?php

error_reporting(E_ALL);
ini_set('display_errors', '1');
  header('Content-Type: text/html; charset=ISO-8859-1'); 

$hostname_track = "localhost";
$database_track = "tracking_tracking";
$username_track = "tracking_track1";
$password_track = "tracking@1";
/* $track = mysqli_connect($hostname_track, $username_track, $password_track, $database_track) or trigger_error(mysqli_error(),E_USER_ERROR); */


$track = new mysqli($hostname_track, $username_track, $password_track, $database_track);
if ($track -> connect_errno) {
die( "Fallo la conexi«Ñn a MySQL: (" . $mysqli -> mysqli_connect_errno() 
. ") " . $mysqli -> mysqli_connect_error());
}


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

$findme   = 'REM';
$remision = strpos($numero, $findme);

if ($remision === false) {
    $impnum = '&nbsp;';
} else {
    $impnum = $numero;
}

$resultado = ("SELECT *, clientes.nombre FROM facturacion JOIN clientes ON facturacion.id_cliente = clientes.id_cliente JOIN grupos ON facturacion.id_grupos = grupos.id_grupos WHERE facturacion.numero = $elnumero");
	$resulta = $track->query($resultado);
	$row_consultafact = $resulta->fetch_assoc();

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
// agosto 8 - toma reteica al no tener
$conreteica=$row_consultafact["conreteica"];
if($conreteica=='n'){
	$reteica=0;
} else {
	$reteica=$row_consultafact["reteica"];
}

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

require_once('../tcpdf/tcpdf.php');

// create new PDF document
$pdf = new TCPDF('P', 'mm', 'LETTER', true, 'UTF-8', false);
// remove default header/footer
$pdf->setPrintHeader(false);
$pdf->setPrintFooter(false);
// set document information
//$pdf->SetCreator(PDF_CREATOR);
$pdf->SetTitle("Factura ".$row_consultafact['numero']);
$pdf->SetMargins(25, 24, 0);
$pdf->SetAutoPageBreak(TRUE, 0);
// add a page
$pdf->SetFont('times', '', 11);
$pdf->AddPage();
$cuerpo ='

<!DOCTYPE html PUBLIC "-//W3C//DTD XHTML 1.0 Transitional//EN" "http://www.w3.org/TR/xhtml1/DTD/xhtml1-transitional.dtd">
<html xmlns="http://www.w3.org/1999/xhtml">
<head><meta http-equiv="Content-Type" content="text/html; charset=gb18030">

<title>Documento sin titulo</title>
<style type="text/css">
  @page {
            margin-bottom: 0px;
        }
</style>
</head>
<body><br><br><br>
<table minwidth="742" style="table-layout:fixed; border-spacing: 1px";>
  <tbody>
    <tr>
	<td width="10" height="20"></td>
      <!-- <td width="45" height="52"></td>  style="background-color: red" ********** -->
      <td width="60" height="20"></td>
      <td maxwidth="300"></td>
      <td width="147">&nbsp;</td>
      <td width="50">&nbsp;</td>
      <td width="60">&nbsp;</td>
      <td width="95">&nbsp;</td>
      <!-- <td width="95" >'.$impnum.'</td> 742 ********** -->
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="4" width="425" height="14">'.utf8_encode($row_consultafact["nombre"]).'</td>
      <td>&nbsp;</td> 
    </tr>
    <tr>
      <td width="10">&nbsp;</td>
      <td width="287">'.$row_consultafact["nit"].$row_consultafact["dv"].'</td>
      <td colspan="2" width="85">'.$dfact.'&nbsp;&nbsp;&nbsp;&nbsp;'.$mfact.'&nbsp;&nbsp;&nbsp;&nbsp;'.$afact.'</td>
      <td colspan="2" width="144">'.$dven.'&nbsp;&nbsp;&nbsp;&nbsp;'.$mven.'&nbsp;&nbsp;&nbsp;&nbsp;'.$aven.'</td>
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
      <td height="40" valign="top">'.$row_consultafact["telefono"].'</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
	  </tr>
    <tr>
      <td>&nbsp;</td>
     <!--  <td height="1" valign="top">&nbsp;</td>   ********-->
      <td height="2" valign="top">&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
	  </tr>
	  <tr>
      <td width="20">&nbsp;</td>
      <!-- <td colspan="5" height="310" valign="top">321************  -->
      <td colspan="5" height="330" valign="top">
<table border="0" style="table-layout:fixed; font-size: 9;">
  <tbody>';
/*  style="border-width: 1px;border: solid; border-color: #00FF00;"*/
if ($row_consultafact["cantidadc"] > 0){
$cuerpo .='
    <tr>
      <td colspan="2" valign="top" width="315" >'.$row_consultafact["descripcionc"].'<br>'.$row_consultafact["placasc"].'<br><br>
	  </td>
      <td valign="top" width="63">'.$row_consultafact["cantidadc"].'</td>
      <td valign="top" width="42" align="center">'.number_format($row_consultafact["valor_unic"]).'</td>
      <td valign="top" width="60" align="right">'.number_format($row_consultafact["subtotalc"]).'</td>
    </tr>';    
} 
if ($row_consultafact["cantidada"] > 0){
$cuerpo .='
    <tr>
      <td colspan="2" valign="top" width="315">'.$row_consultafact["descripciona"].'<br>'.$row_consultafact["placasa"].'<br><br>
	  </td>
      <td valign="top" width="63">'.$row_consultafact["cantidada"].'</td>
      <td valign="top" width="42" align="center">'.number_format($row_consultafact["valor_unia"]).'</td>
      <td valign="top" width="60" align="right">'.number_format($row_consultafact["subtotala"]).'</td>
    </tr>';
}
if ($row_consultafact["cantidad1"] > 0){
$cuerpo .='
    <tr>
      <td colspan="2" valign="top" width="315">'.$row_consultafact["descripcion1"].'<br>'.$row_consultafact["placas1"].'<br><br>
	  </td>
      <td valign="top" width="63">'.$row_consultafact["cantidad1"].'</td>
      <td valign="top" width="42" align="center">'.number_format($row_consultafact["valor_uni1"]).'</td>
      <td valign="top" width="60" align="right">'.number_format($row_consultafact["subtotal1"]).'</td>
    </tr>';
}
if ($row_consultafact["cantidad2"] > 0){
$cuerpo .='
    <tr>
      <td colspan="2" valign="top" width="315">'.$row_consultafact["descripcion2"].'<br>'.$row_consultafact["placas2"].'<br><br>
	  </td>
      <td valign="top" width="63">'.$row_consultafact["cantidad2"].'</td>
      <td valign="top" width="42" align="center">'.number_format($row_consultafact["valor_uni2"]).'</td>
      <td valign="top" width="60" align="right">'.number_format($row_consultafact["subtotal2"]).'</td>
    </tr>';
}
if ($row_consultafact["cantidad3"] > 0){
$cuerpo .='
    <tr>
      <td colspan="2" valign="top" width="315">'.$row_consultafact["descripcion3"].'<br>'.$row_consultafact["placas3"].'<br><br>
	  </td>
      <td valign="top" width="63">'.$row_consultafact["cantidad3"].'</td>
      <td valign="top" width="42" align="center">'.number_format($row_consultafact["valor_uni3"]).'</td>
      <td valign="top" width="60" align="right">'.number_format($row_consultafact["subtotal3"]).'</td>
    </tr>';
}
if ($row_consultafact["cantidad4"] > 0){
$cuerpo .='
    <tr>
      <td colspan="2" valign="top" width="315">'.$row_consultafact["descripcion4"].'<br>'.$row_consultafact["placas4"].'<br><br>
	  </td>
      <td valign="top" width="63">'.$row_consultafact["cantidad4"].'</td>
      <td valign="top" width="42" align="center">'.number_format($row_consultafact["valor_uni4"]).'</td>
      <td valign="top" width="60" align="right">'.number_format($row_consultafact["subtotal4"]).'</td>
    </tr>';
}
$cuerpo .='
  </tbody>
</table>
</td>
	  </tr>
    <tr>
      <td>&nbsp;</td>
      <td style="font-size: 8; height:78px;"><br />';
if ($remision === false) {
if ($row_consultafact["banco"]=="avvillas"){
$elbanco='<div style="padding: 15px; font-size: 9; text-decoration-style: solid;">Por favor consignar:<br>
En cualquier sucursal de los bancos del grupo Aval Cuenta Corriente 080079163 del banco Av Villas<br>
Formato de Recaudo<br>
Referencia No. 1: Diligenciar numero de CC o NIT<br>
Referencia No. 2: Diligenciar numero factura FV  <br></div>';} elseif ($row_consultafact["banco"]=="bogota"){
	$elbanco='<div style="padding: 15px; font-size: 9; text-decoration-style: solid;">Por favor consignar:<br>
En cualquier sucursal de los bancos del grupo Aval Cuenta Corriente 020319356 del banco Bogota.<br></div>';}
} else {
	$elbanco='<div style="padding: 15px; font-size: 9; text-decoration-style: solid;">Por favor consignar:<br>
En cualquier sucursal de los bancos del grupo Aval Cuenta de Ahorros 029122496 del banco Av Villas.<br></div>';}
$cuerpo .=$elbanco;
$cuerpo .='</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" height="12" align="center"><div style="font-size: 8;">NUEVA DIRECCION: CARRERA 50 No. 1 G - 10 BARRIO JAZMIN<br></div></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td colspan="4" height="8"><div style="font-size: 6;"><br>'.strtoupper(convertir($eltotal)).' PESOS M/C<br></div></td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center" height="20">'.number_format($row_consultafact["subtotal"]).'</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center" height="8">'.number_format($iva).'</td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td><div style="font-size:8;">Retefuente<br>Reteica</div></td>
      <td align="center" height="9"><div style="font-size:8;">'.number_format($retefuente).'<br>'.number_format($reteica).'</div></td>
    </tr>
    <tr>
      <td>&nbsp;</td>
      <td colspan="2">&nbsp;</td>
      <td>&nbsp;</td>
      <td>&nbsp;</td>
      <td align="center" height="10">'.number_format($eltotal).'</td>
    </tr>
  </tbody>
</table>
</body>
</html>';
// output the HTML content
$pdf->writeHTML($cuerpo, true, false, true, false, '');

// reset pointer to the last page
$pdf->lastPage();

// ---------------------------------------------------------

//Close and output PDF document
$pdf->Output("Factura ".$row_consultafact['numero'].".pdf", "I");


?>