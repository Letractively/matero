<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   apunte_hacer_alta.php
*                          Autor:   Angeletti, Mariano R.
*                 Fecha Creacion:   7-11-03.
*            Ultima Modificacion:   7-11-03.
*           Campos que lee en BD:   tabla administrador
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   realiza el logueo del usuario
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");


$size_max_archivo_cont=3048576; //la utilizamos para validar el tamaño del archivo de contenido(1MB en bytes)

$archivo = $_FILES['vf_archivo'];

$vl_error=0;
//Valido los datos


//Valido el nombre
if (!is_alphanumeric($vf_titulo,2,200))
   {$vl_mensaje_error.="Se ha ingresado un título incorrecto<br>";
   $vl_error=1;
   }


// si el usuario eligió adjuntar archivo se fija que este no tenga tamaño 0
if(($archivo['name'] != "")&&($archivo['size'] > $size_max_archivo_cont)){
     $vl_mensaje_error = "Error: el archivo contenido debe ser menor a ".$size_max_archivo_cont." bytes";
     $vl_error = 1;

     }


// si el usuario eligió adjuntar archivo se fija que este no tenga tamaño 0
if( ($archivo['name'] != "") && ($archivo['size'] == 0)){
      $vl_mensaje_error = "El archivo {$archivo['name']} adjuntado tiene tamaño 0";
      $vl_error = 1;

      }

// si el usuario eligió adjuntar archivo se fija que este se haya subido correctmente

if (($archivo['name'] != "")&&(!is_uploaded_file($archivo['tmp_name']))){
   $vl_mensaje_error=nl2br("Error al subir el archivo, intente nuevamente en unos instantes");
   $vl_error=1;
  }


if ($vl_error){
set_file("pagina","apunte_alta.html");
set_var("titulo","$vf_titulo");
set_var("comentario","$vf_comentario");
set_var("nombre_archivo","");
set_var("menu",$vf_menu);
set_var("mensaje",$vl_mensaje_error);
set_var("firma",firma());
parse("bloque","bloque",true);
pparse("pagina");
die;
}



                // subo el archivo eligido
if ($archivo['name'] != ""){
                $vl_archivo_nombre=str_replace(" ","_",$archivo['name']);

        }

else { $vl_archivo_nombre="";}
$sql = "INSERT INTO apuntes (
                                        id_apuntes,
                                        id_catedra,
                                        titulo,
                                        descripcion,
                                        nombre_archivo,
                                        publicar,
                                        fecha
                                        )values(
                                        'NULL',
                                        '$vs_id_catedra',
                                        '$vf_titulo',
                                        '$vf_comentario',
                                        '$vl_archivo_nombre',
                                        '1',
                                        now()
                                        )";





 $vl_update=($sql);
mysql_query($vl_update);

$vl_id=mysql_insert_id();
// creo los directorios para el apunte

$dir = "../archivos/$vs_id_catedra/$vc_directorio_apuntes/$vl_id";
mkdir($dir, 0777);



            // subo el archivo elegido
$dir_objetivo = "../archivos/$vs_id_catedra/$vc_directorio_apuntes/$vl_id/$vl_archivo_nombre";


if ($archivo['name'] != ""){
                $vl_archivo_nombre=str_replace(" ","_",$archivo['name']);
                move_uploaded_file($archivo['tmp_name'],$dir_objetivo);
}
else { $vl_archivo_nombre="";}


$vl_mensaje="El Apunte fue dado de alta exitosamente";
if ($otro) {header("Location:apunte_alta.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje&menu=$vf_menu");  die;}

//print_r($_FILES);


header("Location:apuntes_listado.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
die;
/*
*/


?>