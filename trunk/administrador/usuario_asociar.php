<?php
/************************************************************************
*                 Nombre Sistema:   Matero
*                  Nombre Script:   usuario_asociar.php
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

set_file("pagina","usuarios_asociar.html");

//Obtengo los datos del usuario a mostrar
$usu=mysql_query("select nombre, apellido, email, nick
                  from usuario
                  where id_usuario=$idu");

//Aca entra si no se encontro el usuario
if (!mysql_num_rows($usu)){
                            $vl_mensaje="No se encontró al usuario en BD";
                            header("Location:usuario_administrador.php?mensaje=$vl_mensaje");
                            die();
                          }
$elusuario=mysql_fetch_array($usu);
set_var("nombre",$elusuario["nombre"]);
set_var("apellido",$elusuario["apellido"]);
set_var("usuario",strtoupper($elusuario["apellido"]).", ".$elusuario["nombre"]);
set_var("nick",$elusuario["nick"]);

//Obtengo las catedras
$vl_materias_usuario=mysql_query("select nombre, id_catedra
                               from catedra
                               where id_usuario=$idu");

// Si no tiene materias a cargo me muestra "NINGUNA".
if (!mysql_num_rows($vl_materias_usuario)){
    $vl_catedras="NINGUNA";
    }
else{
    // Concatena todas las cátedras que tiene el usuario.
    while($vl_fila=mysql_fetch_array($vl_materias_usuario))
              {
              set_var("vf_catedra",$vl_fila[nombre]);
              set_var("vf_idc",$vl_fila[id_catedra]);
              }
    }

set_var("catedra",$catedras);
set_var("firma",firma());
parse("datos","datos",true);
pparse ("pagina");

?>