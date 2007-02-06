<?php
/************************************************************************
*                 Nombre Sistema:   Matero
*                  Nombre Script:   pass_modif.php
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

//Obtengo los datos del usuario
$result=mysql_query("select nombre
                     from usuario
                     where id_usuario='$usuario_logueado[id_usuario]'");

//Aca entra si no se encontro el usuario
if (!mysql_num_rows($result)){
							$mensaje="Problemas en el cambio del password";
                            header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$mensaje");
                            die();
                            }


set_file("pagina","pass_modif.html");

set_var("mensaje","");
set_var("vf_passactual","");
set_var("vf_passnueva","");
set_var("vf_confirmacion","");
set_var("idu",$idu);

set_var("firma",firma());

parse("datos","datos",true);

pparse ("pagina");
?>