<?
/************************************************************************
*                 Nombre Sistema:   Litoral
                 Nombre Libreria:   buscar.php
*                          Autor:   Angeletti, Mariano
*                 Fecha Creacion:   2:54 14/04/2003.
*            Ultima Modificacion:   
*              Funciones creadas:  
*                Que falta Hacer:    hacer el filtro...en un rango de -3 +1
************************************************************************/
function imprimir_imagen($vp_archivo){
	global $vc_banners;
	global $vc_carpeta_banners;
	$vl_archivo=$vc_carpeta_banners."/".$vp_archivo;
	$vl_aux=getimagesize(str_replace(' ','%20',$vl_archivo));
	$vl_codigo=$vl_aux[3];

	if ($vl_aux[2]=='4'){// el tipo 4 es el de SWF
		$vl_html="<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" $vl_codigo\">
    		      <param name=\"movie\" value=\"$vc_banners".$vp_archivo."\">
        		  <param name=\"quality\" value=\"high\">
        		  <embed src=\"$vc_banners".$vp_archivo."\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" $vl_codigo\"></embed></object>";
		}
	else{$vl_html="<img src=$vc_banners".$vp_archivo.">";	
		}

return $vl_html;
}


function es_permitido_banner($vp_archivo,$vp_ancho_max,$vp_alto_max,$vp_ancho_min,$vp_alto_min){
	$vl_aux=getimagesize(str_replace(' ','%20',$vp_archivo));
		if (($vl_aux==FALSE) ||  				     // si hubo un error al abrir el archivo O
	    ($vl_aux[0] < $vp_ancho_min) ||
	    ($vl_aux[0] > $vp_ancho_max) ||      // si no es del ancho que corresponde a ese espacio O
	     ($vl_aux[1] < $vp_alto_min) ||
	    ($vl_aux[1] > $vp_alto_max)){        // si no es del alto que corresponde a ese espacio
					return FALSE;
			}
	return $vl_aux;
} // fin funcion es permitido
////////////////////////////////////////////////////
// para archo de tipo SWF, esta funcion devuelve el codigo listo para 
// insertar en un html


function imprimir_flash($vp_archivo){
	global $vc_banners;
	global $vc_carpeta_banners;
	$vl_archivo=$vc_carpeta_banners."/".$vp_archivo;
	$vl_aux=getimagesize(str_replace(' ','%20',$vl_archivo));
	$vl_codigo=$vl_aux[3];
	
$vl_html="<object classid=\"clsid:D27CDB6E-AE6D-11cf-96B8-444553540000\" codebase=\"http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0\" $vl_codigo\">
          <param name=\"movie\" value=\"$vc_banners".$vp_archivo."\">
          <param name=\"quality\" value=\"high\">
          <embed src=\"$vc_banners".$vp_archivo."\" quality=\"high\" pluginspage=\"http://www.macromedia.com/go/getflashplayer\" type=\"application/x-shockwave-flash\" $vl_codigo\"></embed></object>";
return $vl_html;
}

//muestra el banner actual en la seccion correpsondiente, si no hay alguno habilitado pongo
// uno por defecto
function mostrar_banner($vp_espacio,$vp_seccion){
$vl_fecha=date("Y-m-d");

$vl_consulta = "Select *
      		    from banner,banner_espacio
		     	where banner_espacio.id_banner_espacio=banner.id_espacio_banner
				and fecha_desde <= '$vl_fecha'
				and fecha_hasta >= '$vl_fecha'
				and banner_espacio.nombre='$vp_espacio'
				and banner.secciones='$vp_seccion'";

$vl_consulta=mysql_query($vl_consulta);	

if (!mysql_num_rows($vl_consulta))
					{return 0;}
else {
	$vl_fila=mysql_fetch_array($vl_consulta);
	$vl_array=array("archivo"=>$vl_fila[archivo_imagen], "link"=>$vl_fila[link]);
	return $vl_array;
	} 	 				
}

// busca el banner por defecto por no haber encontrado ninguno habilitado en BD
function banner_por_defecto($vp_espacio){
$vl_consulta=mysql_query("Select *
				from banner_espacio
				where nombre='$vp_espacio'
				");	
if (!mysql_num_rows($vl_consulta)){return 0;}
else {
	$vl_fila=mysql_fetch_array($vl_consulta);
	$vl_array=array("archivo"=>$vl_fila[imagen_defecto], "link"=>$vl_fila[link_defecto]);
	return $vl_array;
	 } 	 				
}

// selecciona el banner a publicar y lo pone en el formato qeu corresponda
function publicar_banner($vp_espacio){
	global $ver;
	global $vc_carpeta_banners;
	global $vc_banners;
	global $vg_seccion;
//	$vl_seccion=get_seccion_banner($ver,$vp_espacio); // seccion y espacio para calcular el nombre de seccion tal cual se guarda en bd
	$vl_seccion=$vg_seccion;
	$vl_espacio="espacio_".$vp_espacio;
	$vl_banner=mostrar_banner($vl_espacio,$vl_seccion);
	
// si el espacio no esta vendido -> busco banner por defecto y marco el espacio como libre
if($vl_banner=='0'){
	$vl_espacio_libre = 1;
	$vl_banner=banner_por_defecto($vl_espacio);
	}
	
	$vl_archivo=$vc_carpeta_banners."/".$vl_banner["archivo"];
		
	$vl_valor=getimagesize(str_replace(' ','%20',$vl_archivo));

if ($vl_valor[2]=='4'){ // el tipo 4 es el de SWF
	$vl_imprime=imprimir_flash($vl_banner["archivo"]);// funcion de banner.php	
	}
	else {
	$vl_imprime="<img src=\"$vc_banners".$vl_banner["archivo"]."\">";
	}
	
if(($vp_espacio==10)AND($ver=="")){ // si se trata del popup (10 es el identificador del popup...)	-> abro una ventana con el tamaño del archivo correspondiente
	$vl_archivo = "$vc_carpeta_banners/$vl_banner[archivo]";
	$vl_tamanio =  getimagesize($vl_archivo);

	$vl_ancho = $vl_tamanio[0];
	$vl_alto = $vl_tamanio[1];

	$vl_imagen = imprimir_imagen("$vl_banner[archivo]");

	$vl_imprime =  "<script>
				<!--
				html =  '<html><head><title>El Litoral :: www.ellitoral.com</title><head>' +
						'<BODY LEFTMARGIN=0 TOPMARGIN=0>' +
						'$vl_imagen' +  
						'</body></html>';
				popup = window.open('','banner','width=$vl_ancho,height=$vl_alto,left=100,top=100');
				popup.document.open();
				popup.document.write(html);
				popup.document.focus();
				-->
				</script>";
		}

// si se trata del popup (10 es el identificador del popup...) pero no estoy en la home -> no imprimo nada
if(($vp_espacio==10)AND($ver!="")){$vl_imprime="";}

// si no hay ningun popup cargagado -> vl_banner vale cero y en el caso de un popup no debo mostrar el banner pro defecto
// vel espacio libre se pone en 1 (más arriba) si el popup no esta vendido
if(($vp_espacio==10)AND($vl_espacio_libre)){$vl_imprime="";}
	
	
return $vl_imprime;
}
	
	

/**************/
// selecciona el banner a publicar y lo pone en el formato qeu corresponda //
function publicar_popup($vp_espacio){
	global $ver;
	global $vc_carpeta_banners;
	global $vc_banners;
	
	$vl_espacio="espacio_".$vp_espacio;
	$vl_banner=mostrar_banner($vl_espacio,"");
	
	$vl_archivo=$vc_carpeta_banners."/".$vl_banner["archivo"];
	
	
if($vl_banner!=0){
	echo "$vl_archivo";	
	$vl_valor=getimagesize(str_replace(' ','%20',$vl_archivo));

	if ($vl_valor[2]=='4'){ // el tipo 4 es el de SWF
		$vl_imprime=imprimir_flash($vl_banner["archivo"]);// funcion de banner.php	
	}
	else {
		$vl_imprime="<img src=\"$vc_banners".$vl_banner["archivo"]."\">";
	}

	$vl_archivo = "$vc_carpeta_banners/$vl_banner[archivo]";
	$vl_tamanio =  getimagesize($vl_archivo);

	$vl_ancho = $vl_tamanio[0];
	$vl_alto = $vl_tamanio[1];

	$vl_imagen = imprimir_imagen("$vl_banner[archivo]");

	$vl_imprime =  "<script>
				<!--
				html =  '<html><head><title>El Litoral :: www.ellitoral.com</title><head>' +
						'<BODY LEFTMARGIN=0 TOPMARGIN=0>' +
						'$vl_imagen' +  
						'</body></html>';
				popup = window.open('','banner','width=$vl_ancho,height=$vl_alto,left=100,top=100');
				popup.document.open();
				popup.document.write(html);
				popup.document.focus();
				-->
				</script>";
		}
else{
	$vl_imprime="<script></script>";
}
	
return $vl_imprime;
}
/*****************************///fin publicar  popup



// get seccion espacio calcuala el nombre de la seccion ta cual se guarda en el campo seccion de banners
// devuelve solo nmbre de la seccion, si la seccion el espaico es 10 (banner) y
function get_seccion_banner($vp_ver,$vp_espacio){
if (($vp_ver=="")AND($vp_espacio!=10)){$vl_seccion="HOMEPAGE";}
else  {$vl_hasta=strpos($vp_ver,"/");
	   $vl_seccion=substr($vp_ver,0,$vl_hasta);
	   $vl_seccion=strtoupper($vl_seccion); 
       }
return $vl_seccion;		   
}
?>
