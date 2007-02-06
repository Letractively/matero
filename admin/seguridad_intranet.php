<?php
/*
// HTTPS seguro
if ( !isset($_SERVER['HTTPS']) || strtolower($_SERVER['HTTPS']) != 'on' ) {
   header ('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
   exit();
};
*/
// incluimos las libbrerias q se utilizan siempre
include("../includes/validacion.php");
include("../includes/configuracion.php");
include("../includes/template.php");

// iniciamos sesion
ini_alter("session.use_cookies","0");
ini_alter("session.use_trans_sid","1");


getpost_ifset();

session_start();


//Truco para hacer globales las variables por get y post con register_globals en off
getpost_ifset();

// Si no esta el usuario logueado lo saca del sistema
if ((!session_is_registered('logueado')) || ($logueado!=1)){


session_unset();
session_destroy();


header("Location:index.php");
die("");

}


// Se utiliza para los botones de formulario VOLVER
if(isset($vf_volver) && $vf_menu=='1'){header("Location:$vf_donde_redirigir"."PHPSESSID=$PHPSESSID");
				  die();};
if(isset($vf_volver)){header("Location:menu.php?PHPSESSID=$PHPSESSID"); die();}
if(isset($vf_cerrar)){header("Location:menu.php?PHPSESSID=$PHPSESSID"); die();}
if(isset($vf_redirigir)){header("Location:$vf_donde_redirigir"."PHPSESSID=$PHPSESSID"); die();}


//  LLama a la conexion a la BD
if(!$conexion=conectar()){die("No se conecto con la base de datos");}


?>