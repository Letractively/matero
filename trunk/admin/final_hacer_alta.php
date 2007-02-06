<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   final_hacer_alta.php
*                          Autor:   Angeletti, Mariano R - Omar, Dario A.
*                 Fecha Creacion:   27-01-04.
*            Ultima Modificacion:   27-01-04.
*           Campos que lee en BD:   examen_final
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   realiza el logueo del usuario
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");
include("../includes/fecha.php");


$vl_error=0;
//Valido los datos

//Valido el título
if (!is_alphanumeric($vf_titulo,2,200) || ($vf_titulo==""))
   {$vl_mensaje_error.="Se ha ingresado un título incorrecto<br>";
   $vl_error=1;
   }
switch(is_date_ok($vf_dia,$vf_mes,$vf_anio)){
case '1':  $vl_mensaje_error.="Se ha ingresado un año incorrecto <br>";
		   $vl_error=1;
		   break;
case '2':  $vl_mensaje_error.="Se ha ingresado un mes incorrecto <br>";
		   $vl_error=1;
		   break;
case '3':  $vl_mensaje_error.="Se ha ingresado un día incorrecto <br>";
		   $vl_error=1;
		   break;
case '5':  $vl_mensaje_error.="Se ha ingresado un día incorrecto <br>";
		   $vl_error=1;
		   break;		   		   		   
case '4': break;		   
	}
	
$vl_hora=(int)$vf_hora;
$vl_minutos=(int)$vf_minutos;
  if($vl_hora>24 or $vl_hora<0){
      $vl_mensaje_error.="Se ha ingresado una hora incorrecta <br>";
	   $vl_error=1;
   }	
  if($vl_minutos>59 or $vl_minutos<0){
      $vl_mensaje_error.="Se ha ingresado minutos incorrectos <br>";
	   $vl_error=1;
   }		
	
if ($vl_error == 1) {
	set_file("pagina","final_alta.html");
	set_var("titulo",$vf_titulo);
	set_var("comentario",$vf_comentario);
 	$vl_mes = date("n");

	$vl_anio=date("Y");
	if ($vf_anio=="") 	set_var("anio","$vl_anio");
	else set_var("anio",$vf_anio);
	
	set_var("selected_mes$vl_mes","selected");
	set_var("dia",$vf_dia);
	set_var("hora",$vf_hora);
	set_var("min",$vf_minutos);
 	set_var("mensaje",$vl_mensaje_error);
	set_var("menu",$vf_menu);
	set_var("firma",firma());
	parse("bloque","bloque",true);
	pparse("pagina");
	die();
	}

//if ($vf_mes < 10) {$vf_mes = "0$vf_mes";}
$vl_fecha = "$vf_anio-$vf_mes-$vf_dia";
$vl_hora = "$vf_hora:$vf_minutos";
mysql_query("INSERT INTO examen_final (id_examen_final,
									   id_catedra,
									   nombre,
									   descripcion,
									   fecha_examen,
									   hora) 
									   VALUES (
									   'NULL',
									   '$vs_id_catedra',
									   '$vf_titulo',
									   '$vf_comentario',
									   '$vl_fecha',
									   '$vl_hora')");
$vl_mensaje = "El examen ha sido ingresado con éxito";

header("Location:final_listado.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");


?>