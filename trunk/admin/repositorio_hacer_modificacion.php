<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   repositorio_hacer_modificacion.php
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

$size_max_archivo_cont=3154728; //la utilizamos para validar el tama�o del archivo de contenido(1MB en bytes)
//Valido el nombre
if (!is_alphanumeric($vf_titulo,2,200))
   {$vl_mensaje_error.="Se ha ingresado un t�tulo incorrecto<br>";
   $vl_error=1;
   }
/*
//Valido el comentareio
if (!is_alpha($vf_comentario,2,200))
   {$vl_mensaje_error.="Se ha ingresado un apellido incorrecto<br>";
   $vl_error=1;
   }
*/
// si el usuario eligi� adjuntar archivo se fija que este no tenga tama�o 0
if(($vf_archivo_name!="")&&($vf_archivo_size>$size_max_archivo_cont)){
     $vl_mensaje_error = "Error: el archivo contenido debe ser menor a ".$size_max_archivo_cont." bytes";
     $vl_error = 1;

     }

// si el usuario eligi� adjuntar archivo se fija que este no tenga tama�o 0
if( ($vf_archivo_name!="") && ($vf_archivo_size==0)){
      $vl_mensaje_error = "El archivo $vf_archivo_name adjuntado tiene tama�o 0";
      $vl_error = 1;

      }

// si el usuario eligi� adjuntar archivo se fija que este se haya subido correctmente

if (($vf_archivo_name!="")&&(!is_uploaded_file($vf_archivo))){
   $vl_mensaje_error=nl2br("Error al subir el archivo, intente nuevamente en unos instantes");
   $vl_error=1;
  }


if ($vl_error){
set_file("pagina","repositorio_modificar.html");
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

// seleccion� la opci�n de eliminar el archivo
if($vf_eliminar=='1'){
        if ($vf_archivo_viejo!=""){
        unlink("../archivos/$vs_id_catedra/$vc_directorio_repositorios/$idr/$vf_archivo_viejo");
        $vl_update=", nombre_archivo=''";}
}

if(($vf_archivo_viejo!=$vf_archivo_name) && ($vf_archivo_name!="")){
////   elimino el archivo anterior, si que habia alguno

                if (($vf_archivo_viejo!="") && ($vf_eliminar!='1')){
                 unlink("../archivos/$vs_id_catedra/$vc_directorio_repositorios/$idr/$vf_archivo_viejo");
        }
                // subo el archivo eligido, si es que es distinto del anterior
                if ($vf_archivo_name!=""){
                $vl_archivo_nombre=str_replace(" ","_",$vf_archivo_name);
                //move_uploaded_file($vf_archivo,"$vc_directorios_archivos/$vs_id_catedra/$vc_directorio_plan/$vl_archivo_nombre");
                move_uploaded_file($vf_archivo,"../archivos/$vs_id_catedra/$vc_directorio_repositorios/$idr/$vl_archivo_nombre");
        }
 $vl_update=", nombre_archivo='$vl_archivo_nombre'";
}
else { if ($vf_eliminar!='1')$vl_update="";}

$vl_update=("UPDATE repositorio SET
                    titulo='$vf_titulo',
                    descripcion='$vf_comentario'
                   $vl_update
              WHERE id_catedra='$vs_id_catedra'
              and id_repositorio='$idr'
                    ");

mysql_query($vl_update);




$vl_mensaje="El Item se actualiz� exitosamente";

header("Location:repositorio_modificar.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje&idr=$idr");

?>