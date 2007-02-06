<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   link_listado.php
*                          Autor:   Angeletti, Mariano R.
*                 Fecha Creacion:   19-09-03.
*            Ultima Modificacion:   19-09-03.
*           Campos que lee en BD:   tabla administrador
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   realiza el logueo del usuario
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

$vl_consulta=mysql_query("Select id_link, links.nombre as nombre, link_tipo.nombre as nombre_tipo	
							from links, link_tipo
							where links.id_catedra='$vs_id_catedra'
							and links.id_link_tipo = link_tipo.id_link_tipo");

if (!mysql_num_rows($vl_consulta)){
								$vl_mensaje="ERROR: No existen links cargados";
								header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");

								die;}
else {
	set_file("pagina","link_listado.html");
	while ($vl_fila=mysql_fetch_array($vl_consulta)){
	set_var("nombre",$vl_fila[nombre]);
	set_var("nombre_tipo",$vl_fila[nombre_tipo]);
	set_var("idi",$vl_fila[id_link]);
	parse("tipo","tipo",true);

	}
}
set_var("mensaje",$mensaje);
set_var("firma",firma());
parse("datos","datos",true);
pparse("pagina");
?>