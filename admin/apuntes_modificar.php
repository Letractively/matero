<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   apuntes_modificaciones.php
*                          Autor:   Angeletti, Mariano R.
*                 Fecha Creacion:   19-09-03.
*            Ultima Modificacion:   19-09-03.
*           Campos que lee en BD:   tabla administrador
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   segun la accion que se haya iniciado, puede eliminar, guardad cambios de posicion o ir a la pantalla de agregar otro integrante
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

$vl_query=mysql_query("Select *
               from apuntes
               where id_apuntes=$ida");

if (!mysql_num_rows($vl_query)){
                                $vl_mensaje="No se encontr� el apunte.";
                                header("Location:apuntes_listado.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
                                die();
                                }
else {
$vl_fila=mysql_fetch_array($vl_query);
set_file("pagina","apunte_modificar.html");
set_var("mensaje",$mensaje);

set_var("titulo", $vl_fila[titulo]);
set_var("archivo",$vl_fila[nombre_archivo]);
set_var("comentario", $vl_fila[descripcion]);

set_var("ida",$ida);
set_var("firma", firma());
parse("bloque", "bloque", true);
pparse("pagina");

}
?>