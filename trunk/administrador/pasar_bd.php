<?php

/********************************************************************************

Archivo para limpiar la bd y hacer el update de la bd de alumnos en el MATERO

Ver. 1.0.1 2004/09/01  ANGELETTI, Mariano

*********************************************************************************/
include("seguridad_intranet.php");

////////////// validacion del archivo que actualiza la bd
// no hay restricciones de tamaño
// si el usuario eligió adjuntar archivo se fija que este no tenga tamaño 0

$vl_mensaje_error = "fffffff";

if($vf_archivo_name==""){
     $vl_mensaje_error = "Error: No eligió archivo.-";
     $vl_error = 1;
     }

// si el usuario eligió adjuntar archivo se fija que este no tenga tamaño 0
if($vf_archivo_size==0){
      $vl_mensaje_error = "El archivo $vf_archivo_name adjuntado tiene tamaño 0";
      $vl_error = 1;

      }

// si el usuario eligió adjuntar archivo se fija que este se haya subido correctmente

if ((!is_uploaded_file($vf_archivo))){
   $vl_mensaje_error=nl2br("Error al subir el archivo, intente nuevamente en unos instantes");
   $vl_error=1;
  }
  
  // si hay error cargo la pag de nuevo con el mensaje ed error
if ($vl_error==1)
	{
	set_file("pagina","seleccion_archivo_bd.html");
	set_var("mensaje","$vl_mensaje_error");

	set_var("firma",firma());
	pparse("pagina");
	die;
	}
// aray de equivalencias entre los id de las carreras en el guarani ocn las carreras del matero
// ver si se puede automatizar mejor
/*
#,INGENIERIA INDUSTRIAL
A,MAESTRIA EN INGENIERIA AMBIENTAL
B,MAESTRIA EN INGENIERIA EN CALIDAD
D,DOCTORADO EN INGENIERIA
H,Esp.en Higiene y Seguridad en el Trabajo
I,LIC. EN ORGANIZACION INDUSTRIAL
J,Tec.Superior en Tecnologias de la Inf.
K,INGENIERIA EN SISTEMAS DE INFORMACION
L,INGENIERIA LABORAL
M,MAESTRIA EN ING. EN SIST.DE INF
O,INGENIERIA CIVIL
P,INGENIERIA EN CONSTRUCCIONES
Q,INGENIERIA ELECTRICA
R,LIC. EN ADMINISTRACION INDUSTRIAL
S,INGENIERIA MECANICA
U,LIC.EN TECNOLOGIA EDUCATIVA
W,LIC. EN ADMINISTRACION RURAL
X,ING. EN CONST. ELECTROMECANICAS
Y,ANALISIS DE SISTEMAS

#,1,INGENIERIA INDUSTRIAL
A,2,MAESTRIA EN INGENIERIA AMBIENTAL
B,3,MAESTRIA EN INGENIERIA EN CALIDAD
D,4,DOCTORADO EN INGENIERIA
H,5,Esp.en Higiene y Seguridad en el Trabajo
I,6,LIC. EN ORGANIZACION INDUSTRIAL
J,7,Tec.Superior en Tecnologias de la Inf.
K,8,INGENIERIA EN SISTEMAS DE INFORMACION
L,9,INGENIERIA LABORAL
M,10,MAESTRIA EN ING. EN SIST.DE INF
O,11,INGENIERIA CIVIL
P,12,INGENIERIA EN CONSTRUCCIONES
Q,13,INGENIERIA ELECTRICA
R,14,LIC. EN ADMINISTRACION INDUSTRIAL
S,15,INGENIERIA MECANICA
U,16,LIC.EN TECNOLOGIA EDUCATIVA
W,17,LIC. EN ADMINISTRACION RURAL
X,18,ING. EN CONST. ELECTROMECANICAS
Y,19,ANALISIS DE SISTEMAS

*/
$id_catedras=array(
				"#"=>"1",//"INGENIERIA INDUSTRIAL",
				"A"=>"2",//MAESTRIA EN INGENIERIA AMBIENTAL
				"B"=>"3",//MAESTRIA EN INGENIERIA EN CALIDAD
				"D"=>"4",//DOCTORADO EN INGENIERIA
				"H"=>"5",//Esp.en Higiene y Seguridad en el Trabajo
				"I"=>"6",//LIC. EN ORGANIZACION INDUSTRIAL
				"J"=>"7",//Tec.Superior en Tecnologias de la Inf.
				"K"=>"8",//"INGENIERIA EN SISTEMAS DE INFORMACION",
				"L"=>"9",//"INGENIERIA LABORAL",
				"M"=>"10",//MAESTRIA EN ING. EN SIST.DE INF
				"O"=>"11",//"INGENIERIA CIVIL"
				"P"=>"12",//INGENIERIA EN CONSTRUCCIONES
				"Q"=>"13",//INGENIERIA ELECTRICA
				"R"=>"14",//LIC. EN ADMINISTRACION INDUSTRIAL				
				"S"=>"15",//"INGENIERIA MECANICA",				
				"U"=>"16",//LIC.EN TECNOLOGIA EDUCATIVA
				"W"=>"17",//LIC. EN ADMINISTRACION RURAL
				"X"=>"11",//"INGENIERIA EN CONST. ELECTROMECANICAS"				
				"Y"=>"19"//"ANALISIS DE SISTEMAS"
				);
 $path_archivo="../archivos/bd_alumnos/alumnos_".date("Y_m_d").".txt";
 $path_archivo_nuevo="../archivos/bd_alumnos/alumnos.txt";

 //chmod( "../archivos/bd_alumnos/alumnos_original.txt", 0755 );  
// copio el archivo en la carpeta archivos/bd_alumnos
 move_uploaded_file($vf_archivo,$path_archivo);


// Obtiene un archivo en una matriz. En este ejemplo usaremos HTTP
// para obtener el codigo fuente HTML de una URL.
$lineas = file($path_archivo);

// si existe el archivo lo elimino y lo creo de nuevo desde cero.
if (file_exists($path_archivo_nuevo)) {
   unlink($path_archivo_nuevo);
}
$file_update=fopen($path_archivo_nuevo,"w");


// Recorrer nuestra matriz, mostrar el codigo HTML como codigo fuente
// HTML, y los numeros de linea tambien.
foreach ($lineas as $linea_num => $linea) {
	$linea=rtrim($linea);
	list($nombre,$apellido,$lu,$dni,$idc)=split(';',$linea); // me carga los campos separados por coma
	$idc=$id_catedras[$idc];
	$linea_update="$idc;$nombre;$apellido;$lu;$dni\r\n";
    fwrite($file_update,$linea_update);
// echo "$apellido,$idc<br>";
}

fclose($file_update);

////////////// ahora hago la conexion a la bd y cargo los registros formaeados en el nuevo archivo


if (mysql_query("TRUNCATE TABLE a_alumno"))// borra el contenido de la tabla ver la posibilidad de hacer un back up
		{
	if (!mysql_query("LOAD DATA LOCAL INFILE '$path_archivo_nuevo' INTO TABLE a_alumno
						FIELDS TERMINATED BY ';' 
            		    LINES TERMINATED BY '\r\n'
						(id_carrera,nombre,apellido,lib_univ,dni)")) {echo mysql_error();echo "No se pudo actualizar la bd";die;}
	
		}

header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=BD actualizada");							
?>