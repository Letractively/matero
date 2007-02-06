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
set_var("mensaje","");
set_var("idu",$idu);
//Obtengo los datos del usuario a mostrar
$usu=mysql_query("select nombre, apellido, nick
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
parse("bloque_datos_usuarios","bloque_datos_usuarios",true);
// Obtengo las catedras que el usuario administra
$vl_usuario_administra=mysql_query("select id_catedra
                               from usuario_catedra
                               where id_usuario='$idu'
                               ");
$vl_array_administra=array();
if (!mysql_num_rows($vl_usuario_administra)){
             $vl_catedras='No tiene asignada ninguna cátedra';
             }
else{
     while($vl_fila=mysql_fetch_array($vl_usuario_administra)){
     array_push($vl_array_administra,$vl_fila[id_catedra]);
     }
}


//Obtengo las catedras
$vl_materias_usuario=mysql_query("select nombre, id_catedra
                               from catedra order by nombre asc
                               ");

// Si no tiene materias a cargo me muestra "NINGUNA".
if (!mysql_num_rows($vl_materias_usuario)){
    $vl_catedras="NINGUNA";
    }
else{
    // Concatena todas las cátedras que tiene el usuario.
    while($vl_fila=mysql_fetch_array($vl_materias_usuario))
              {
              set_var("catedra",$vl_fila[nombre]);
              set_var("id_catedra",$vl_fila[id_catedra]);
              if (in_array($vl_fila[id_catedra],$vl_array_administra)){set_var("selected_$vl_fila[id_catedra]","selected");}
              else {set_var("elegido","");}
              parse("bloque_carreras","bloque_carreras",true);
              }
    }

set_var("mensaje",$vl_catedras);
set_var("firma",firma());

pparse ("pagina");

?>