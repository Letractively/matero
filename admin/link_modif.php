<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   link_modif.php
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
							from links
							where id_catedra='$vs_id_catedra'
							and id_link ='$idi'");

if (!mysql_num_rows($vl_consulta)){die("PROBLEMAS EN BD");}
else {
	set_file("pagina","link_modif.html");
$vl_fila=mysql_fetch_array($vl_consulta);
	set_var("nombre",$vl_fila[nombre]);
	set_var("descri",$vl_fila[descripcion]);
	set_var("url",$vl_fila[url]);	
	set_var("idi",$vl_fila[id_link]);
	$vl_link_tipo=$vl_fila[id_link_tipo];
/////////// 
$vl_query=mysql_query("Select *
						from link_tipo
						where id_catedra = '$vs_id_catedra'");
	while ($vl_row=mysql_fetch_array($vl_query))
	{
	set_var("idt",$vl_row[id_link_tipo]);
	set_var("tipo",$vl_row[nombre]);
	if ($vl_link_tipo==$vl_row[id_link_tipo]) set_var("chek","selected");
	else set_var("chek","");
	parse("link","link",true);
	}						

}
set_var("mensaje",$mensaje);
set_var("firma",firma());
parse("datos","datos",true);
pparse("pagina");
?>