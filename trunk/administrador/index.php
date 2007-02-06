<?php
/************************************************************************
*                 Nombre Sistema:   tero.
*                  Nombre Script:   index.php
*                          Autor:   A.U.S. Sánchez, Guido S.
*                 Fecha Creacion:   19-09-03.
*            Ultima Modificacion:   19-09-03.
*           Campos que lee en BD:   tabla administrador
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   setea el template del logueo
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
/*
//if (!$HTTP_SERVER_VARS['HTTPS']) {
if ( !isset($_SERVER['HTTPS']) || strtolower($_SERVER['HTTPS']) != 'on' ) {
   header ('Location: https://'.$_SERVER['HTTP_HOST'].$_SERVER['REQUEST_URI']);
   exit();
};
//}*/

include("../includes/configuracion.php");
include("../includes/template.php");

set_file("pagina","index.html");

set_var("mensaje","");
set_var("nick","");
set_var("pass","");
parse("bloque_logueo","bloque_logueo",true);
set_var("firma",firma());
pparse ("pagina");
?>