<?php
/************************************************************************
*                 Nombre Sistema:   tero.
*                  Nombre Script:   loguear.php
*                          Autor:   A.U.S. S�nchez, Guido S. 
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

getpost_ifset();


if (!$conexion=conectar()){die("No se Conecto a la Base de Datos");}
$a = $vf_nick;
$sql = "select *
           from usuario
           where nick='$vf_nick'
           and  pass=password('$vf_pass')";
$vl_consulta_administrador=mysql_query($sql);


if (!mysql_num_rows($vl_consulta_administrador))  {
header ("Location:index.php?mensaje=No pudo loguearse correctamente. Verifique su nick o contrase�a.$a");
die;                                  }


$usuario_logueado=mysql_fetch_array($vl_consulta_administrador);
$usuario_logueado["pass"] = "";


$ip_addr=$REMOTE_ADDR;
ini_alter("session.use_cookies","0");
session_start();

$_SESSION['usuario_logueado'] = $usuario_logueado['id_usuario'];
$_SESSION['logueado']=1;
$_SESSION['ip_addr']=$ip_addr;

$id=session_id();

header("Location:catedra_seleccionar.php?PHPSESSID=$id");
?>