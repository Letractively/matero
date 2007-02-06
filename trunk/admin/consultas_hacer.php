<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   consultas_hacer.php
*                          Autor:   A.U.S. Sánchez, Guido S. 
*                 Fecha Creacion:   27-01-04.
*            Ultima Modificacion:   27-01-04.
*           Campos que lee en BD:   
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   inicializa el template de alta de alumnos
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");
$vl_error=0;
//Valido el asunto
if (!is_alphanumeric($vf_asunto,2,200))
   {
   $vl_mensaje_error.="ERROR: Debe ingresar un asunto para la consulta<br>";
   $vl_error=1;
   }

//Valido el asunto
if (!is_alphanumeric($vf_cuerpo,2,2000))
   {
   $vl_mensaje_error.="ERROR: Debe ingresar un texto para la consulta<br>";
   $vl_error=1;
   }
   
if ($vl_error){
set_file("pagina","consultas.html");
set_var("asunto",$vf_asunto);
set_var("cuerpo",$vf_cuerpo);
set_var("mensaje","$vl_mensaje_error");
set_var("firma",firma());
parse("datos","datos",true);
pparse("pagina");
die;
}
$query= mysql_query("SELECT * FROM catedra WHERE id_catedra = '$vs_id_catedra'");
$fila=mysql_fetch_array($query);

$datos="
		Cátedra: $fila[nombre] - $fila[email] \r\n
		usuario: $usuario_logueado[nombre] $usuario_logueado[nombre]\r\n
		mail: $usuario_logueado[email]\r\n\r\n\r\n";

if (mail("sistema_matero@yahoo.com","Desde MATERO:".$vf_asunto,$datos.$vf_cuerpo))
	$mensaje="Envío de consulta exitosa.";
else 	$mensaje="No se pudo enviar la consulta, intente más tarde.";
header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$mensaje");
?>