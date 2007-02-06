<?php
/************************************************************************
*                 Nombre Sistema:   Matero
*                  Nombre Script:   alta_usuario.php
*                          Autor:   Guido S., Mariano A.
*                 Fecha Creacion:   19-09-03.
*            Ultima Modificacion:   19-09-03.
*           Campos que lee en BD:   tabla usuario
*      Campos que Modifica en BD:   Ninguna
*  Descripcion de funcionamiento:   inicializa el template alta_usuario.
*              Funciones que usa:
*                Que falta Hacer:   nada.-
*
************************************************************************/
//Incluye archivos de seguridad
include ("seguridad_intranet.php");

set_file("pagina","alta_usuario.html");

set_var("mensaje","");
set_var("vf_nombre","");
set_var("vf_nick","");
set_var("vf_pass","");
set_var("vf_apellido","");
set_var("vf_email","");
parse("datos","datos",true);
set_var("firma",firma());
pparse ("pagina");
?>