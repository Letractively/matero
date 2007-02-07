<?php
/*
if ( !isset($_SERVER['HTTPS']) || strtolower($_SERVER['HTTPS']) != 'on' ) {
   header ('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
   exit();
};*/

session_start();
include("../includes/validacion.php");
include("../includes/configuracion.php");
include("../includes/template.php");
ini_alter("session.use_cookies","0");
//ini_alter("session.use_trans_sid","1");



getpost_ifset();

if(isset($vf_volver)){header("Location:menu.php?PHPSESSID=$PHPSESSID"); die();}
if(isset($vf_redirigir)){header("Location:$vf_donde_redirigir"."PHPSESSID=$PHPSESSID"); die();}


// Si no esta el usuario logueado lo saca del sistema
if ( !$_SESSION['logueado'] || ($_SESSION['logueado']!=1)){
		session_unset();
		session_destroy();

		header("Location:index.php");
		die("");
}

if(!$conexion=conectar()){
	die("No se conecto con la base de datos");
}
?>