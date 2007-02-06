<?php
/********************************************************************************

Archivo de configuración de Tecnicatura de Tecnologia de Información

Ver. 1.0.1 2001/03/20   ALEGRE,DEMARTINI,GUIDOBONO

*********************************************************************************/
//////////////////////////////////////////////
//Funciones
/////////////////////////////////////////////

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
   
// funcion que permite sacar el codigo html de un string

function sacar_html($str) {
$allowed = "<br>,<b>,<i>,<u>";
return strip_tags($str,$allowed);
}



?>