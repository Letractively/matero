<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   final_alta.php
*                          Autor:   Angeletti, Mariano R - Omar, Dario A.
*                 Fecha Creacion:   27-01-04.
*            Ultima Modificacion:   27-01-04.
*           Campos que lee en BD:   examen_final
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   realiza el logueo del usuario
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");



set_file("pagina","final_alta.html");

set_var("titulo","");
set_var("comentario","");
 $vl_mes=date("n");
set_var("anio",date("Y"));
set_var("selected_mes$vl_mes","selected");
set_var("dia",date("d"));
set_var("hora","17");
set_var("min","00");
set_var("menu",$menu);


set_var("mensaje",$mensaje);
set_var("firma",firma());
parse("bloque","bloque",true);

pparse("pagina");
?>