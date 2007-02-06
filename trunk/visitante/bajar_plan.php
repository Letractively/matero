<?php

include('seguridad_intranet.php');

//Seteo el path de los planes
$path_archivos_planes="../archivos/$id_catedra/$vc_directorio_plan/";

//Obtengo el plan a bajar
$plan=mysql_query("select * from catedra_plan
                  where id_catedra='$id_catedra'");

//Aca entra si no se encontró el plan
if (!mysql_num_rows($plan)){
    header("Location:index.php?ver=0&id_catedra=$id_catedra&mensaje_error=No existe el archivo del Plan");
	die();
    }

//Obtengo el plan
$fila=mysql_fetch_array($plan);
$arch=$fila["nombre_archivo"];

//Valido que exista el archivo
if (!file_exists($path_archivos_planes.$arch)){
    header("Location:index.php?ver=0&id_catedra=$id_catedra&mensaje_error=No existe el archivo del Plan");
	die();
    }

//Si existe lo bajo
set_time_limit(0);
$attachment=" attachment;";
$miarch=$path_archivos_planes.$arch;
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