<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   profesor_alta.php
*                          Autor:   Angeletti, Mariano R.
*                 Fecha Creacion:   19-09-03.
*            Ultima Modificacion:   19-09-03.
*           Campos que lee en BD:   tabla administrador
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   realiza el logueo del usuario
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");



set_file("pagina","profesor_alta.html");

set_var("nombre","");
set_var("apellido","");
set_var("cargo","");
set_var("email","");
set_var("menu",$menu);
set_var("mensaje",$mensaje);
set_var("firma",firma());
parse("datos","datos",true);

pparse("pagina");
?>