<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   alumnos_alta.php
*                          Autor:   A.U.S. Sánchez, Guido S. 
*                 Fecha Creacion:   27-01-04.
*            Ultima Modificacion:   27-01-04.
*           Campos que lee en BD:   
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   inicializa el template de alta de alumnos
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

set_file("pagina","consultas.html");

set_var("asunto","");
set_var("cuerpo","");


set_var("mensaje","$mensaje");
set_var("firma",firma());
parse("datos","datos",true);
pparse("pagina");
?>