<?php
/************************************************************************
*                 Nombre Sistema:   Matero
*                  Nombre Script:   usuario_mostrar.php
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

set_file("pagina","usuario_mostrar.html");

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
set_var("email",$elusuario["email"]);

//Obtengo las catedras
$vl_materias_usuario=mysql_query("select *
                               from catedra,usuario_catedra
                               where id_usuario=$idu and catedra.id_catedra=usuario_catedra.id_catedra");

// Si no tiene materias a cargo me muestra "NINGUNA".
if (!mysql_num_rows($vl_materias_usuario)){
    $vl_catedras="No tiene cátedras asociadas hasta el momento";
    set_var("catedra",$vl_catedras);
    parse("bloque_catedra","bloque_catedra",true);
    }
else{
    // Concatena todas las cátedras que tiene el usuario.
    while($vl_fila=mysql_fetch_array($vl_materias_usuario))
              {
              set_var("catedra",$vl_fila[nombre]);
              parse("bloque_catedra","bloque_catedra",true);
               }
    }


set_var("firma",firma());
parse("datos","datos",true);
pparse ("pagina");

?>