<?php
/********************************************************************************

Archivo de configuración de Tecnicatura de Tecnologia de Información

Ver. 1.0.1 2003/03/20   ANGELETTI,BOTTA,SANCHEZ

*********************************************************************************/


$vc_tpo_caducidad=60;//[dias], tiempo que dura una password; 
$vc_aviso_caducidad=15;//[dias], tiempo de aviso antes que se venza el password

//////////////////////////////////////////////
//Funciones
/////////////////////////////////////////////

function strftime_caste($formato, $fecha){
// strftime_caste por Marcos A. Botta
// esta funcion es una alternativa para cuando no anda setlocale
// $formato: como se quiere mostrar la fecha - es el mismo que el de strftime
// $fecha: tiemestamp correspondiente a la fecha y hora que se quiere mostrar
/* %a - nombre del día de la semana abreviado
%A - nombre del día de la semana completo
%b - nombre del mes abreviado
%B - nombre del mes completo
%c - representación de fecha y hora preferidas en el idioma actual
%d - día del mes en número (de 00 a 31)
%H - hora como un número de 00 a 23
%I - hora como un número de 01 a 12 
%j - día del año como un número de 001 a 366
%m - mes como un número de 01 a 12
%M - minuto en número
%p - `am' o `pm', según la hora dada, o las cadenas correspondientes en el idioma actual
%S - segundos en número
%U - número de la semana en el año, empezando con el primer domingo como el primer día de la primera semana
%W - número de la semana en el año, empezando con el primer lunes como el primer día de la primera semana
%w - día de la semana en número (el domingo es el 0)
%x - representación preferida de la fecha sin la hora
%X - representación preferida de la hora sin la fecha
%y - año en número de 00 a 99
%Y - año en número de cuatro cifras
%Z - nombre o abreviatura de la zona horaria
%% - carácter `%'
*/

$salida = strftime($formato, $fecha);
// reemplazo meses
$salida = ereg_replace("January","enero",$salida);
$salida = ereg_replace("February","febrero",$salida);
$salida = ereg_replace("March","marzo",$salida);
$salida = ereg_replace("May","mayo",$salida);
$salida = ereg_replace("April","abril",$salida);
$salida = ereg_replace("June","junio",$salida);
$salida = ereg_replace("July","julio",$salida);
$salida = ereg_replace("August","agosto",$salida);
$salida = ereg_replace("September","setiembre",$salida);
$salida = ereg_replace("October","octrubre",$salida);
$salida = ereg_replace("November","noviembre",$salida);
$salida = ereg_replace("December","diciembre",$salida);
// reemplazo meses cortos
$salida = ereg_replace("Jan","ene",$salida);
$salida = ereg_replace("Apr","abr",$salida);
$salida = ereg_replace("Aug","ago",$salida);
$salida = ereg_replace("Dec","dic",$salida);
// reemplazo días
$salida = ereg_replace("Monday","Lunes",$salida);
$salida = ereg_replace("Tuesday","Martes",$salida);
$salida = ereg_replace("Wednesday","Miércoles",$salida);
$salida = ereg_replace("Thursday","Jueves",$salida);
$salida = ereg_replace("Friday","Viernes",$salida);
$salida = ereg_replace("Saturday","Sábado",$salida);
$salida = ereg_replace("Sunday","Domingo",$salida);
// reemplazo dias cortos
$salida = ereg_replace("Mon","Lun",$salida);
$salida = ereg_replace("Tue","Mar",$salida);
$salida = ereg_replace("Wed","Mié",$salida);
$salida = ereg_replace("Thu","Jue",$salida);
$salida = ereg_replace("Fri","Vie",$salida);
$salida = ereg_replace("Sat","Sáb",$salida);
$salida = ereg_replace("Sun","Dom",$salida);
// reemplazo cuando es 1 de algun mes
$salida = ereg_replace(" 01 de "," 1° de ",$salida);
return $salida;
} // fin strftime_caste
////////////////////////////////////////////
////////////////////////////////////////
function convertir_a_mes($n){
if (($n > 12) || ($n < 1)) {die();}
$arr[1]="Enero";
$arr[2]="Febrero";
$arr[3]="Marzo";
$arr[4]="Abril";
$arr[5]="Mayo";
$arr[6]="Junio";
$arr[7]="Julio";
$arr[8]="Agosto";
$arr[9]="Septiembre";
$arr[10]="Octubre";
$arr[11]="Noviembre";
$arr[12]="Diciembre";
return ($arr[$n]);
}

function convertir_fecha($n){
return(substr($n,8,2)."-".substr($n,5,2)."-".substr($n,0,4) );
}

//Función que valida la fecha
//Si devuelve:
//1:Error en el año
//2:Error en el mes
//3:Error de dia para ese mes
//4:fecha OK
//5:Error de dia (menor que 1)
function is_date_ok(&$dia,&$mes,&$anio){

$dia=(int)$dia;
$mes=(int)$mes;


   if($anio>2100 or $anio<1900){
      return(1);
   }
   if($mes>12 or $mes<1){
       return(2);
   }
$bisiesto=0;
if(($anio % 4) == 0){
     $bisiesto=1;
}
$arr["1"]="31";

if($bisiesto){
    $arr["2"]="29";
}else {
      $arr["2"]="28";
}

$arr["3"]="31";
$arr["4"]="30";
$arr["5"]="31";
$arr["6"]="30";
$arr["7"]="31";
$arr["8"]="31";
$arr["9"]="30";
$arr["10"]="31";
$arr["11"]="30";
$arr["12"]="31";

if($dia>$arr[$mes]){
    return(3);
}

if($dia<"1"){
    return(5);
}
return(4);
}

//Funcion que al pasarle una fecha devuelve el dia
function obtener_dia($fecha) {
return(substr($fecha,8,2));
}

//Funcion que al pasarle una fecha devuelve el mes
function obtener_mes($fecha) {
return(substr($fecha,5,2));
}

//Funcion que al pasarle una fecha devuelve el año
function obtener_anio($fecha) {
return(substr($fecha,0,4));
}
//Funcion que devuelve la hora cuando la fecha es de tipo datetime de mysql (ej 2003-06-04 00:00:00)
//by guido
function obtener_hora($fecha) {
return(substr($fecha,11,2));
}
//Funcion que devuelve los minutos cuando la fecha es de tipo datetime de mysql (ej 2003-06-04 00:00:00)
//by guido
function obtener_minutos($fecha) {
return(substr($fecha,14,2));
}

//funcion que valida que la fecha final sea mayor que la fecha inicial
//Devuelve 0 si es incorrecta o 1 si es correcta.
function fecha_menor($diainicio,$diafin,$mesinicio,$mesfin,$anioinicio,$aniofin){

$dif_en_meses=(($mesfin-$mesinicio)+(12*($aniofin-$anioinicio)));

if($dif_en_meses<0){return(0);}
if(($dif_en_meses==0) && ($diafin<=$diainicio)){return(0);}
return(1);
}

//funcion que valida que la fecha final sea mayor que la fecha inicial
//Devuelve 0 si es incorrecta o 1 si es correcta.
function fecha_menor_igual($diainicio,$diafin,$mesinicio,$mesfin,$anioinicio,$aniofin){
$dif_en_meses=(($mesfin-$mesinicio)+(12*($aniofin-$anioinicio)));
if($dif_en_meses<0){return(0);}
if(($dif_en_meses==0) && ($diafin<$diainicio)){return(0);}
return(1);
}

//Funcion que valida que la fecha de hoy sea anterior a la que se da de alta
//Devuelve 0 si es incorrecta o 1 si es correcta.
function fecha_no_paso($dia,$mes,$anio){
$dia_hoy=date("d");
$mes_hoy=date("m");
$anio_hoy=date("Y");

$dif_en_meses=(($mes-$mes_hoy)+(12*($anio-$anio_hoy)));

if($dif_en_meses<0){return(0);}
if(($dif_en_meses==0) && ($dia<$dia_hoy)){return(0);}
return(1);
}

//Suma dias a una fecha dada
//Guido
function sumar_dias_a_una_fecha($dia,$mes,$anio,$numdias){
if (!checkdate($mes,$dia,$anio)) die("error en sumar_dias_a_una_fecha() - Se le ha mandado a la función una fecha incorrecta");
$fecha=mktime ( 0,0,0, $mes,$dia+$numdias,$anio);
return date( "Y-m-d", $fecha);
}
//Resta dias a una fecha dada
//Mariano
function restar_dias_a_una_fecha($dia,$mes,$anio,$numdias){
if (!checkdate($mes,$dia,$anio)) die("error en restar_dias_a_una_fecha() - Se le ha mandado a la función una fecha incorrecta");
$fecha=mktime ( 0,0,0, $mes,$dia-$numdias,$anio);
return date( "Y-m-d", $fecha);
}


?>