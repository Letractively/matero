<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   biblio_alta.php
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

$vl_query=mysql_query("Select *
						from biblio_tipo
						where id_catedra= '$vs_id_catedra'");
if (!mysql_num_rows($vl_query))						
								{
								$vl_mensaje="No puede agregar bibliografía porque no tiene ningún <b>tipo de bibliografia</b> dado de alta";
								header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
								die;
								}
set_file("pagina","biblio_alta.html");

while ($vl_fila=mysql_fetch_array($vl_query))
 	{
	set_var("idt",$vl_fila[id_biblio_tipo]);
	set_var("tipo",$vl_fila[nombre]);
	parse("link","link",true);	
 	}
set_var("nombre","");
set_var("descri","");
set_var("mensaje","$mensaje");
set_var("firma",firma());
set_var("menu",$menu);
parse("datos","datos",true);
pparse("pagina");
?>