<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   examen_parcial_pimprimir.php
*                          Autor:   A.U.S. Sánchez, Guido S. 
*                 Fecha Creacion:   27-03-04.
*            Ultima Modificacion:   27-03-04.
*           Campos que lee en BD:   
*      Campos que Modifica en BD:   
*  Descripcion de funcionamiento:   Muestra el listado de alumnos y notas con formato para impresión
*              Funciones que usa:
*                Que falta Hacer:
*       Validaciones que realiza:
************************************************************************/
//../archivos/$vs_id_catedra/$vc_directorio_tps/$vl_id_tp/$vl_archivo_nombre

//$rootuser="grupoweb";
$rootuser="matero";
//$rootpass="gwebphp4";
$rootpass="ldmm328";

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
if(!$conexion=conectar()){die("No se conecto con la base de datos");}



for($i=$desde;$i<=$hasta;$i++){
		if ($gestor = opendir('../archivos/'.$i.'/tps')) {
		   echo "ID DE CATEDRA: $i"."<br>";
		   echo "Gestor de directorio: $gestor"."<br>";
		   echo "Directorios de TP:"."<br>";
		
		   /* Esta es la forma correcto de iterar sobre el directorio. */
		   while (false !== ($archivo = readdir($gestor))) {
		   	   if($archivo!="." && $archivo!=".."){
				   echo "TP: $archivo"."<br>";
		   	   
				   if ($nuevo_gestor = opendir('../archivos/'.$i.'/tps/'.$archivo)) {
						echo "Se abrio el directorio: ".'../archivos/'.$i.'/tps/'.$archivo."<br>";
						while (false !== ($nuevo_archivo = readdir($nuevo_gestor))) {
							if($nuevo_archivo!="." && $nuevo_archivo!=".."){
								if(mysql_query("UPDATE trabajo_practico
											 SET archivo='$nuevo_archivo'
											 WHERE id_tp=$archivo"))
									echo "Se realizo bien la consulta"."<br>";
								else
									echo "LA CONSULTA FALLO"."<br>";	
								echo "El archivo se llama: ".$nuevo_archivo."<br>";
							}
						}
						closedir($nuevo_gestor);		
					}
					else{
						echo "<br>"."No se pudo abrir el directorio:   ".'../archivos/'.$i.'/tps/'.$archivo."<br>";				
					}
				}
		   }
		
		   closedir($gestor);
		}
		else{
			echo "<br>"."la catedra $i no existe"."<br>";
		}
}

?>