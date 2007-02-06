<?php
/************************************************************************
*                 Nombre Sistema:   Virtual Cátedra.
*                  Nombre Script:   modificar_usuario.php3
*                          Autor:   AUSTRAL Guido S. Sánchez, Angeletti Mariano
*                 Fecha Creacion:   11-06-02.
*            Ultima Modificacion:   18-06-02.
*           Campos que lee en BD:   tabla usuario
*      Campos que Modifica en BD:   tabla usuario
*  Descripcion de funcionamiento:   inicializa los campos del template de modificar usuario
*              Funciones que usa:   funciones de mysql, otras
*                Que falta Hacer:   listo.-
*       Validaciones que realiza:   ninguna.
************************************************************************/


//Incluye archivos de seguridad
include ("seguridad_intranet.php");

//Obtengo los datos del usuario
$result=mysql_query("select *
                     from usuario
                     where id_usuario=$idu");

//Aca entra si no se encontro el usuario
if (!mysql_num_rows($result)){
                            $vl_mensaje="Problemas en BD en Usuario";
                            header("Location:usuario_administrador.php?mensaje=$vl_mensaje");
                            die();
                            }


$fila=mysql_fetch_array($result);
set_file("pagina","usuario_modif.html");

set_var("idu",$idu); //id del usuario
set_var("mensaje","");
set_var("vf_nombre",$fila["nombre"]);
set_var("vf_nick",$fila["nick"]);
set_var("vf_apellido",$fila["apellido"]);
set_var("vf_email",$fila["email"]);
set_var("firma",firma());

parse("datos","datos",true);

pparse ("pagina");
?>