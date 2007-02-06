<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   seleccion_archivo_bd.php
*                          Autor:   A.U.S. Sánchez, Guido S. - Angeletti, Mariano R.
*                 Fecha Creacion:   19-09-04.
*            Ultima Modificacion:   19-09-04.
*           Campos que lee en BD:   tabla administrador
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   realiza el logueo del usuario
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

set_file("pagina","seleccion_archivo_bd.html");
set_var("mensaje","$mensaje");

set_var("firma",firma());
pparse("pagina");

?>