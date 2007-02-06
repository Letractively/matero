<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   repositorio_hacer_alta.php
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

$vl_error=0;
//Valido los datos
$size_max_archivo_cont=3154728; //la utilizamos para validar el tamaño del archivo de contenido(3MB en bytes)

//Valido el nombre
if (!is_alphanumeric($vf_titulo,2,200))
   {$vl_mensaje_error.="Se ha ingresado un título incorrecto<br>";
   $vl_error=1;
   }
/*
//Valido el apellido
if (!is_alphanumeric($vf_comentario,2,200))
   {$vl_mensaje_error.="Se ha ingresado un apellido incorrecto<br>";
   $vl_error=1;
   }*/

// si el usuario eligió adjuntar archivo se fija que este no tenga tamaño 0
if(($vf_archivo_name!="")&&($vf_archivo_size>$size_max_archivo_cont)){
     $vl_mensaje_error .= "Error: el archivo contenido debe ser menor a ".$size_max_archivo_cont." bytes";
     $vl_error = 1;

     }

// si el usuario eligió adjuntar archivo se fija que este no tenga tamaño 0
if( ($vf_archivo_name!="") && ($vf_archivo_size==0)){
      $vl_mensaje_error .= "El archivo $vf_archivo_name adjuntado tiene tamaño 0";
      $vl_error = 1;

      }

// si el usuario eligió adjuntar archivo se fija que este se haya subido correctmente

if (($vf_archivo_name!="")&&(!is_uploaded_file($vf_archivo))){
   $vl_mensaje_error.=nl2br("Error al subir el archivo, intente nuevamente en unos instantes");
   $vl_error=1;
  }


if ($vl_error){
set_file("pagina","repositorio_alta.html");
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
if ($vf_archivo_name!=""){
                $vl_archivo_nombre=str_replace(" ","_",$vf_archivo_name);

        }

else { $vl_archivo_nombre="";}

 $vl_update=("INSERT INTO repositorio (
                                        id_repositorio,
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
                                        '0',
                                        now()
                                        )");
mysql_query($vl_update);

$vl_id=mysql_insert_id();
// creo los directorios para el apunte
mkdir("../archivos/$vs_id_catedra/$vc_directorio_repositorios/$vl_id", 0777);

            // subo el archivo eligido
if ($vf_archivo_name!=""){
                $vl_archivo_nombre=str_replace(" ","_",$vf_archivo_name);
                move_uploaded_file($vf_archivo,"../archivos/$vs_id_catedra/$vc_directorio_repositorios/$vl_id/$vl_archivo_nombre");
        }

else { $vl_archivo_nombre="";}

$vl_mensaje="El ITEM fue dado de alta exitosamente";
if ($otro) {header("Location:repositorio_alta.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje&menu=$vf_menu");  die;}

header("Location:repositorio_listado.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");



?>