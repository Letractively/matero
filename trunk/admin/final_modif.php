<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   final_modif.php
*                          Autor:   Angeletti, Mariano R - Omar, Dario A.
*                 Fecha Creacion:   29-01-04.
*            Ultima Modificacion:   29-01-04.
*           Campos que lee en BD:   examen_final
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   realiza la modificación de un exámen final
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");
include("../includes/fecha.php");

$vl_query = mysql_query("Select * 
							from examen_final 
							Where id_examen_final = $idf 
							and id_catedra = $vs_id_catedra
							");
if (!mysql_num_rows($vl_query)){
		$vl_mensaje = "No existe el exámen";
		header("Location:final_listado.php?mensaje=$vl_mensaje&PHPSESSID=$PHPSESSID");
		die;}
$vl_fila = mysql_fetch_array($vl_query);
set_file("pagina","final_modif.html");
set_var("titulo",$vl_fila[nombre]);
set_var("comentario",$vl_fila[descripcion]);
set_var("anio",obtener_anio($vl_fila[fecha_examen]));

if (obtener_mes($vl_fila[fecha_examen]) < 10){ $f= obtener_mes($vl_fila[fecha_examen]);
										       $vl_mes="$f[1]";
											    }
else {$vl_mes=obtener_mes($vl_fila[fecha_examen]); } 

set_var("selected_mes$vl_mes","selected");
set_var("dia",obtener_dia($vl_fila[fecha_examen]));
$f=$vl_fila[hora];
$vl_hora="$f[0]$f[1]";
$vl_min="$f[3]$f[4]";
set_var("hora",$vl_hora);
set_var("min",$vl_min);


set_var("idf",$idf);
set_var("mensaje","");
set_var("firma",firma());
parse("bloque","bloque",true);

pparse("pagina");
?>