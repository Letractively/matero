<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   profesor_listado.php
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
							from profesor
							where id_catedra='$vs_id_catedra'
							and id_profesor='$idi'");

if (!mysql_num_rows($vl_consulta)){die("PROBLEMAS EN BD");}
else {
	set_file("pagina","profesor_modif.html");
$vl_fila=mysql_fetch_array($vl_consulta);
	set_var("nombre",$vl_fila[nombre]);
	set_var("apellido",$vl_fila[apellido]);
	set_var("email",$vl_fila[email]);		
	set_var("cargo",$vl_fila[cargo]);	
	set_var("idi",$vl_fila[id_profesor]);
	

	
}
set_var("mensaje",$mensaje);
set_var("firma",firma());
parse("datos","datos",true);
pparse("pagina");
?>