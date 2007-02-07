<?php
// helloworld.php demonstrates a very basic xajax implementation
// using xajax version 0.1 beta4
// http://xajax.sourceforge.net

require ('xajax/xajax.inc.php');

function recargar_cuerpo($archivo,$html_name,$dinamic=false){
	
	if(!$dinamic)
		include($archivo);

	$objResponse = new xajaxResponse();
	
	$objResponse->addAssign("derecha_div","innerHTML",$texto_html);
	
	
	return $objResponse;
}



// Instantiate the xajax object.  No parameters defaults requestURI to this page, method to POST, and debug to off
$xajax = new xajax(); 

//$xajax->debugOn(); // Uncomment this line to turn debugging on

// Specify the PHP functions to wrap. The JavaScript wrappers will be named xajax_functionname

$xajax->registerFunction("recargar_cuerpo");

// Process any requests.  Because our requestURI is the same as our html page,
// this must be called before any headers or HTML output have been sent
$xajax->processRequests();
?>



<html>
<head>
<title>UTN - FRSF - Manual del Sistema Matero</title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="./imagenes/estilos.css">
<style type="text/css">
h1{
	font-size:18px;
}
a{
	color:#009933;
	font-family: Verdana, Arial, Helvetica, sans-serif; 
	font-size: 10px; 
	color: #009933; 
	text-decoration: none; 
	font-weight: normal; 
	cursor:pointer;
}
a:hover{
	cursor:pointer;
	text-decoration:underline;

}
ul{
		text-align:left;
		
			
}
li.menu{

	text-align:left;
	list-style-type: none;
	margin:4px;
	list-style-position: outside;
	list-style-image: url(./imagenes/flecha.gif);
}



</style>
</head>

<body bgcolor="#FFFFFF" text="#000000" link="#000000" vlink="#000000" alink="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" class="barra">
<?php $xajax->printJavascript('xajax'); // output the xajax javascript. This must be called between the head tags ?>
  <script type="text/javascript">
	xajax_recargar_cuerpo('static.php','introduccion.html');
</script>

<table width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr> 
    <td colspan="2" height="2"> 


<!-- BEGIN bloqueencabezado -->
      <table width="100%" border="0" cellspacing="0" cellpadding="0">

        <tr> 
          <td width="36%" height="22" bgcolor="#88CC88"><font size="5" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;<font size="2"><strong>Manual del Sistema Matero</strong></font></font></td>
          <td width="351" height="22"><img src="./imagenes/encabezado.gif" width="351" height="37"></td>
          <td width="30%" background="./imagenes/fondo_celda_encabezado.gif" height="37">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="3" height="2"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="85%" bgcolor="#BBEEBB"> </td>

                <td width="15%"><img src="./imagenes/final_celda_path.gif" width="20" height="20"></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
	  <!-- END bloqueencabezado -->

    </td>
  </tr>
  <tr> 
    <td width="15%" background="./imagenes/fondoclaro.gif" height="491" valign="top">
     <ul>
	 	<li class="menu"><a onClick="xajax_recargar_cuerpo('static.php','introduccion.html')">Introduccíon</a></li>
		<li class="menu"><a onClick="xajax_recargar_cuerpo('static.php','solicitud_cuenta.html')">Crear 
          cuenta en el Matero</a></li>
	 	<li class="menu"> <a onClick="xajax_recargar_cuerpo('static.php','INGRESO A MATERO.htm')">Ingreso al Matero</a></li>		
	 	<li class="menu"><a onClick="xajax_recargar_cuerpo('static.php','Presentacion_del_menu_principal.htm')">Presentacíon Menu Principal</a></li>				
		<li class="menu"><a onClick="xajax_recargar_cuerpo('static.php','Consideraciones Especiales.htm')">Consideraciones Especiales</a></li>				
		<li class="menu">Modulos para Gestión de Catedra</li>				
		
		<ul>
		<li class="menu"><a onClick="xajax_recargar_cuerpo('static.php','modulo_plan_catedra.htm')">Plan de Catedra</a></li>
		<li class="menu"><a onClick="xajax_recargar_cuerpo('static.php','modulo_objetivos.htm')">Objetivos</a></li>
		<li class="menu"><a onClick="xajax_recargar_cuerpo('static.php','modulo_horarios.htm')">Horarios</a></li>
		<li class="menu"><a onClick="xajax_recargar_cuerpo('static.php','modulo_integrantes.htm')">Integrantes</a></li>
		<li class="menu"><a onClick="xajax_recargar_cuerpo('static.php','modulo_novedades.htm')">Novedades</a></li>
		<li class="menu"><a onClick="xajax_recargar_cuerpo('static.php','modulo_apuntes.htm')">Apuntes</a></li>
		<li class="menu"><a onClick="xajax_recargar_cuerpo('static.php','modulo_examen_final.htm')">Examen Final</a></li>
		<li class="menu"><a onClick="xajax_recargar_cuerpo('static.php','modulo_bibliografia.htm')">Bibliografia</a></li>
		<li class="menu"><a onClick="xajax_recargar_cuerpo('static.php','modulo_links.htm')">Links</a></li>
		<li class="menu"><a onClick="xajax_recargar_cuerpo('static.php','modulo_Repositorio.htm')">Repositorio</a></li>
						
		
		</ul>
	 <li class="menu">Modulos Especiales para cada Comisión</li>
	 <ul>
	    <li class="menu"><a onClick="xajax_recargar_cuerpo('static.php','modulo_alumnos.htm')">Alumnos</a></li>
		<li class="menu"><a onClick="xajax_recargar_cuerpo('static.php','modulo_examen_parcial.htm')">Exámen Parcial</a></li>
		<li class="menu"><a onClick="xajax_recargar_cuerpo('static.php','modulo_trabajo_practico.htm')">Trabajos Prácticos</a></li>
	</ul>
	<li class="menu">Módulo Especial</li>
	 <ul>
	 <li class="menu"><a onClick="xajax_recargar_cuerpo('static.php','modulo_modulos.htm')">Administrar Módulos</a></li>
	 <li class="menu"><a onClick="xajax_recargar_cuerpo('static.php','previsualizar.htm')">Previsualizar</a></li>
	 </ul>
	 </ul>
      </td>
    <td width="85%" height="491"> 
      <table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td width="1" background="./imagenes/linea_lateral.gif">&nbsp;</td>
		  <td width="10">&nbsp;</td>
          <td height="100%" valign="top" id="columna_derecha"> 
            
			<div id="derecha_div"></div>
			
			</td>
		  <td width="10">&nbsp;</td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>

<table heigth="10" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr heigth="10"> 
    <td height="2" width="15%" background="./imagenes/fondoclaro.gif"> 
      <div align="right"><img src="./imagenes/menu_abj.gif" width="26" height="10"></div>
    </td>
    <td height="2" width="48%" background="./imagenes/fondo_celda_inferior_centro.gif"></td>
    <td height="2" width="37%" background="./imagenes/fondo_celda_inferior_derecha.gif"><img src="./imagenes/abj01.gif" width="10" height="10"></td>
  </tr>
</table>

</body>
</html>