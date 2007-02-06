<?php
/*
if ( !isset($_SERVER['HTTPS']) || strtolower($_SERVER['HTTPS']) != 'on' ) {
   header ('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
   exit();
};*/
include("../includes/validacion.php");
include("../includes/configuracion.php");
include("../includes/template.php");
ini_alter("session.use_cookies","0");
session_start();

if(isset($vf_volver)){header("Location:menu.php?PHPSESSID=$PHPSESSID"); die();}
if(isset($vf_redirigir)){header("Location:$vf_donde_redirigir"."PHPSESSID=$PHPSESSID"); die();}

if ((!session_is_registered('logueado')) || ($logueado!=1)){
session_unset();
session_destroy();
header("Location:index.php");
die();
}

if(!$conexion=conectar()){die("No se conecto con la base de datos");}


?>