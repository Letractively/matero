<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   plan_catedra_hacer_modif.php
*                          Autor:   Angeletti, Mariano R.
*                 Fecha Creacion:   19-09-03.
*            Ultima Modificacion:   19-09-03.
*           Campos que lee en BD:   tabla administrador
*      Campos que Modifica en BD:   ninguna
*  Descripcion de funcionamiento:   realiza el logueo del usuario
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
include("seguridad_intranet.php");

$size_max_archivo_cont=1048576; //la utilizamos para validar el tamaño del archivo de contenido(1MB en bytes)

$archivo = $_FILES['vf_archivo'];

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


if($vl_error)
{
 set_file("pagina","catedra_plan_modif.html");
 set_var("plan",$vf_plan);
 set_var("archivo",$archivo['name']);
 set_var("mensaje","$vl_mensaje_error");
 set_var("firma",firma());
 parse("bloque","bloque",true);
 pparse("pagina");
 die;
}
// seleccionò la opción de eliminar el archivo
if($vf_eliminar=='1'){
	if ($vf_archivo_anterior!=""){
	unlink("../archivos/$vs_id_catedra/$vc_directorio_plan/$vf_archivo_anterior");
	$vl_update=", nombre_archivo=''";}
}

if(($vf_archivo_anterior != $archivo['name']) && ($archivo['name'] != "")){
////   elimino el archivo anterior, si que habia alguno

		if (($vf_archivo_anterior!="") && ($vf_eliminar!='1')){
	 	unlink("../archivos/$vs_id_catedra/$vc_directorio_plan/$vf_archivo_anterior");
	}
		// subo el archivo eligido, si es que es distinto del anterior
		if ($archivo['name'] != ""){
		$vl_archivo_nombre=str_replace(" ","_",$archivo['name']);
		//move_uploaded_file($vf_archivo,"$vc_directorios_archivos/$vs_id_catedra/$vc_directorio_plan/$vl_archivo_nombre");
		move_uploaded_file($archivo['tmp_name'],"../archivos/$vs_id_catedra/$vc_directorio_plan/$vl_archivo_nombre");
	}
 $vl_update=", nombre_archivo='$vl_archivo_nombre'";		
}
else { if ($vf_eliminar!='1')$vl_update="";}

$vf_plan= $vl_obj=str_replace("\r\n","",$vf_plan);
$vf_plan=str_replace("\'","&acute;",$vf_plan);
$vl_update=("UPDATE catedra_plan SET
                    contenido='$vf_plan'
                   $vl_update
              WHERE id_catedra='$vs_id_catedra'
                    ");
mysql_query($vl_update);					




$vl_mensaje="El Plan de Cátedra se actualizo exitosamente";

header("Location:plan_catedra_modif.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");

?>
