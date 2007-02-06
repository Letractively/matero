<?
/************************************************************************
*                 Nombre Sistema:   Litoral
                 Nombre Libreria:   ver_seccion.php
*                          Autor:   Angeletti, Mariano
*                 Fecha Creacion:   2:54 14/04/2003.
*            Ultima Modificacion:   
*              Funciones creadas:  
*                Que falta Hacer:    hacer el filtro...en un rango de -3 +1
************************************************************************/



// get seccion espacio calcuala el nombre de la seccion ta cual se guarda en el campo seccion de banners
// devuelve solo nmbre de la seccion, si la seccion el espaico es 10 (banner) y
if ($ver==""){$vl_seccion="HOMEPAGE";}
else  {$vl_hasta=strpos($ver,"/");
	   $vl_seccion=substr($ver,0,$vl_hasta);
	   $vl_seccion=strtoupper($vl_seccion); 
       }

 $vg_seccion=$vl_seccion;		   
?>
