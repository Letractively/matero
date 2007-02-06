<?php
/********************************************************************************

Archivo de configuración de Tecnicatura de Tecnologia de Información

Ver. 1.0.1 2001/03/20   ANGELETTI,BOTTA,SANCHEZ

*********************************************************************************/



//////////////////////////////////////////////
//Parametros y funciones de la base de datos
/////////////////////////////////////////////

// variable que define el tamaño de página para el expandido menos en foros
$vc_tamanio_pagina_foro_menos=20;

// variable que define el tamaño de página para el expandido mas en foros
$vc_tamanio_pagina_foro_mas=10;

// Fucion conectar -> conecta con la base de datos y nos permite modificar el host, el usuario y la password con facilidad
$vc_ip_interna="200.68.216.199";
// carpeta de estilos
$vc_carpeta_estilos = "$DOCUMENT_ROOT/estilos";

// carpeta de fotos 
$vc_carpeta_fotos = "$DOCUMENT_ROOT/fotos";

// tengo 10 colores para los resultados de las encuestas????????
$vc_color_array=array("0000CC","000099","0033FF","0066FF","0099FF","00CCFF","00DDFF","00FFFF","0255FF","0666FF");

// carpeta graficos
$vc_carpeta_graficos = "$DOCUMENT_ROOT/graficos";

// carpeta de especiales
$vc_carpeta_especiales = "$DOCUMENT_ROOT/especiales_archivos";// para los html
$vc_carpeta_especiales_archivos = "$DOCUMENT_ROOT/especiales_archivos/archivos";// para las imagenes y banner

// carpeta de banners 
$vc_carpeta_banners = "$DOCUMENT_ROOT/banners";
$vc_banners="/banners/";

// carpeta Includes
$vc_carpeta_includes = "$DOCUMENT_ROOT/includes";

// carpeta javascripts
$vc_carpeta_javascripts = "$DOCUMENT_ROOT/javascripts";

// archivo donde se definen las secciones y suplementos del diairo (id, directorio, si es suplemento)- ¿se usa para generar comAr??
$vc_archivo_config_news = "$DOCUMENT_ROOT/admin/Newsletter/secciones.dat";

// donde se guardan los txt del dia
$vc_carpeta_news="$DOCUMENT_ROOT/admin/Newsletter/Internet/";
$vc_carpeta_news2="$DOCUMENT_ROOT/admin/Newsletter/Internet2/";

//$vc_carpeta_news="M:/internet/";
// fuera de uso por el momento 
$vc_carpeta_news_generados=$vc_carpeta_news."news/";
// secciones para el banner

// secciones del portal, se usan para los banners, cada vez que agregamos una seccion hay que
// actualizar este arreglo
$vc_secciones=array("HOMEPAGE","PREG_INTENDENTE","PREG_DEFENSA","FOROS","AGENDA","ENCUESTAS","CLASIFICADOS","FARMACIAS","NEWSLETTER","ESPECIALES","REGISTRATE","DEPORTES","LOGUEADOS");
$vc_banner_secciones=$vc_secciones;


// que secciones estan permitidas acutalmente en el newsletter
$vc_news_extensiones=array("AREA","DEPO","ECON","INFO","INTE","PAN","PER","POLI","REGI","SUCE","TAPA","COM","HACE","NOS");
$vc_suple_extensiones=array("HACE","NOS");
// que tipos de formatos son permitidos para los banners JPEG, GIF, PNG, SWF, TIFF y JPEG2000
$vc_banners_extensiones= array("GIF","SFW","JPEG","PNG","TIFF","JPEG2000");


function conectar(){
//	$c = mysql_connect(); 
//	$c=mysql_connect($db['host'],$db['user'],$db['pass']); //$db["password(pass)"]);
	$c=mysql_connect("localhost","utn","pasan3"); //$db["password(pass)"]);
	mysql_query("use litoral");
    return $c;
	}

///////////////////////////////////////////////
//         funciones de seguridad            //
///////////////////////////////////////////////


// esta funcion la agrego aca tambien porque todos los script la utilizan
// y no vale la pena poner el easy_html.php por 4 lineas
// Lo que hace es crear el cartelito que va como pie, en todas las páginas.
function firma(){
	$vl=date("Y");
	$pie_l='Desarrollo Web El Litoral - '.$vl;
	return $pie_l;
}
// redondea un float con n de presicion
//Mariano
function round_precision($val,$precision){
	$exp = pow(10,$precision);
	$val = $val * $exp;
	$val = round($val);
	$val = $val /  $exp;
	return $val;
}

?>