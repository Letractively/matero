<?php
/************************************************************************
*                 Nombre Sistema:   Matero
*                  Nombre Script:   alta_usuario.php
*                          Autor:   Guido S., Mariano A.
*                 Fecha Creacion:   19-09-03.
*            Ultima Modificacion:   19-09-03.
*           Campos que lee en BD:   tabla usuario
*      Campos que Modifica en BD:   Ninguna
*  Descripcion de funcionamiento:   inicializa el template alta_usuario.
*              Funciones que usa:
*                Que falta Hacer:   nada.-
*
************************************************************************/

//Incluye archivos de seguridad
include ("seguridad_intranet.php");

set_file("pagina","lista_correo.html");

set_var("mensaje",$mensaje);
set_var("vf_asunto","");
$buscar=mysql_query("SELECT * FROM usuario ORDER BY apellido");
while($vl_fila=mysql_fetch_array($buscar)){
	set_var("id_usuario",$vl_fila['id_usuario']);
	$nombre=$vl_fila['apellido'].", ".$vl_fila['nombre'];
	set_var("nombre",$nombre);
	parse("usuario","usuario",true);
}

set_var("vf_texto","");
set_var("firma",firma());
parse("datos","datos",true);
pparse ("pagina");
?>