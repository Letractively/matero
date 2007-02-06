<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   comision_alta.php
*                          Autor:   A.U.S. Sánchez, Guido S. 
*                 Fecha Creacion:   01-11-03.
*            Ultima Modificacion:   01-11-03.
*           Campos que lee en BD:   
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   inicializa el template de alta
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

set_file("pagina","comision_alta.html");

set_var("nombre","");
set_var("fecha_alta",date("d-m-Y"));
set_var("mensaje","");
set_var("firma",firma());
parse("datos","datos",true);

pparse("pagina");
?>