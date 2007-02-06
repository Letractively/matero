<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   menu.php
*                          Autor:   A.U.S. Sánchez, Guido S. 
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

set_file("pagina","menu.html");
set_var("mensaje","$mensaje");

/*if (isset($vf_id_comision)){
	if ($vf_id_comision!='0')
		if (!isset($vs_id_comision)){
			$vs_id_comision=$vf_id_comision;
			session_register("vs_id_comision");
		}
		else $vs_id_comision=$vf_id_comision;
	else  {
		session_unregister("vs_id_comision");
		unset($vs_id_comision);
	}
}*/



// busco la cátedra
$vl_consulta=mysql_query("Select *
               from catedra
               where id_catedra='$vs_id_catedra'");
  
//borrar
/*             
$vl_consulta=mysql_query("Select *
               from catedra
               where id_catedra='178'");
  */             
               
$vl_fila=mysql_fetch_array($vl_consulta);
if (mysql_num_rows($vl_consulta)){
	set_var("nombre_catedra",$vl_fila[nombre]);
	set_var("idc",$vs_id_catedra); // borrar porque lo reeplase agregandolo a la sesion
	// busco las comisiones de la catedra
	/*$vl_consulta_comision=mysql_query("SELECT * FROM comision WHERE id_catedra=$vs_id_catedra and activa='1'");
	if (mysql_num_rows($vl_consulta_comision)){ 
		set_var("ocultar_listado","");
		set_var("ocultar_listado1","");
		while($vl_fila_comision=mysql_fetch_array($vl_consulta_comision)){
			if (isset($vs_id_comision)&&($vs_id_comision==$vl_fila_comision[id_comision]))	set_var("selected","selected");
			else set_var("selected","");
			set_var("nombre","$vl_fila_comision[nombre]");
			set_var("id_comision","$vl_fila_comision[id_comision]");
			set_var("sesion","$PHPSESSID");
			parse("bloque_listado","bloque_listado",true);
		} 
	}
	else{
		set_var("ocultar_listado","<!--");
		set_var("ocultar_listado1","-->");
	}*/
	
	
	
	set_var("firma",firma());
	pparse("pagina");
}
else {die("error con la catedra");}

?>