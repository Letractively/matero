<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   profesor_hacer_modif.php
*                          Autor:   Angeletti, Mariano R.
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


$vl_error=0;
//Valido los datos

//Valido el email
if (!is_email($vf_email) && ($vf_email!=""))
   {$vl_mensaje_error.="Se ha ingresado un email incorrecto<br>";
   $vl_error=1;
   }

//Valido el nombre
if (!is_alpha($vf_nombre,2,200) || ($vf_nombre==""))
   {$vl_mensaje_error.="Se ha ingresado un nombre incorrecto<br>";
   $vl_error=1;
   }

//Valido el apellido
if (!is_alpha($vf_apellido,2,200) || ($vf_apellido==""))
   {$vl_mensaje_error.="Se ha ingresado un apellido incorrecto<br>";
   $vl_error=1;
   }

//Valido el apellido
if (!is_alphanumeric($vf_cargo,2,250) || ($vf_cargo==""))
   {$vl_mensaje_error.="Se ha ingresado un cargo incorrecto<br>";
   $vl_error=1;
   }



if($vl_error=='1'){
set_file("pagina","profesor_modif.html");
set_var("nombre",$vf_nombre);
set_var("apellido",$vf_apellido);
set_var("cargo",$vf_cargo);
set_var("email",$vf_email);

set_var("mensaje",$vl_mensaje_error);
set_var("firma",firma());
parse("datos","datos",true);
pparse("pagina");
die;
}

if (mysql_query("UPDATE profesor set
                                                        nombre='$vf_nombre',
                                                        apellido='$vf_apellido',
                                                        cargo='$vf_cargo',
                                                        email='$vf_email'
                                                WHERE id_catedra='$vs_id_catedra'
                                                and id_profesor='$idi'")){
                                                        $vl_mensaje="Se ingres� un integrante de c�tedra exitosamente";

                                                        }
else{
        $vl_mensaje="Se modific� un integrante de c�tedra exitosamente";
}



header("Location:profesor_listado.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
?>