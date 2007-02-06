<?php

include('seguridad_intranet.php');

//Seteo el path de los apuntes
$path_archivos_apuntes="../archivos/$id_catedra/$vc_directorio_apuntes/$id_apunte/";

//Valido que venga el id_apunte
if(empty($id_apunte)){
    header("Location:index.php?ver=0&id_catedra=$id_catedra&mensaje_error=Error de Parametros");
	die();
    }

//Obtengo el apunte a bajar
$ap=mysql_query("select * from apuntes
                  where id_catedra='$id_catedra' and id_apuntes='$id_apunte' and publicar='1'");

//Aca entra si no se encontró el apunte
if (!mysql_num_rows($ap)){
    header("Location:index.php?ver=0&id_catedra=$id_catedra&mensaje_error=No existe el archivo del Apunte");
	die();
    }

//Obtengo el apunte
$fila=mysql_fetch_array($ap);
$arch=$fila["nombre_archivo"];

//Valido que exista el archivo
if (!file_exists($path_archivos_apuntes.$arch)){
    header("Location:index.php?ver=0&id_catedra=$id_catedra&mensaje_error=No existe el archivo del Apunte");
	die();
    }

//Si existe lo bajo
set_time_limit(0);
$attachment=" attachment;";
$miarch=$path_archivos_apuntes.$arch;
header( "Content-type: application/x-gzip\n" );
header( "Content-Disposition: attachment;  filename=$arch" );
header("Content-Description: ATTACHMENT");
header("Content-length: ". filesize($miarch));
header("Pragma:");
header("Cache-control: only-if-cached");
$fp=fopen($miarch,"rb");
fpassthru($fp);

exit();


?>