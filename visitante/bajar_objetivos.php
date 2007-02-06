<?php

include('seguridad_intranet.php');

//Seteo el path de los planes
$path_archivos_objetivos="../archivos/$id_catedra/$vc_directorio_objetivo/";

//Obtengo el objetivo
$obj=mysql_query("select * from objetivos
                  where id_catedra='$id_catedra'");

//Aca entra si no se encontró el objetivo
if (!mysql_num_rows($obj)){
    set_file('pagina','error.html');
    //Incluyo el codigo para que se genere el menu y la informacion del encabezado
    include('include_menu.php');
    set_var('mensaje','No existe el archivo.');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

//Obtengo el plan
$fila=mysql_fetch_array($obj);
$arch=$fila["nombre_archivo"];

//Valido que exista el archivo
if (!file_exists($path_archivos_objetivos.$arch)){
    set_file('pagina','error.html');
    //Incluyo el codigo para que se genere el menu y la informacion del encabezado
    include('include_menu.php');
    set_var('mensaje','No existe el archivo.<br>Contactese con el administrador');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

//Si existe lo bajo
set_time_limit(0);
$attachment=" attachment;";
$miarch=$path_archivos_objetivos.$arch;
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