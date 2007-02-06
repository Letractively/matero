<?php
/************************************************************************
*                 Nombre Sistema:   tero.
*                  Nombre Script:   loguear.php
*                          Autor:   A.U.S. Sánchez, Guido S. - Angeletti, Mariano R.
*                 Fecha Creacion:   19-09-03.
*            Ultima Modificacion:   19-09-03.
*           Campos que lee en BD:   tabla administrador
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   realiza el logueo del usuario
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/

include("../includes/configuracion.php");
include("../includes/template.php");

if (!$conexion=conectar()){die("No se Conecto a la Base de Datos");}

/*if ($nick!="adm"&&$pass!="aaa")
{
header("Location:index.html");
      die();
} */

$vl_consulta_administrador=mysql_query("select *
           from administrador
           where nick='$vf_nick'
           and  pass=password('$vf_pass')");

if (!mysql_num_rows($vl_consulta_administrador))
 die(":-(");

//$ip_addr=$REMOTE_ADDR;
ini_alter("session.use_cookies","0");
session_start();
//session_register('ip_addr');
$logueado=1;
session_register('logueado');
//session_register('usuario_logueado');
$id=session_id();
//header("Location:intranet.php3?PHPSESSID=$id");
header("Location:menu.php?PHPSESSID=$id");
?>