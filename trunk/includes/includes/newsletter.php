<?php
/************************************************************************
*                 Nombre Sistema:   Litoral
*                  Nombre Script:   Newsletter.php
*                          Autor:   Angeletti, Mariano
*                 Fecha Creacion:   2:54 19/05/2003.
*            Ultima Modificacion:   
*           Campos que lee en BD:	
*      Campos que Modifica en BD:
*  Descripcion de funcionamiento:
*              Funciones que usa:
*                Que falta Hacer:
*
************************************************************************/




//////////////////////////////////,"OPIN"
# creo la variables "salto" para "mi mayor comodidad" y las textos constantes
$UN_SALTO="\r\n";
$DOS_SALTOS="\r\n\r\n";

/////////////////////////////////
// codigo Html que va en la cabecera de los newsletter
$vc_cabecera_html="<!-- NEWSLETTER --><html><head></head><body bgcolor=\"#FFFFFF\">";
$vs_cabecera_html.="<table width=\"75%\" border=\"0\" align=\"center\">";
$vs_cabecera_html.="<tr><td><div align=\"center\"><IMG SRC=\"http://www.litoral.com.ar/graficos/cabezal.gif\" width=\"307\" height=\"66\"></div></td>";
$vs_cabecera_html.="</tr></table>";
$vc_cabecera_html.="<br><FONT SIZE=\"2\" COLOR=\"#000000\" FACE=\"times,sans-serif\">";
$vc_cabecera_html.="Titulares de <A HREF=\"http://www.litoral.com.ar\">EL LITORAL</A> es el resumen ";
$vc_cabecera_html.="diario de las noticias publicadas en el en El Litoral con respecto
a lo que usted eligió en su configuración de usuario registrado. </FONT><br><br>";
// codigo TXT que va en la cabecera de los newsletter
$vc_cabecera_txt.="Titulares de EL LITORAL es el resumen diario de las noticias publicadas en ";
$vc_cabecera_txt.="El Litoral con respecto a lo que usted\n";
$vc_cabecera_txt.="eligió en su configuración de usuario registrado.\n\n";
// codigo Html que va en la parte inferior de los newsletter
$vc_inferior_html="<table width=\"600\" height=\"0\" border=\"0\">";
$vc_inferior_html.="<br><tr><td><font size=\"2\">El newsletter de <a href=\"http://www.litoral.com.ar\">El Litoral</a> 
        se publica diariamente y es un producto del portal de El Litoral.<br>";
$vc_inferior_html.="Si desea cancelar su suscripci&oacute;n, ingrese a su perfil de usuario 
        y cambie las preferencias. ";
$vc_inferior_html.="Acceda directamente a su perfil de usuario desde <a href=\"http://prueba.ellitoral.com/admin/Newsletter/loguear.html\">acá.</a>";
$vc_inferior_html.="</font></td></tr></table><br></body></html>";
// codigo Html que va en la parte inferior de los newsletter		
$vc_inferior_txt.="\n\nEl newsletter de El Litoral se publica diariamente y es un producto del portal";
$vc_inferior_txt.=" de El Litoral.\n";
$vc_inferior_txt.="Si desea cancelar su suscripción, ingrese a su perfil de usuario y cambie las ";
$vc_inferior_txt.="preferencias.\nAcceda directamente a su perfil de usuario desde http://prueba.ellitoral.com/admin/Newsletter/loguear.html\n\n";



// esta funcion recibe el camino del archivo y devuelve un array de dos 
// dimensiones conteniendo :
//	1- seccion:: 2- Titulo a mostrar :: 3- Directorio :: 4-SUPLEMENTO 

function obtener_secciones($vp_archivo_path,$vp_extensiones)
{
$vl_archivo = fopen($vp_archivo_path,"r");
$i=1;
while (!feof($vl_archivo))
	{
   $vl_texto = fgets($vl_archivo,80);
    if (stristr($vl_texto,"servicios")) break;	
	if (trim($vl_texto)=="") continue;	
	$vl_secc=strtok($vl_texto,"::");
	if (seccion_habilitada($vl_secc,$vp_extensiones)==FALSE)continue;
	if (!strstr($vl_texto,"#"))
		{	list($sec,$mos,$dir,$sup)=split("::",$vl_texto);
			$vl_arreglo[$i]=array("seccion"=>trim($sec),"mostrar"=>trim($mos),"directorio"=>trim($dir),"condicion"=>trim($sup));
			$i++;}
		
    }
fclose ($vl_archivo);   
return $vl_arreglo;
};
///////////////////////////////////////////
// se fija si la seccion $vp_id_seccion es un suplemento
function es_suple($vp_id_seccion,$vp_matriz)
{
foreach($vp_matriz as $clave => $valor)
{
if ($valor["condicion"]=="SUPLEMENTO" and $valor["seccion"]==$vp_id_seccion)  return 1;
}
return 0;
}
///////////////////////////////////////////////////
// recibo el nombre de una seccion y me devuelve si esta 

function seccion_habilitada($vp_seccion,$vp_extensiones)
{
	
$vp_seccion=trim(strtoupper($vp_seccion));
foreach($vp_extensiones as $vl_ext)
{  
	//$vl_archivo= strstr ($vp_archivo,$vl_ext);
	if (($vl_ext==$vp_seccion))
							{return TRUE;
							}
}
return FALSE;
}
///////////////////////////////////////////////////
// recibo el nombre de un archivo con su extension y me devuelve si es imagen o no
function es_permitido($vp_archivo,$vp_extensiones)
{
$vp_archivo=strtoupper($vp_archivo);
// pongo todo en mayusculas para facilitar la tarea


foreach($vp_extensiones as $vl_ext)
{  
	$vl_archivo= strstr ($vp_archivo,$vl_ext);
	if (!($vl_archivo===FALSE))
							{$vl_archivo2=strstr ($vp_archivo,"TXT");
							if (!($vl_archivo2===FALSE)){return 1;}
							}
}
return 0;
}
////////////////////////////////////////
// recibo la nota y devuelve el titulo
function get_titulo($vp_texto)
{
$vl_desde=strstr($vp_texto,"</TITULO");
$vl_desde=strstr($vl_desde,">");
$vl_hasta=strpos($vl_desde,"</")-1;
$vl_titulo=substr($vl_desde,1,$vl_hasta); 
//$vl_titulo=strip_tags($vl_titulo,"<a>|<b>|<font>|<br>");
return $vl_titulo;
}
////////////////////////////////////////
// recibo la nota y devuelve un comentario.....primero se fija si hay copete sino una parte del cuerpo
function get_comentario($vp_texto)
{

$vl_hay_comentario=strstr($vp_texto,"</COPETE>");
if (!($vl_hay_comentario===FALSE)){ $vl_desde=strstr($vp_texto,"</COPETE>");
									$vl_hasta=strpos($vl_desde,"</TEXTO>")-9;
									$vl_copete=substr($vl_desde,9,$vl_hasta);
									return $vl_copete;}
else {
	$vl_desde=strstr($vp_texto,"</TEXTO>");
	$vl_hasta=strpos($vl_desde,".")-7;
	$vl_copete=substr($vl_desde,8,$vl_hasta);
	$vl_copete=strip_tags($vl_copete,'<br>'); 
	if (strlen($vl_copete)<'25'){
								$vl_aux=strtok($vl_desde,".");
								$vl_copete=$vl_aux.".";
								$vl_aux=strtok(".");
								$vl_copete.=$vl_aux.".";
								$vl_copete=strip_tags($vl_copete,'<br>'); 
								};
	return $vl_copete;}
}
////////////////////////////////////////
// recibo la nombre de archivo y devuelve un identificador valido para usar
function generar_id_archivo($vp_id_seccion)
{
$vl_guion=strpos($vp_id_seccion,"-");
$vl_punto=strstr($vp_id_seccion,"-");
$vl_id_archivo=substr($vp_id_seccion,0,$vl_guion);
$vl_hasta=substr($vl_punto,1,2);
$vl_id_archivo=$vl_id_archivo.$vl_hasta;
return $vl_id_archivo;
}
////////////////////////////////////////
// recibo la nombre del archivo y devuelve el nombre de la seccion
function get_seccion($vp_archivo)
{
$vl_hasta=strpos($vp_archivo,"-");
$vl_nombre=substr($vp_archivo,0,$vl_hasta); 
return $vl_nombre;
}
////////////////////////////////////////
// recibo la nombre del archivo y devuelve el nombre de la seccion
function get_nombre_seccion($vp_arreglo,$vp_seccion)
{
foreach($vp_arreglo as $vl_arreglo)
{  
if($vl_arreglo["seccion"]==$vp_seccion){return $vl_arreglo["mostrar"];} 
}
}
////////////////////
function buscar_en_array($vp_palabra, $vp_arreglo)
{
//por cada seccion voy sacando los titulares del dia
foreach ($vp_arreglo as $key => $val)
{
if (get_seccion($val["nombre"]) == $vp_palabra)
{
return $key;
}//fin if
}//fin for
}//fin fun

///////////////////////////////////////////
// devuelve la seccion pero como se debe mostrar 
function get_mostrar($vp_id_seccion,$vp_matriz)
{
foreach($vp_matriz as $clave => $valor)
{
if ($valor["seccion"]==get_seccion($vp_id_seccion))  return $valor["mostrar"];
}
return 0;
}
///////////////////////////////////////////
// devuelve el camino como se debe mostrar 
function get_camino($vp_id_seccion,$vp_matriz)
{
foreach($vp_matriz as $clave => $valor)
{
if ($valor["seccion"]==get_seccion($vp_id_seccion))  return $valor["directorio"];
}
return 0;
}

?>