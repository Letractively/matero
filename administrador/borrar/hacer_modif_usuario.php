<?php
/************************************************************************
*                 Nombre Sistema:   Virtual C�tedra.
*                  Nombre Script:   hacer_mdif_usuario.php3
*                          Autor:   Guido Sanchez, Mariano Angeletti
*                 Fecha Creacion:   11-10-03.
*            Ultima Modificacion:   11-10-03.
*           Campos que lee en BD:   tabla usuario
*      Campos que Modifica en BD:   tabla usuario
*  Descripcion de funcionamiento:   modifica y valida los datos del usuario.
*              Funciones que usa:   funciones de validaci�n, otras
*                Que falta Hacer:   listo.-
*       Validaciones que realiza:   is_email, nombre, apellido, password, que no se repita el nick, etc.
************************************************************************/

//Incluye archivos de seguridad
include ("seguridad_intranet.php");

$error=0;
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



//Ac� entra si hubo alg�n error
if ($error){
        set_file("pagina","modif_usuario.html");
        set_var("mensaje","$vl_mensaje_error");
        set_var("nombre",$vf_nombre);
        set_var("apellido",$vf_apellido);
        set_var("email",$vf_email);
        set_var("nick",$vf_nick);
        set_var("idu",$idu);
        parse("datos","datos",true);
        set_var("firma",firma());
        pparse("pagina");
        die();
}

//Ac� entra si todos los datos fueron correctos
mysql_query("update usuario     set nick='$vf_nick',
                                    email='$vf_email',
                                    apellido='$vf_apellido',
                                    nombre='$vf_nombre',
                                    pass='$vf_pass'
                                    where id_usuario=$idu");


//Mensaje de exito
$mensaje="Modificaci�n exitosa de Usuario";
header("location:lista_usuarios.php?mensaje=$mensaje");
?>