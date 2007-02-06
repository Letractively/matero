<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   biblio_tipo_listado.php
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

$vl_consulta=mysql_query("Select *	
							from biblio_tipo
							where id_catedra='$vs_id_catedra'");

if (!mysql_num_rows($vl_consulta)){
								$vl_mensaje="ERROR: No existen tipos de bibliografías cargadas";
								header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");

								die;}
else {
	set_file("pagina","biblio_tipo_listado.html");
	while ($vl_fila=mysql_fetch_array($vl_consulta)){
	set_var("nombre",$vl_fila[nombre]);
	set_var("idi",$vl_fila[id_biblio_tipo]);
	parse("tipo","tipo",true);

	}
}
set_var("mensaje",$mensaje);
set_var("firma",firma());
parse("datos","datos",true);
pparse("pagina");
?>