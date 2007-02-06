<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   biblio_hacer_alta.php
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

if ($vf_tipo=='0')
   {$vl_mensaje_error.="No ha seleccionado un tipo de bibliografía<br>";
   $vl_error=1;
   }
//Valido el nombre
if (!is_alphanumeric($vf_nombre,2,200) || ($vf_nombre==""))
   {$vl_mensaje_error.="Se ha ingresado un nombre incorrecto<br>";
   $vl_error=1;
   }



if($vl_error=='1'){
set_file("pagina","biblio_alta.html");
$vl_query=mysql_query("Select *
						from biblio_tipo
						where id_catedra= '$vs_id_catedra'");
while ($vl_fila=mysql_fetch_array($vl_query))
 	{

	if ($vf_tipo == $vl_fila[id_biblio_tipo]) set_var("chek","selected");
	else set_var("chek","");
	set_var("idt",$vl_fila[id_biblio_tipo]);
	set_var("tipo",$vl_fila[nombre]);
	parse("link","link",true);	
 	}						
set_var("nombre",$vf_nombre);
set_var("descri",$vf_descri);
set_var("menu",$vf_menu);

set_var("mensaje",$vl_mensaje_error);
set_var("firma",firma());
parse("datos","datos",true);
pparse("pagina");
die;
}

if (mysql_query("Insert into biblio(
							id_biblio,
							id_catedra,
							id_biblio_tipo,
							nombre,
							descripcion)
							values(
							'NULL',
							'$vs_id_catedra',
							'$vf_tipo',
							'$vf_nombre',
							'$vf_descri')")){
							$vl_mensaje="Se ingresó la bibliografía exitosamente";
										
							}
else{
	$vl_mensaje="No se pudo ingresar la bibliorafía";
}							
if ($otro){header("Location:biblio_alta.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");die;}

if ($vf_menu==1) header("Location:biblio_listado.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
else
header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");

?>