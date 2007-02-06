<?php

/*****************************************************************************
 *                                                                           *
 *                Web Application Development with PHP                       *
 *                                 by                                        *
 *                 Tobias Ratschiller and Till Gerken                        *
 *                                                                           *
 *          Copyright (c) 2000, Tobias Ratschiller and Till Gerken           *
 *                                                                           *
 *****************************************************************************
 *                                                                           *
 * $Title: String validation routines $                                      *
 * $Chapter: Basic Web Application Strategies $                              *
 * $Executable: false $                                                      *
 *                                                                           *
 * $Description:                                                             *
 * This file contains some routines useful for form validation and string    *
 * checking:                                                                 *
 * - is_digito()        //realizado por DEMARTINI, Diego                     *
 * - is_alpha()                                                              *
 * - is_numerico()      //modificado por GUIDOBONO, Dardo                    *
 * - is_alphanumeric()                                                       *
 * - is_email()                                                              *
 * - is_clean_text()                                                         *
 * - contains_bad_words()                                                    *
 * - contains_phone_number()                                                 *
 * - es_un_real ()              // realizada por Botta, Marcos               *
 * - is_link_ok()               // by Sánchez, Guido S.						
 * - is_imagen()                // hecho por Anibal Alegre                   *
 * - is_may_min()               // valida que solo este compuesot por maysusculas y miniusculas
 * - sin_espacios()             // dice si una cadena tiene subcadenas mas largas que n sin espacios
 * - insertar_espacios()        // si el texto contiene palabras más larga que un cirto X-tamaño, las separa
 * 								// cada X-tamaño con un espacio
 *
 *****************************************************************************/

function insertar_espacios($texto, $max)
{
$arreglo_palabras = explode(' ', $texto);
    foreach($arreglo_palabras as $i => $palabra)
    {
        $tamanio = strlen($palabra);
        if($tamanio > $max)
            $palabra = wordwrap($palabra, $max, ' ', 1); ;
        $arreglo_palabras[$i] = $palabra;
    }
    return implode(' ', $arreglo_palabras);
} 

function sin_espacios($vp_cadena,$vp_tam){
 /******
  *
  *  Marcos A. Botta
  *	 
  *	 recibe   -> vp_cadena: string cadena a validar
  *           -> vp_tam: entero tamaño sin espeacios
  *	 devuelve -> TRUE si "vp_cadena" contiene subcadenas de mas de "vp_tam" sin espcios
  *	 		  -> FALSE de otro modo
  *
  *******/	
	if(strlen($vp_cadena)<=$vp_tam) return true;
	if(ereg("^(.){".$vp_tam."}[[:space:]]",$vp_cadena)) return true;
	return false;
	}


function is_may_min($vp_cadena){
	// valida que una funcion este compuesta solo de minusculas, minusculas sin acentos ni caractere
	// Marcos A. Botta
	$lon = strlen($vp_cadena);
	$cmp = ereg("^([[:lower:]]|[[:upper:]]){"."$lon"."}$",$vp_cadena);
	if($cmp==1) return true; else return false;
	}

function is_link_ok($string){
// es un función que comprueba si el link que se pasa en "string" contiene
// el prefijo http:// o https:// o ftp://.
// Esta función no comprueba si es una dirección correncta.
// IMPORTANTE: si alguien conoce más protocolos, agrégenlo al array (protocolo).
   $protocolo=array("http://","https://","ftp://");
   //$string = trim($string);  //Elimina espacios del principio y final de una cadena
   $temp=1;
   $num=count($protocolo)-1;
   $i=0;
   while (($num>=$i)&&($temp!=0)){
     if ((strncmp($protocolo[$i],$string,strlen($protocolo[$i]))==0)&&(strlen($string)-strlen($protocolo[$i]))>5) $temp=0;
     $i++;
   }
   return $temp;
}

//Esta funcion valida que el parametro sea un archivo de imagen con la
//extension validada por el array $extensiones_aceptadas
function is_imagen($arch)
{$i=strlen($arch)-1;
 $extensiones_aceptadas=array("gif","jpg","jpeg","bmp");
 $extension="";
 while(($i>=0)&&($arch[$i]!='.'))
        {$extension=$arch[$i].$extension;
         $i--;
        }
 if ($i<0) return false;
 else {if(in_array($extension,$extensiones_aceptadas)){return true;}
       else {return false;};
      }
}


function es_un_real($string){
// comprueba sI $string es un numero real o no (ej: 21.32, .5, 0.2546, 564, 5.)
// entero es considerado un subconjunto de real
     $salida = FALSE;
     if(ereg("^([0-9]+)$", $string)){$salida = TRUE;}        // 5
     if(ereg("^([0-9]+)(\.[0-9]+)?$", $string)){$salida = TRUE;}  // 5 5.560
     if(ereg("^(\.[0-9]+)$", $string)){$salida = TRUE;}   // . .54
     if(ereg("^$", $string)){$salida = TRUE;}
     return $salida;
     }

function is_digito($digito){
 // comprueba si $digito es un digito o no
 if($digito=='0' || $digito=='1' || $digito=='2' || $digito=='3' || $digito=='4' ||
    $digito=='5' || $digito=='6' || $digito=='7' || $digito=='8' || $digito=='9'){return TRUE;
    }else{return FALSE;}
}

function is_vacio($string)
{
    // Check if the string is empty
    $str = trim($string);
    if(empty($str))
    {
        return(false);
    }
    else return(1);
    }

function _is_valid($string, $min_length, $max_length, $regex)
{
    // Check if the string is empty
    $str = trim($string);
    if(empty($str))
    {
        return(false);
    }


    // Does the string entirely consist of characters of $type?
    if(!ereg("^$regex$",$string))
    {
        return(false);
    }

    // Check for the optional length specifiers
    $strlen = strlen($string);

    if(($min_length != 0 && $strlen < $min_length) || ($max_length != 0 && $strlen > $max_length))
    {
        return(false);

    }

    // Passed all tests
    return(true);


}

/*
 *      bool is_alpha(string string[, int min_length[, int max_length]])
 *      Check if a string consists of alphabetic characters only. Optionally
 *      check if it has a minimum length of min_length characters and/or a
 *      maximum length of max_length characters.
 */

//Esta es la funcion is_alpha vieja, abajo copio la nueva
/*
function is_alpha($string, $min_length = 0, $max_length = 0)
{
    $ret = _is_valid($string, $min_length, $max_length, "[[:alnum:],.ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏĞÑÒÓÔÕÖØÙÚÛÜİŞßàáâãäæçèéêëìíîïğñòóôõöøùúûüış@#*_-///$[:space:]]+");
    return($ret);
}
*/

function is_alpha($string, $min_length = 0, $max_length = 0)
{
    /*$ret = _is_valid($string, $min_length, $max_length, "[[:alnum:],.ÀÁÂÃÄÅÆÇÈÉÊËÌÍÎÏĞÑÒÓÔÕÖØÙÚÛÜİŞßàáâãäæçèéêëìíîïğñòóôõöøùúûüış@#*_-///$[:space:]]+");
    return($ret);*/
    $string=clean($string);

    if($min_length!=0)
    {
       if(strlen($string)<$min_length)
          return (false);
    }
    if($max_length!=0)
    {
       if(strlen($string)>$max_length)
          return (false);
    }
   for($i=0;$i<strlen($string);$i++)
    {
     if(is_digito($string[$i])==TRUE)
        return(false);
    }
  return(true);
}

function filled_out($form_vars)
{
  // test that each variable has a value
  foreach ($form_vars as $key => $value)
  {
     if (!isset($key) || ($value == ""))
        return true;
  }
  return true;
}

//esta es la funciòn usada en is_alphanumeric
function clean($string)
{
  $string = trim($string);
  $string = htmlentities($string);
  $string = strip_tags($string);
  return $string;
}

function clean_all($form_vars)
{
  foreach ($form_vars as $key => $value)
  {
     $form_vars[$key] = clean($value);
  }
  return $form_vars;
}

/*
 *
 *      bool is_numeric(string string[, int min_length[, int max_length]])
 *      Check if a string consists of digits only. Optionally
 *      check if it has a minimum length of min_length characters and/or a
 *      maximum length of max_length characters.
 *
 */

function is_numerico($string, $min_length = 0, $max_length = 0)
{
    //$ret = _is_valid($string, $min_length, $max_length, "[[:digit:]]+");
    //return($ret);
    $string=clean($string);

    if($min_length!=0)
    {
       if(strlen($string)<$min_length)
          return (false);
    }
    if($max_length!=0)
    {
       if(strlen($string)>$max_length)
          return (false);
    }
   for($i=0;$i<strlen($string);$i++)
    {
     if(is_digito($string{$i})==FALSE)
        return(false);
    }
  return(true);
}

/*
 *
 *      bool is_alphanumeric(string string[, int min_length[, int max_length]])
 *      Check if a string consists of alphanumeric characters only. Optionally
 *      check if it has a minimum length of min_length characters and/or a
 *      maximum length of max_length characters.
 *
 */

function is_alphanumeric($string, $min_length = 0, $max_length = 0){
    //$ret = _is_valid($string, $min_length, $max_length, "[[:alnum:],.°&!%()'?¿=ÀÁÂÃÄÅÆÇÈÉ\\ÊËÌÍÎÏĞÑÒÓÔÕÖ\'ØÙÚÛÜİŞßàáâãäæçèéêëìíîïğñòóôõöø;:ùúûüış:@#*-///$[:space:]]+");
    //return($ret);
    $string=clean($string);
    if($min_length!=0)
    {
       if(strlen($string)<$min_length)
          return (false);
    }
    if($max_length!=0)
    {
       if(strlen($string)>$max_length)
          return (false);
    }
    return(true);
}

/*
 *
 *      bool is_email(string string[, int min_length[, int max_length]])
 *      Check if a string is a syntactically valid mail address. Optionally
 *      check if it has a minimum length of min_length characters and/or a
 *      maximum length of max_length characters.
 *
 */
 
 /*esta es la funcion vieja -> borrarla si al otra no causa problemas 17-6
function is_email($string)
{
    // Remove whitespace
    $string = trim($string);

    $ret = ereg(
                '^([a-z0-9_]|\\-|\\.)+'.
                '@'.
                '(([a-z0-9_]|\\-)+\\.)+'.
                '[a-z]{2,4}$',
                $string);

    return($ret);
}
*/


function is_email($email){ 
    // funte: www.desarrolloweb.com
	//  esta funcion va en validacion.php
	$mail_correcto = 0; 
    //compruebo unas cosas primeras 
    if ((strlen($email) >= 6) && (substr_count($email,"@") == 1) && (substr($email,0,1) != "@") && (substr($email,strlen($email)-1,1) != "@")){ 
       if ((!strstr($email,"'")) && (!strstr($email,"\"")) && (!strstr($email,"\\")) && (!strstr($email,"\$")) && (!strstr($email," "))) { 
          //miro si tiene caracter . 
          if (substr_count($email,".")>= 1){ 
             //obtengo la terminacion del dominio 
             $term_dom = substr(strrchr ($email, '.'),1); 
             //compruebo que la terminación del dominio sea correcta 
             if (strlen($term_dom)>1 && strlen($term_dom)<5 && (!strstr($term_dom,"@")) ){ 
                //compruebo que lo de antes del dominio sea correcto 
                $antes_dom = substr($email,0,strlen($email) - strlen($term_dom) - 1); 
                $caracter_ult = substr($antes_dom,strlen($antes_dom)-1,1); 
                if ($caracter_ult != "@" && $caracter_ult != "."){ 
                   $mail_correcto = 1; 
                } 
             } 
          } 
       } 
    } 
    if ($mail_correcto) 
       return 1; 
    else 
       return 0; 
	} // fin is_mail


/*
 *
 *      bool is_clean_text(string string[, int min_length[, int max_length]])
 *      Check if a string contains only a subset of alphanumerics characters
 *      allowed in the Western alphabets. Useful for validation of names.
 *      Optionally check if it has a minimum length of min_length characters and/or a
 *      maximum length of max_length characters.
 *
 */
 
function is_clean_text($string, $min_length = 0, $max_length = 0)
{
    $ret = _is_valid($string, $min_length, $max_length, "[a-zA-Z[:space:]!()=?¿ÀÁÂÃÄÅ°\\\"/ÆÇÈÉÊËÌÍÎÏĞÑÒÓÔÕÖØÙÚÛÜİŞßàáâãäåæçèéêëìíîïğñòóôõöøùúûüış`´']+");

    return($ret);
}

/*
 *      bool contains_bad_words(string string)
 *      Check if a string contains bad words, as defined in the array below
 */
function contains_bad_words($string)
{
    // This array contains words which trigger the "meep" feature of this function
    // (ie. if one of the array elements is found in the string, the function will
    // return true). Please note that these words do not constitute a rating of their
    // meanings - they're used for a first indication if the string might contain
    // inapropiate language.
    $bad_words = array(
                    'anal',           'ass',        'bastard',       'puta',
                    'bitch',          'blow',       'butt',          'trolo',
                    'cock',           'clit',       'cock',          'pija',
                    'cornh',          'cum',        'cunnil',        'verga',
                    'cunt',           'dago',       'defecat',       'cajeta',
                    'dick',           'dildo',      'douche',        'choto',
                    'erotic',         'fag',        'fart',          'trola',
                    'felch',          'fellat',     'fuck',          'puto',
                    'gay',            'genital',    'gosh',          'pajero',
                    'hate',           'homo',       'honkey',        'pajera',
                    'horny',          'vibrador',   'jew',           'lesbiana',
                    'jiz',            'kike',       'kill',          'eyaculacion',
                    'lesbian',        'masoc',      'masturba',      'anal',
                    'nazi',           'nigger',     'nude',          'mamada',
                    'nudity',         'oral',       'pecker',        'teta',
                    'penis',          'potty',      'pussy',         'culo',
                    'rape',           'rimjob',     'satan',         'mierda',
                    'screw',          'semen',      'sex',           'bastardo',
                    'shit',           'slut',       'snot',          'sorete',
                    'spew',           'suck',       'tit',
                    'twat',           'urinat',     'vagina',
                    'viag',           'vibrator',   'whore',
                    'xxx'
    );

    // Check for bad words
    for($i=0; $i<count($bad_words); $i++)
    {
        if(strstr(strtoupper($string), strtoupper($bad_words[$i])))
        {
            return(true);
        }
    }

    // Passed the test
    return(false);
}

/*
 *      bool contains_phone_number(string string)
 *      Check if a string contains a phone number (any 10+-digit sequence,
 *      optionally separated by "(", " ", "-" or "/").
 */
function contains_phone_number($string)
{
     // Check for phone number
     if(ereg("[[:digit:]]{3,10}[\. /\)\(-]*[[:digit:]]{6,10}", $string))
     {
        return(true);
     }

     // Passed the test
     return(false);
}

function is_file_ok($archivo)
{

  if ($archivo ['userfile']['tmp_name']=="none")
  {
    $error_arch="No se subio ningun Archivo";
    return ($error_arch);
  }
  if ($archivo ['userfile']['size']==0)
  {
    $error_arch="El archivo esta Vacío";
    return($error_arch);
  }
  echo $archivo ['userfile']['size'];
  if ($archivo ['userfile']['size'] > 107374182)
  {
    $error_arch="No se puede subir un Archivo de más de 1MB";
    return($error_arch);
  }
 return("ok");
}

/* $Id: validacion.php3,v 1.2 2001/03/20 ALEGRE,DEMARTINI,GUIDOBONO Exp $ */
?>