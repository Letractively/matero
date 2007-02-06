<?php

/************************************************************************
*                 Nombre Sistema:   Virtual Cátedra.
*                  Nombre Script:   hacer_alta_usuario.php
*                          Autor:   Guido S., Mariano A
*                 Fecha Creacion:   19-09-03.
*            Ultima Modificacion:   19-09-03.
*           Campos que lee en BD:   tabla usuario
*      Campos que Modifica en BD:   tabla usuario
*  Descripcion de funcionamiento:   hace el alta de usuario y valida los datos
*              Funciones que usa:   funciones de validación, otras
*                Que falta Hacer:   listo.-
*       Validaciones que realiza:   is_email, nombre, apellido, password, que no se repita el nick, etc.
************************************************************************/

//Incluye archivos de seguridad
include ("seguridad_intranet.php");


$vl_error=0;
//Valido los datos


//Valido el asunto
if (!isset($vf_asunto))
   {$vl_mensaje_error.="No se ha ingresado asunto<br>";
   $vl_error=1;
}
//Valido el mensaje
if (!isset($vf_contenido))
   {$vl_mensaje_error.="El mensaje esta vacio<br>";
   $vl_error=1;
}


//Acá entra si hubo algún error
if ($vl_error){
		set_file("pagina","lista_correo.html");
		set_var("mensaje",$vl_mensaje_error);
		set_var("vf_asunto",$vf_asunto);
		set_var("vf_texto",$vf_texto);
		set_var("firma",firma());
		parse("datos","datos",true);
		pparse ("pagina");        
		die();
}
/*
$to  = "sistema_matero@yahoo.com";
$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'To:'. "$nombre" . '<' . "$to" .'>' . "\r\n";
$headers .= 'From: SUSSAN BOUTIQUE <msgiulietti@gigared.com>' . "\r\n";
$headers .= 'Cc: ' . "\r\n";
$headers .= 'Bcc: ' . "\r\n";
*/


$headers  = 'MIME-Version: 1.0' . "\r\n";
$headers .= 'Content-type: text/html; charset=iso-8859-1' . "\r\n";
$headers .= 'From: sistema_matero <sistema_matero@yahoo.com>' . "\r\n";
//Envio los mails

   

if($vf_usuario==0){
	$vl_busco=mysql_query("select * from usuario");
	while($vl_fila=mysql_fetch_array($vl_busco)){
		$to =$vl_fila[email];
		mail($to, $vf_asunto, $vf_contenido,$headers);
	}  
}
else{
	$vl_busco=mysql_query("SELECT * FROM usuario WHERE id_usuario=$vf_usuario");
	$vl_fila=mysql_fetch_array($vl_busco);
	$to =$vl_fila[email];
	mail($to, $vf_asunto, $vf_contenido,$headers);
}
    mail('sistema_matero@yahoo.com', $vf_asunto, $vf_contenido,$headers);
	   	   
//Mensaje de exito

$texto.="Se ha enviado el mensaje correctamente";
header("Location:menu.php?PHPSESSID=$PHPSESSID&mensaje=$texto");
?>