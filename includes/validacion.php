<?php

/****************************************************************************
*                 Nombre Sistema:   Sistema Noticias.
*                  Nombre Script:
*                          Autor:
*                 Fecha Creacion:
*            Ultima Modificacion:   12-11-02.
*           Campos que lee en BD:
*      Campos que Modifica en BD:
*              Funciones que usa:
*  Descripcion de funcionamiento:
*                Que falta Hacer:
*
*****************************************************************************/


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
 * - is_imagen()                // echo por Anibal Alegre                        *
 *                                                                           *
 *****************************************************************************/

 ///funcion que borra un directorio y su contenido
function deldir($dir){
   $current_dir = opendir($dir);
   while($entryname = readdir($current_dir)){
      if(is_dir("$dir/$entryname") and ($entryname != "." and $entryname!="..")){
         deldir("${dir}/${entryname}");
      }elseif($entryname != "." and $entryname!=".."){
         unlink("${dir}/${entryname}");
      }
   }
   closedir($current_dir);
   rmdir(${dir});
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

function is_digito($digito)
{
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
 *      bool is_numeric(string string[, int min_length[, int max_length]])
 *      Check if a string consists of digits only. Optionally
 *      check if it has a minimum length of min_length characters and/or a
 *      maximum length of max_length characters.
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
 *      bool is_alphanumeric(string string[, int min_length[, int max_length]])
 *      Check if a string consists of alphanumeric characters only. Optionally
 *      check if it has a minimum length of min_length characters and/or a
 *      maximum length of max_length characters.
 */

function is_alphanumeric($string, $min_length = 0, $max_length = 0)
{
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
 *      bool is_email(string string[, int min_length[, int max_length]])
 *      Check if a string is a syntactically valid mail address. Optionally
 *      check if it has a minimum length of min_length characters and/or a
 *      maximum length of max_length characters.
 */
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

/*
//Esta funcion is_email() es la version sin usar expresiones regulares
//No tocar, la esta haciendo Anibal
function is_email($string)
{
    // Remove whitespace
    $string = trim($string);
    $i=0;//indice
    $ultpos=strlen($string)-1;//ultima posicion del string
    if($string[0]=='@')return false;//Empezaba con arroba
    while(($i!='@')&&($i<=$ultpos)){$i++;}//Busco el arroba
    if($i>$ultpos){return false;}//No tenia arroba el string
    //Aca entra si se encontro el arroba
    $i=0;
    while($i!='@')
           {if($string[$i]!=)}

    $ret = ereg(
                '^([a-z0-9_]|\\-|\\.)+'.
                '@'.
                '(([a-z0-9_]|\\-)+\\.)+'.
                '[a-z]{2,4}$',
                $string);

    return($ret);
}
*/



/*
 *      bool is_clean_text(string string[, int min_length[, int max_length]])
 *      Check if a string contains only a subset of alphanumerics characters
 *      allowed in the Western alphabets. Useful for validation of names.
 *      Optionally check if it has a minimum length of min_length characters and/or a
 *      maximum length of max_length characters.
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