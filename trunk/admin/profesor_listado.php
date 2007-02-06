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
							where id_catedra='$vs_id_catedra'");

if (!mysql_num_rows($vl_consulta)){
								$vl_mensaje="ERROR: No existen integrantes cargados";
								header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");

								die;}
else {
	set_file("pagina","profesor_listado.html");
	while ($vl_fila=mysql_fetch_array($vl_consulta)){
	set_var("integrante",$vl_fila[apellido].", ".$vl_fila[nombre]);
	set_var("pos",$vl_fila[posicion]);
	set_var("idi",$vl_fila[id_profesor]);
	parse("profe","profe",true);

	}
}
set_var("mensaje",$mensaje);
set_var("firma",firma());
parse("datos","datos",true);
pparse("pagina");
?>