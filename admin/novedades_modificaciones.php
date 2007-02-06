<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   apunte_alta.php
*                          Autor:   Angeletti, Mariano R.
*                 Fecha Creacion:   7-11-03.
*            Ultima Modificacion:   7-11-03.
*           Campos que lee en BD:   tabla administrador
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   realiza el logueo del usuario
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");
$vl_query=mysql_query("Select * FROM novedades where id_novedades = '$idn'");

if (!mysql_num_rows($vl_query)) { header("Location:menu.php?PHPSESSID=$PHPSESSID");
									die;}

$vl_fila=mysql_fetch_array($vl_query);
set_file("pagina","novedades_modificar.html");

set_var("titulo",$vl_fila[titulo]);
set_var("comentario",$vl_fila[contenido]);
set_var("idn",$idn);


set_var("mensaje","");
set_var("firma",firma());
parse("bloque","bloque",true);

pparse("pagina");
?>