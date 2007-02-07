<?
/************************************************************************
*                 Nombre Sistema:   Litoral
                 Nombre Libreria:   contar_accesos.php
*                          Autor:   Angeletti, Mariano
*                 Fecha Creacion:   2:54 29/08/2003.
*            Ultima Modificacion:   
*              Funciones creadas:  
*                Que falta Hacer:    
************************************************************************/
// incremento la seccion en 1 cada vez que es accedida
$vl_fecha=date("Y-m-d");
mysql_query("update contador_accesos set 
							$vg_seccion=($vg_seccion + 1)
							where fecha='$vl_fecha'	");
							

?>
