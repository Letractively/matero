<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   novedades_hacer_alta.php
*                          Autor:   Angeletti, Mariano R.
*                 Fecha Creacion:   29-01-04.
*            Ultima Modificacion:   29-01-04.
*           Campos que lee en BD:   tabla novedades
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   ninguna
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

$vl_error=0;
//Valido los datos

//Valido el título
if (!is_alphanumeric($vf_titulo,2,350) || ($vf_titulo==""))
   {$vl_mensaje_error.="Se ha ingresado un título incorrecto<br>";
   $vl_error=1;
   }

if ($vl_error == 1) {
	set_file("pagina","novedades_modificar.html");
	set_var("titulo",$vf_titulo);
	set_var("comentario",$vf_comentario);
 	set_var("mensaje",$vl_mensaje_error);
	set_var("idn",$idn);
	set_var("firma",firma());
	parse("bloque","bloque",true);
	pparse("pagina");
	die();
	}
	
$vl_fecha = date("Y-m-d");
if (mysql_query("UPDATE novedades SET 	titulo='$vf_titulo',
										contenido='$vf_comentario'
									WHERE id_novedades = '$idn'
										")) {$vl_mensaje = "La modificación ha sido exitosa";}
	else
		{ $vl_mensaje = "No se ha podido insertar correctamente";}

header("Location:novedades_listado.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
								
											
	
	
?>