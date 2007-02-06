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



set_file("pagina","apunte_alta.html");

set_var("titulo","");
set_var("comentario","");
set_var("nombre_archivo","");


set_var("mensaje","");
set_var("firma",firma());
parse("bloque","bloque",true);

pparse("pagina");
?>