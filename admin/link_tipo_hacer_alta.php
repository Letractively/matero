<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   link_tipo_hacer_alta.php
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

//Valido el nombre
if (!is_alphanumeric($vf_nombre,2,200) || ($vf_nombre==""))
   {$vl_mensaje_error.="Se ha ingresado un nombre incorrecto<br>";
   $vl_error=1;
   }



if($vl_error=='1'){
set_file("pagina","link_tipo_alta.html");
set_var("nombre",$vf_nombre);
set_var("descri",$vf_descri);
set_var("menu",$vf_menu);

set_var("mensaje",$vl_mensaje_error);
set_var("firma",firma());
parse("datos","datos",true);
pparse("pagina");
die;
}

if (mysql_query("Insert into link_tipo(
							id_link_tipo,
							id_catedra,
							nombre,
							descripcion)
							values(
							'NULL',
							'$vs_id_catedra',
							'$vf_nombre',
							'$vf_descri')")){
							$vl_mensaje="Se ingres� un tipo de link exitosamente";
										
							}
else{
	$vl_mensaje="Se ingres� un tipo de link exitosamente";
}							
if ($otro){header("Location:link_tipo_alta.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");die;}

if ($vf_menu==1) header("Location:link_tipo_listado.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
else
header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");

?>