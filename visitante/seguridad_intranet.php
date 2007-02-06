<?php
include("../includes/validacion.php");
include("../includes/configuracion.php");
include("../includes/fecha.php");
include("../includes/template.php");

//Truco para hacer globales las variables por get y post con register_globals en off
getpost_ifset();

if(empty($id_catedra)){
    set_file('pagina','error_grave.html');
    set_var('mensaje','Error de parámetros');
    set_var('donde','error_grave.php');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

if(!$conexion=conectar()){die("No se conecto con la base de datos");}
?>