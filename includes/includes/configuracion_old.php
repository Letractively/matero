<?php
// archivos de configuracion

// carpeta de estilos
$vc_carpeta_estilos = "$DOCUMENT_ROOT/estilos";

// carpeta de fotos 
$vc_carpeta_fotos = "$DOCUMENT_ROOT/fotos";

// carpeta graficos
$vc_carpeta_graficos = "$DOCUMENT_ROOT/graficos";

// carpeta Includes
$vc_carpeta_includes = "$DOCUMENT_ROOT/includes";

// carpeta javascripts
$vc_carpeta_javascripts = "$DOCUMENT_ROOT/javascripts";


// archivo donde se definen las secciones y suplementos del diairo (id, directorio, si es suplemento)- ¿se usa para generar comAr??
$vc_archivo_config_news = "$DOCUMENT_ROOT/admin/Newsletter/secciones.dat";

// donde se guardan los txt del dia
$vc_carpeta_news="$DOCUMENT_ROOT/admin/Newsletter/internet/";

// fuera de uso por el momento 
$vc_carpeta_news_generados=$vc_carpeta_news."news/";

// que secciones estan permitidas acutalmente en el newsletter
$vc_news_extensiones=array("AREA","DEPO","ECON","INFO","INTE","PAN","PER","POLI","REGI","SUCE","TAPA","COM","HACE","NOS");
//////////////////////////////////,"OPIN"


//////////////////////////////////////////////
//Parametros y funciones de la base de datos
/////////////////////////////////////////////

// Fucion conectar -> conecta con la base de datos y nos permite modificar el host, el usuario y la password con facilidad
$vc_ip_interna="200.68.216.199";
$vc_tpo_caducidad=60;//[dias], tiempo que dura una password; 
$vc_aviso_caducidad=15;//[dias], tiempo de aviso antes que se venza el password

/*
$rootuser="utn";
$rootpass="pasan3";

$db['host']="localhost";
$db['user']="utn";

$db['pass']="pasan3";
$dbnam="litoral";
*/

function conectar(){
//	$c = mysql_connect(); 
//	$c=mysql_connect($db['host'],$db['user'],$db['pass']); //$db["password(pass)"]);
	$c=mysql_connect("localhost","utn","pasan3"); //$db["password(pass)"]);
	mysql_query("use litoral");
    return $c;
	}

//////////////////////////////////////////////
//Funciones
/////////////////////////////////////////////
// Lo que hace es crear el cartelito que va como pie, en todas las páginas.
function firma(){
	$vl=date("Y");
	$pie_l='Desarrollo Web El Litoral - '.$vl;
	return $pie_l;
}


//////////////////////////////////////////////
///     parametros de la pagina web       ////
//////////////////////////////////////////////

$title="Tecnicatura de Tecnologia de Información";
$nota_de_pie="TTI 2001";
$font="Times new Roman";
$cletra="#000000";
$cfondo="#FFFFFF";
$clinks="#003366";
$tamanoletra=2;
$url="www.ellitoral.com";


///////////////////////////////////////////////
// funciones de ayuda html
///////////////////////////////////////////////

$a="&aquote;";
$e="&equote;";
$i="&iquote;";
$o="&oquote;";
$u="&uquote;";
$n="&ntilde;";

//centra lo que venga
function centrar($text){
                        return "<div align=\"center\">$text</div>";
                        }
//a izquierda lo que venga
function izq($text){
                        return "<div align=\"left\">$text</div>";
                        }
//a derecha lo que venga
function der($text){
                        return "<div align=\"right\">$text</div>";
                        }

//en negrita lo que venga
function negrita($text){
                        return "<strong>$text</strong>";
                        }
//subraya lo que venga
function subraya($text){
                        return "<u>$text</u>";
                        }
//en italica lo que venga
function italica($text){
                        return "<i>$text</i>";
                        }

//parrafo a lo que venga
function parrafo($text){
                        return "<p>$text</p>";
                        }

//funcion titulo que hace un titulo predeterminado con la importancia 1..6
function htit($text,$importancia){
         return "<h$importancia>$text</$importancia>";
         }



//tabula lo que venga $cant veces
function tab($texto,$cant){ $i=1;
        $a="";
        while($i<=$cant){
                $a.="&nbsp;";
                $i++;
                        }
        return $a.$texto;
           }

// retorna el codigo de $cant saltos de linea o uno si no se le pasa nada
function salto($cant=1){ $i=1;
        $a="";
        while($i<=$cant){
                $a.="<br>";
                $i++;
                        }
        return $a;
           }

// retorna el texto con un cierto tamaño si no se pasa el tamaño, por defecto $tamanoletra
function font($text,$tamano=0,$color="0"){
    global $font,$cletra,$tamanoletra;
    if ( $tamano == 0) { $tamano=$tamanoletra; }
    if ( $color == "0") { $color=$cletra; }
    $a="<font face=\"$font\" size=\"$tamano\" color=\"$color\" >";
    $a.=$text;
    $a.="</font>";
    return $a;
    }
//retorna el cófigo html de la imagen
function imagen($path,$ancho=0,$alto=0){
        if (($ancho == 0) && ($alto == 0)) {
              return "<img src=\"$path\" border=0>";
              }
        return "<img src=\"$path\" width=\"$ancho\" height=\"$alto\ border=0>";
        }

//crea un link y retorna su codigo
function link_a($dir,$cont){
        return "<a href=\"$dir\">$cont</a>";
                }


function encabezado() {
        global $url,$cfondo,$cletra,$clinks,$title;
        echo("<html>\n");
        echo("<head>\n");
        echo("<title>\n");
        echo("$title - $url");
        echo("</title>\n");
        echo("</head>\n");
        echo("<body bgcolor=\"$cfondo\" Text=\"$cletra\" links=\"clinks\">\n");
             }

function pie(){
        global $nota_de_pie;
        echo("<hr>");
        echo("<br>");
        echo("<center>");
        echo font($nota_de_pie,1);
        echo("</center>");
        echo("</body>\n");
        echo("</html>\n");
     }

// funciones de encriptacion
function keyED($txt,$encrypt_key)
{
$encrypt_key = md5($encrypt_key);
$ctr=0;
$tmp = "";
for ($i=0;$i<strlen($txt);$i++)
{
if ($ctr==strlen($encrypt_key)) $ctr=0;
$tmp.= substr($txt,$i,1) ^ substr($encrypt_key,$ctr,1);
$ctr++;
}
return $tmp;
}


function encrypt($txt,$key)
{
srand((double)microtime()*1000000);
$encrypt_key = md5(rand(0,32000));
$ctr=0;
$tmp = "";
for ($i=0;$i<strlen($txt);$i++)
{
if ($ctr==strlen($encrypt_key)) $ctr=0;
$tmp.= substr($encrypt_key,$ctr,1) .
(substr($txt,$i,1) ^ substr($encrypt_key,$ctr,1));
$ctr++;
}
return keyED($tmp,$key);
}

function decrypt($txt,$key)
{
$txt = keyED($txt,$key);
$tmp = "";
for ($i=0;$i<strlen($txt);$i++)
{
$md5 = substr($txt,$i,1);
$i++;
$tmp.= (substr($txt,$i,1) ^ $md5);
}
return $tmp;
}


function encriptar($texto){

         $key1 = "fruta para generar codigo encriptado";
         $key2 = date("Ymd");
         $key3 = $REMOTE_ADDR;
         $key4 = $HTTP_USER_AGENT;
         $key5 = "TTI gestion";

return base64_encode(keyED(encrypt(keyED(encrypt(keyED($texto,$key1),$key2),$key3),$key4),$key5));
}
function desencriptar($encriptado){

         $key1 = "fruta para generar codigo encriptado";
         $key2 = date("Ymd");
         $key3 = $REMOTE_ADDR;
         $key4 = $HTTP_USER_AGENT;
         $key5 = "TTI gestion";

return keyED(decrypt(keyED(decrypt(keyED(base64_decode($encriptado),$key4),$key5),$key3),$key2),$key1);
}



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

// funcion que permite sacar el codigo html de un string

function sacar_html($str) {
$allowed = "<br>,<b>,<i>,<u>";
return strip_tags($str,$allowed);
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
// redondea un float con n de presicion
//Mariano
function round_precision($val,$precision){
$exp = pow(10,$precision);
$val = $val * $exp;
$val = round($val);
$val = $val /  $exp;
return $val;
}



?>