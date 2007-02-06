<?php

include('seguridad_intranet.php');

//Seteo el path de los tps
$path_archivos_tps="../archivos/$id_catedra/$vc_directorio_tps/$id_trabajo/";

//Valido que venga el id_trabajo y el id_catedra
if((empty($id_trabajo))||(empty($id_catedra))){
    header("Location:index.php?ver=0&id_catedra=$id_catedra&mensaje_error=Error de Parametros");
	die();
}


//Obtengo el tp a bajar
$tp=mysql_query("select * from trabajo_practico
                  where id_tp='$id_trabajo' and publicar='1'");

//Aca entra si no se encontró el apunte
if (!mysql_num_rows($tp)){
    header("Location:index.php?ver=0&id_catedra=$id_catedra&mensaje_error=No existe el archivo del TP");
	die();
}

//Obtengo el tp 
$fila=mysql_fetch_array($tp);
$arch=$fila["archivo"];

if (!file_exists($path_archivos_tps.$arch)){
    header("Location:index.php?ver=0&id_catedra=$id_catedra&mensaje_error=No existe el archivo del TP");
	die();
    }


//Si existe lo bajo
set_time_limit(0);
$attachment=" attachment;";
$miarch=$path_archivos_tps.$arch;
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