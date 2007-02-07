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
session_start();
include("../includes/configuracion.php");
include("../includes/template.php");

echo "ttttttttt";


getpost_ifset();

if (!$conexion=conectar()){die("No se Conecto a la Base de Datos");}

/*if ($nick!="adm"&&$pass!="aaa")
{
header("Location:index.html");
      die();
} */
$sql = "select *
           from administrador
           where nick='$vf_nick'
           and  pass=password('$vf_pass')";
echo $sql;

$vl_consulta_administrador=mysql_query($sql);


if (!mysql_num_rows($vl_consulta_administrador))
 die(":-(");


$_SESSION['usuario_logueado'] = $usuario_logueado['id_usuario'];
$_SESSION['logueado']=1;
$_SESSION['ip_addr']=$ip_addr;

$id=session_id();

header("Location:menu.php?PHPSESSID=$id");
?>