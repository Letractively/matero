<?php

include('seguridad_intranet.php');

//Seteo el path del repositorio
$path_archivos_repositorio="../archivos/$id_catedra/$vc_directorio_repositorios/$id_repositorio/";

//Valido que venga el id_repositorio
if(empty($id_repositorio)){
    set_file('pagina','error_grave.html');
    set_var('mensaje','Error de parámetros');
    set_var('donde','error_grave.php');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

//Obtengo el item a bajar
$item=mysql_query("select * from repositorio
                  where id_catedra='$id_catedra' and id_repositorio='$id_repositorio' and publicar='1'");

//Aca entra si no se encontró el item
if (!mysql_num_rows($item)){
    set_file('pagina','error.html');
    //Incluyo el codigo para que se genere el menu y la informacion del encabezado
    include('include_menu.php');
    set_var('mensaje','No existe el archivo.');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

//Obtengo el apunte
$fila=mysql_fetch_array($item);
$arch=$fila["nombre_archivo"];

//Valido que exista el archivo
if (!file_exists($path_archivos_repositorio.$arch)){
    set_file('pagina','error.html');
    //Incluyo el codigo para que se genere el menu y la informacion del encabezado
    include('include_menu.php');
    set_var('mensaje','No existe el archivo.');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

//Si existe lo bajo
set_time_limit(0);
$attachment=" attachment;";
$miarch=$path_archivos_repositorio.$arch;
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