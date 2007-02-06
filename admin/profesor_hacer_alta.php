<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   profesor_alta.php
*                          Autor:  Angeletti, Mariano R.
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

//Valido el cargo
if (!is_alphanumeric($vf_cargo,2,250) || ($vf_cargo==""))
   {$vl_mensaje_error.="Se ha ingresado un cargo incorrecto<br>";
   $vl_error=1;
   }



if($vl_error=='1'){
set_file("pagina","profesor_alta.html");
set_var("nombre",$vf_nombre);
set_var("apellido",$vf_apellido);
set_var("cargo",$vf_cargo);
set_var("email",$vf_email);
set_var("menu",$vf_menu);

set_var("mensaje",$vl_mensaje_error);
set_var("firma",firma());
parse("datos","datos",true);
pparse("pagina");
die;
}

if (mysql_query("Insert into profesor(
							id_profesor,
							id_catedra,
							nombre,
							apellido,
							cargo,
							email)
							values(
							'NULL',
							'$vs_id_catedra',
							'$vf_nombre',
							'$vf_apellido',
							'$vf_cargo',
							'$vf_email')")){
							$vl_mensaje="El integrante:$vf_nombre $vf_apellido fue agregado exitosamente";
										
							}
else{
	$vl_mensaje="ERROR: El integrante:$vf_nombre $vf_apellido no se pudo agregar";
}							


if ($otro){header("Location:profesor_alta.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");die;}

header("Location:profesor_listado.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
?>