<?php

/************************************************************************
*                 Nombre Sistema:   Virtual Cátedra.
*                  Nombre Script:   hacer_alta_usuario.php
*                          Autor:   Guido S., Mariano A
*                 Fecha Creacion:   19-09-03.
*            Ultima Modificacion:   19-09-03.
*           Campos que lee en BD:   tabla usuario
*      Campos que Modifica en BD:   tabla usuario
*  Descripcion de funcionamiento:   hace el alta de usuario y valida los datos
*              Funciones que usa:   funciones de validación, otras
*                Que falta Hacer:   listo.-
*       Validaciones que realiza:   is_email, nombre, apellido, password, que no se repita el nick, etc.
************************************************************************/

//Incluye archivos de seguridad
include ("seguridad_intranet.php");

$vl_error=0;
//Valido los datos

//Valido el email
if (!is_email($vf_email) && ($vf_email!=""))
   {$vl_mensaje_error.="Se ha ingresado un email incorrecto<br>";
   $vl_error=1;
   }

//Valido el nombre
if (!is_alpha($vf_nombre,2,80))
   {$vl_mensaje_error.="Se ha ingresado un nombre incorrecto<br>";
   $vl_error=1;
   }

//Valido el apellido
if (!is_alpha($vf_apellido,2,80))
   {$vl_mensaje_error.="Se ha ingresado un apellido incorrecto<br>";
   $vl_error=1;
   }

//Valido la password
if (!is_alphanumeric($vf_pass,6,60))
   {$vl_mensaje_error.="Se ha ingresado una password incorrecta<br>";
   $vl_error=1;
   }

//Valido el que el nick no se repita
$vl_busco=mysql_query("select id_usuario from usuario where nick='$vf_nick'");
if(mysql_num_rows($vl_busco))
   {$vl_mensaje_error.="Se ha ingresado un nick repetido<br>";
   $vl_error=1;
   }

//Valido el nick
if (!is_alphanumeric($vf_nick,6,15))
   {$vl_mensaje_error.="Se ha ingresado un nick incorrecto<br>";
   $vl_error=1;
   }




//Acá entra si hubo algún error
if ($vl_error){
        set_file("pagina","usuario_alta.html");
        set_var("mensaje",$vl_mensaje_error);
        set_var("vf_nombre",$vf_nombre);
        set_var("vf_apellido",$vf_apellido);
        set_var("vf_email",$vf_email);
        set_var("vf_nick",$vf_nick);
        set_var("vf_pass",$vf_pass);
        set_var("firma",firma());
        parse("datos","datos",true);
        pparse("pagina");
        die();
}
//Acá entra si todos los datos fueron correctos
mysql_query("insert into usuario values ('NULL',
                                             '$vf_nick',
                                              password('$vf_pass'),
                                             '$vf_email',
                                             '$vf_nombre',
                                             '$vf_apellido')");

if ($accion!="Guardar"){$vl_script="usuario_alta";}
else {$vl_script="menu";}
//Mensaje de exito
$texto="Se ha ingresado al usuario ".negrita($apellido)." ".negrita($nombre)." satisfactoriamente";
header("Location:$vl_script.php?PHPSESSID=$PHPSESSID&mensaje=$texto");
?>