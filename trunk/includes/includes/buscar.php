<?php
/************************************************************************
*                 Nombre Sistema:   Litoral
                 Nombre Libreria:   buscar.php
*                          Autor:   Angeletti, Mariano
*                 Fecha Creacion:   2:54 14/04/2003.
*            Ultima Modificacion:   
*              Funciones creadas:  buscar($vp_clave, $vp_consulta_superior, $vp_consulta_inferior)
*							       resaltar ($vp_clave, $vp_texto)
*								es_clave($vp_clave)
*                Que falta Hacer:
*
************************************************************************/
// función buscar: creada por Mariano Angeletti 
//                  creado 08/05/03
// Parametros:
// $vp_clave = es la o las palabras claves que se buscam
// $vp_consulta_superior = es la parte superior de la consulta ....debe ser de la forma:
//  									"Select *|algo
//										 from tabla*
//									     where algo <<<<<<< en caso que se quiere machear algo
// $vp_consulta_inferior = es la parte inferior de la consulta....debe ser de la forma:<<<<< por defecto sera "
//										 order by algo
//										 group by algo" 
// QUE DEVUELVE???? retorna todos los registros que contengan alguna de las claves
function buscar($vp_clave, $vp_consulta_superior, $vp_consulta_inferior)
{
//esta funcion va separando por palabra por cada espacioo en blanco que aparezca
$vp_clave=sacar_comunes($vp_clave); // funcion de buscar.php
if($vp_clave==""){					// porque sino me devuelve todo
			$vp_clave=asdfafjkglñ;
				}
$vl_cant=strtok($vp_clave," ");
$vl_busca=$vl_busca." and ( pregunta like '%".$vp_clave."%' ";
while (!($vl_cant===FALSE)) 
	{        // voy armando la parte de la consulta que busca las palabras
   	$vl_busca=$vl_busca." or pregunta like '%".$vl_cant."%' ";
	$vl_cant = strtok (" ");
	}
$vl_busca=$vl_busca." )"; //cierro 

$vl_consulta=$vp_consulta_superior.$vl_busca.$vp_consulta_inferior; // armo la consulta

$vl_preguntas=mysql_query($vl_consulta);


return $vl_preguntas;
};
///////77777777777777777777777777777777 FIN BUSCAR 7777777777777777777777////////////
//
// función resaltar: creada por Mariano Angeletti 
//                  creado 08/05/03
// Parametros:
// $vp_clave = es la o las palabras claves que se buscam
// $vp_texto = texto en el que se desea resaltar la clave
// QUE DEVUELVE? el texto pero con las palabras claves que contiene en negrita

function resaltar ($vp_clave, $vp_texto)
{
	// reemplazo en negrita las palabras claves
		$vl_pregunta=$vp_texto;
		$vp_clave=sacar_comunes($vp_clave); // funcion de buscar.php
		$vl_cant=strtok($vp_clave," ");
		while (!($vl_cant===FALSE)) 
			{
			 $vl_pal=negrita($vl_cant);
		     $vl_pregunta=eregi_replace($vl_cant,$vl_pal,$vl_pregunta);
	         $vl_cant = strtok (" ");


			}
			
return $vl_pregunta;
};

function sacar_comunes($vp_clave)
			{
$vl_palabras_comunes="a ante bajo con contra de desde durante en entre hacia hasta para por según sin sobre tras YO 
 MÍ   ME CONMIGO TÚ TI TE CONTIGO ÉL ELLA SÍ SE CONSIGO NOSOTROS NOS VOSOTROS
SÍ SE ELLOS ELLAS el ESTE  ESTA ESTO ESTOS ESTAS ESE ESA ESO ESOS ESAS AQUEL
 AQUELLA AQUELLO AQUELLOS AQUELLAS se es
"; // palabras comunes utilizadas en el buscador para obviarlas
		$vl_cant=strtok($vp_clave," ");
		$vl_clave="";
		while (!($vl_cant===FALSE))
				{        // voy armando la parte de la consulta que busca las palabras
       	if(stristr($vl_palabras_comunes,$vl_cant)===FALSE)
					{
					$vl_clave=$vl_clave.$vl_cant." ";
	   				$vl_cant = strtok (" ");
					}
			else {$vl_cant = strtok (" ");}
				}	
		return  $vl_clave;
				
		}
?>