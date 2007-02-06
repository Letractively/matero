<?php

/********************************************************************************

Archivo de configuración de Tecnicatura de Tecnologia de Información

Ver. 1.0.1 2001/03/20   ALEGRE,ANGELETTI,SANCHEZ

*********************************************************************************/
///////////////////////////////////////
// array de los modulos del sistema de la catreda
//////////////////////////////////////////////////////
/* Este array contiene todos los modulos que se puedan publicar y que componen a MATERO, los numeros correspondientes a cada modulo
no se deben tocar, si se genera un nuevo modulo debe ir al final del array
los id delos modulos deben ser correlativos*/
$vc_array_modulos = array("1"=>"Plan de Cátedra","2"=>"Objetivos","3"=>"Integrantes", "4"=>"Apuntes", "5"=>"Novedades",
                                                        "6"=>"Exámen Final", "7"=>"Horarios", "8"=>"Repositorio", "9"=>"Bibliografía",
                                                        "10"=>"Links", "11" => "Exámenes Parciales", "12" => "Trabajos Prácticos","14" => "Consultanos");

//////////////////////////////////////////////////////
// tamaños de páginas utilizados dentro del admin
//////////////////////////////////////////////////////
$vc_tamanio_pagina_tp = 10;
$vc_tamanio_pagina_alumnos = 20;
$vc_tamanio_pagina_examen_parcial = 10;

///////////////////////////////////////
// paths de las carpetas de las catedras
///////////////////////////////////////

$vc_directorios_archivos="var/www/html/webnueva/proyectos/matero/archivos";
$vc_directorio_plan="plan";
$vc_directorio_objetivo="objetivos";
$vc_directorio_tps="tps";
$vc_directorio_repositorios="repositorios";
$vc_directorio_apuntes="apuntes";


//////////////////////////////////////////////
//Parametros y funciones de la base de datos
/////////////////////////////////////////////

// Fucion conectar -> conecta con la base de datos y nos permite modificar el host, el usuario y la password con facilidad
//$rootuser="grupoweb";
$rootuser="gweb";
//$rootpass="gwebphp4";
$rootpass="gweb456";

$db["host"]="localhost";
$db["user"]=$rootuser;
$db["pass"]=$rootpass;
$dbnam="sistemacatedras";
function conectar(){
                    global $db,$dbnam;
                    $c=mysql_connect($db["host"],$db["user"],$db["pass"]); //$db["password(pass)"]);
                    mysql_query("use $dbnam");
                    return $c;
                   }


function firma(){
return  "Desarrollo por Grupo Web - U.T.N. - F.R.S.F. - sistema_matero@yahoo.com";}

function firma_web(){
return  '<div align="center"><object classid="clsid:D27CDB6E-AE6D-11cf-96B8-444553540000" codebase="http://download.macromedia.com/pub/shockwave/cabs/flash/swflash.cab#version=6,0,29,0" width="120" height="60">
  <param name="movie" value="img/media.swf">
  <param name="quality" value="high">
  <embed src="img/media.swf" quality="high" pluginspage="http://www.macromedia.com/go/getflashplayer" type="application/x-shockwave-flash" width="120" height="60"></embed></object></div>';}


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



// funcion que permite sacar el codigo html de un string

function sacar_html($str) {
$allowed = "<br>,<b>,<i>,<u>";
return strip_tags($str,$allowed);
}

 /**
* fija una variable global si la
* especificada get o post existe
*
* @param string $test_vars
* el array de las variables
* a registrar, aceptar una cadena como
* nombre para una unica variable
*
* @global la variable, si esta está fijada
*/
/*
function getpost_ifset($test_vars)
{
echo "bobobobob1";
print_r($test_vars);
if (!is_array($test_vars)) {
	$test_vars = array($test_vars);
}

foreach($test_vars as $key => $value) {
echo $test_var;
if (isset($_POST[$test_var])) {
global $$test_var;
$$test_var = $_POST[$test_var];
} elseif (isset($_GET[$test_var])) {
global $$test_var;
$$test_var = $_GET[$test_var];
}
}
}
*/


function getpost_ifset()
{
	print_r($test_vars);
	if (!is_array($test_vars)) {
		$test_vars = array($test_vars);
	}
	
	foreach($_POST as $key => $value) {
  	  	global $$key;
	  	$$key = $_POST[$key];
	}
	foreach($_GET as $key => $value) {
		global $$key;
	  	$$key = $_GET[$key];	
	}
	foreach($_SESSION as $key => $value) {
		global $$key;
	  	$$key = $_SESSION[$key];	
	}
	
}

?>