<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   catedra_seleccionar.php
*                          Autor:   A.U.S. Sánchez, Guido S. 
*                 Fecha Creacion:   19-09-03.
*            Ultima Modificacion:   19-09-03.
*           Campos que lee en BD:   tabla catedras
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   setea el listado desplegable con las càtedras del usuario
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

set_file("pagina","catedra_seleccionar.html");

$vl_consulta=mysql_query("Select *
                          from usuario_catedra, catedra
                          where usuario_catedra.id_usuario=$usuario_logueado[id_usuario]
                          and catedra.id_catedra=usuario_catedra.id_catedra");


if(!mysql_num_rows($vl_consulta)){die("No tiene cátedras asignadas. Contacte al administrador de MaTero");}
else {
      while($vl_fila=mysql_fetch_array($vl_consulta)){
      set_var("nombre",$vl_fila[nombre]);
      set_var("idc",$vl_fila[id_catedra]);
      parse("bloque_catedra","bloque_catedra",true);
      }
}
set_var("PHPSESSID",$PHPSESSID);
set_var("mensaje","$mensaje");
set_var("firma",firma());
parse("bloque_logueo","bloque_logueo",true);
pparse("pagina");

?>