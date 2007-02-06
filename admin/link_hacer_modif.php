<?php
/************************************************************************
*                 Nombre Sistema:   Matero.
*                  Nombre Script:   link_hacer_modif.php
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


$vl_error=0;
//Valido los datos

if ($vf_tipo=='0')
   {$vl_mensaje_error.="No ha seleccionado un tipo de link<br>";
   $vl_error=1;
   }
//Valido el nombre
if (!is_alphanumeric($vf_nombre,2,200) || ($vf_nombre==""))
   {$vl_mensaje_error.="Se ha ingresado un nombre incorrecto<br>";
   $vl_error=1;
   }

if (strstr($vf_url,"http://"))  $vl_url=$vf_url;
else  $vl_url="http://$vf_url";


if($vl_error==1){
set_file("pagina","link_modif.html");
$vl_query=mysql_query("Select *
						from link_tipo
						where id_catedra= '$vs_id_catedra'");
while ($vl_fila=mysql_fetch_array($vl_query))
 	{
	if ($vf_tipo == $vl_fila[id_link_tipo]) {set_var("chek","selected");
											 	}
	else set_var("chek","");
	set_var("idt",$vl_fila[id_link_tipo]);
	set_var("tipo",$vl_fila[nombre]);
	parse("link","link",true);	
 	}	
set_var("url",$vl_url);	
set_var("idi",$idi);
set_var("nombre",$vf_nombre);
set_var("descri",$vf_descri);
set_var("mensaje",$vl_mensaje_error);
set_var("firma",firma());
parse("datos","datos",true);
pparse("pagina");
die;
}

if (mysql_query("UPDATE links set
                  nombre = '$vf_nombre',
                  descripcion = '$vf_descri',
				  url = '$vl_url',
				  id_link_tipo = '$vf_tipo'
                  WHERE id_catedra = '$vs_id_catedra'
                  AND   id_link = '$idi'")){
                                                        $vl_mensaje="Se modificó el link exitosamente";

                                                        }
else{
        $vl_mensaje="No se pudo modificar el link ";
}

header("Location:link_listado.php?PHPSESSID=$PHPSESSID&mensaje=$vl_mensaje");
?>