<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   biblio_listado.php
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

$vl_consulta=mysql_query("Select id_biblio, biblio.nombre as nombre, biblio_tipo.nombre as nombre_tipo	
							from biblio, biblio_tipo
							where biblio.id_catedra='$vs_id_catedra'
							and biblio.id_biblio_tipo = biblio_tipo.id_biblio_tipo");

if (!mysql_num_rows($vl_consulta)){
								$vl_mensaje="ERROR: No hay bibliografía cargada";
								header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");

								die;}
else {
	set_file("pagina","biblio_listado.html");
	while ($vl_fila=mysql_fetch_array($vl_consulta)){
	set_var("nombre",$vl_fila[nombre]);
	set_var("nombre_tipo",$vl_fila[nombre_tipo]);
	set_var("idi",$vl_fila[id_biblio]);
	parse("tipo","tipo",true);

	}
}
set_var("mensaje",$mensaje);
set_var("firma",firma());
parse("datos","datos",true);
pparse("pagina");
?>