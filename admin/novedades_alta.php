<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   novedades_alta.php
*                          Autor:   Angeletti, Mariano R.
*                 Fecha Creacion:   29-01-04.
*            Ultima Modificacion:   29-01-04.
*           Campos que lee en BD:   tabla novedades
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   ninguna
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");



set_file("pagina","novedades_alta.html");

set_var("titulo","");
set_var("comentario","");
set_var("menu",$menu);


set_var("mensaje","");
set_var("firma",firma());
parse("bloque","bloque",true);

pparse("pagina");
?>