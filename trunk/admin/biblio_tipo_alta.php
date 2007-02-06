<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   biblio_tipo_alta.php
*                          Autor:   Angeletti, Mariano
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

set_file("pagina","biblio_tipo_alta.html");

set_var("nombre","");
set_var("descri","");
set_var("mensaje","$mensaje");
set_var("firma",firma());
set_var("menu",$menu);
parse("datos","datos",true);
pparse("pagina");
?>