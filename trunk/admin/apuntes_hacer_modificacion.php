<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   apuntes_hacer_modificacion.php
*                          Autor:   Angeletti, Mariano R.
*                 Fecha Creacion:   21-01-04.
*            Ultima Modificacion:   21-01-04.
*           Campos que lee en BD:   tabla apuntes
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   segun la accion que se haya iniciado, puede eliminar, guardad cambios de posicion o ir a la pantalla de agregar otro integrante
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

$vl_error=0;
//Valido los datos
$size_max_archivo_cont=1048576; //la utilizamos para validar el tamaño del archivo de contenido(1MB en bytes)

//Valido el titulo
if (!is_alphanumeric($vf_titulo,2,200))
   {$vl_mensaje_error.="Se ha ingresado un nombre incorrecto<br>";
   $vl_error=1;
   }
/*
//Valido el comentario
if (!is_alphanumeric($vf_comentario,2,500))
   {$vl_mensaje_error.="Se ha ingresado un apellido incorrecto<br>";
   $vl_error=1;
   }
*/
// si el usuario eligió adjuntar archivo se fija que este no tenga tamaño 0
if(($vf_archivo_name!="")&&($vf_archivo_size>$size_max_archivo_cont)){
     $vl_mensaje_error = "Error: el archivo contenido debe ser menor a ".$size_max_archivo_cont." bytes";
     $vl_error = 1;

     }

// si el usuario eligió adjuntar archivo se fija que este no tenga tamaño 0
if( ($vf_archivo_name!="") && ($vf_archivo_size==0)){
      $vl_mensaje_error = "El archivo $vf_archivo_name adjuntado tiene tamaño 0";
      $vl_error = 1;

      }

// si el usuario eligió adjuntar archivo se fija que este se haya subido correctmente

if (($vf_archivo_name!="")&&(!is_uploaded_file($vf_archivo))){
   $vl_mensaje_error=nl2br("Error al subir el archivo, intente nuevamente en unos instantes");
   $vl_error=1;
  }


if ($vl_error){
set_file("pagina","apunte_modificar.html");
set_var("titulo",$vf_titulo);
set_var("comentario",$vf_comentario);
set_var("nombre_archivo","");
set_var("archivo",$vf_archivo_viejo);
set_var("mensaje",$vl_mensaje_error);
set_var("firma",firma());
parse("bloque","bloque",true);
pparse("pagina");
die;
}

// seleccionò la opción de eliminar el archivo
if($vf_eliminar=='1'){
        if ($vf_archivo_viejo!=""){
        unlink("../archivos/$vs_id_catedra/$vc_directorio_apuntes/$ida/$vf_archivo_viejo");
        $vl_update=", nombre_archivo=''";}
}

if(($vf_archivo_viejo!=$vf_archivo_name) && ($vf_archivo_name!="")){
////   elimino el archivo anterior, si que habia alguno

                if (($vf_archivo_viejo!="") && ($vf_eliminar!='1')){
                 unlink("../archivos/$vs_id_catedra/$vc_directorio_apuntes/$ida/$vf_archivo_viejo");
        }
                // subo el archivo eligido, si es que es distinto del anterior
                if ($vf_archivo_name!=""){
                $vl_archivo_nombre=str_replace(" ","_",$vf_archivo_name);
                //move_uploaded_file($vf_archivo,"$vc_directorios_archivos/$vs_id_catedra/$vc_directorio_plan/$vl_archivo_nombre");
                move_uploaded_file($vf_archivo,"../archivos/$vs_id_catedra/$vc_directorio_apuntes/$ida/$vl_archivo_nombre");
        }
 $vl_update=", nombre_archivo='$vl_archivo_nombre'";
}
else { if ($vf_eliminar!='1')$vl_update="";}

$vl_update=("UPDATE apuntes SET
                    titulo='$vf_titulo',
                    descripcion='$vf_comentario'
                   $vl_update
              WHERE id_catedra='$vs_id_catedra'
              and id_apuntes='$ida'
                    ");

mysql_query($vl_update);




$vl_mensaje="El Apuntes se actualizó exitosamente";

header("Location:apuntes_modificar.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje&ida=$ida");

?>