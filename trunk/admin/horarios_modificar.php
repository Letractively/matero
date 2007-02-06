<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   horarios_modificar.php
*                          Autor:   Angeletti, Mariano R.
*                 Fecha Creacion:   7-11-03.
*            Ultima Modificacion:   7-11-03.
*           Campos que lee en BD:   tabla horarios
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");




$vl_query=mysql_query("Select * from horarios where id_catedra='$vs_id_catedra'");

set_file("pagina","horarios_modificar.html");

if(!mysql_num_rows($vl_query)){
                                  if($vs_id_catedra!=""){
                                  mysql_query("Insert into horarios(
                                                      id_catedra,
                                                      horarios
                                                      )values(
                                                      '$vs_id_catedra',
                                                      '')");
                                  set_var("horario","");
                                  set_var("mensaje","");
                                  set_var("firma",firma());
                                  parse("bloque","bloque",true);}
								  }
else {
	$vl_fila=mysql_fetch_array($vl_query);
	set_var("mensaje",$mensaje);
	set_var("horario",$vl_fila[horarios]);
	set_var("firma",firma());
	parse("bloque","bloque",true);
}
pparse("pagina");
?>