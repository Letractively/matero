<?php
/************************************************************************
*                 Nombre Sistema:   Virtual Cátedra.
*                  Nombre Script:   lista_usuarios.php
*                          Autor:   Mariano Angeleti
*                 Fecha Creacion:   11-06-02.
*            Ultima Modificacion:   18-06-02.
*           Campos que lee en BD:   tabla usuario y catedra
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   hace el listado de usuarios y muestra las cátedras a su cargo
*              Funciones que usa:   funciones de mysql, otras
*                Que falta Hacer:   listo.-
*       Validaciones que realiza:   ninguna.
************************************************************************/


//Incluye archivos de seguridad
include ("seguridad_intranet.php");

set_file("pagina","usuarios_administrador.html");
set_var("mensaje",$mensaje);
//Selecciono los usuarios
$usuarios=mysql_query("select id_usuario, nombre, apellido
                       from usuario
                       order by apellido, nombre");

//Aca entra si no se encontraron usuarios
if(!mysql_num_rows($usuarios))
    {
   $vl_texto="No existen Usuarios en BD";
    header("Location:menu.php?mensaje=$vl_texto");
    die();
    }

$renglon = 0;    //$renglon se usa para controlar el estilo de cada renglon
while($fila=mysql_fetch_array($usuarios)){
      if ($renglon % 2) {
           set_var("estilo", "tabla_cuerpo2");
           }
       else{
            set_var("estilo", "tabla_cuerpo");
            };
       $renglon++;
       set_var("idu",$fila["id_usuario"]);
       set_var("usuario",$fila["apellido"].", ".$fila["nombre"]);
       parse("listausuarios","listausuarios",true);
       };


set_var("firma",firma());

pparse ("pagina");
?>