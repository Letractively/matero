<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   menu.php
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

$size_max_archivo_cont=1048576; //la utilizamos para validar el tamaño del archivo de contenido(1MB en bytes)

set_file("pagina","catedra_plan_modif.html");
$vl_consulta=mysql_query("Select *
                          from catedra_plan
                          where id_catedra='$vs_id_catedra'");
if(!mysql_num_rows($vl_consulta)){
                                  if($vs_id_catedra!=""){
                                  mysql_query("Insert into catedra_plan(
                                                      id_catedra_plan,
                                                      id_catedra,
                                                      contenido,
                                                      nombre_archivo
                                                      )values(
                                                      'NULL',
                                                      '$vs_id_catedra',
                                                      '',
                                                      ''
													  )");
                                  set_var("plan","");
								  set_var("archivo","");								  
                                  set_var("mensaje","");
                                  set_var("firma",firma());
                                  parse("bloque","bloque",true);}
}
else
{
	$vl_fila=mysql_fetch_array($vl_consulta);

	set_var("plan",$vl_fila[contenido]);
	set_var("archivo",$vl_fila[nombre_archivo]);
	set_var("archivo_anterior",$vl_fila[nombre_archivo]);
	set_var("mensaje","$mensaje");
	set_var("firma",firma());
	parse("bloque","bloque",true);
}

pparse("pagina");










?>