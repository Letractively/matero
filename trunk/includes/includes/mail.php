<?php
/************************************************************************
*                 Nombre Sistema:   Litoral
*                  Nombre Script:   news_enviar.php
*                          Autor:   Angeletti, Mariano
*                 Fecha Creacion:   2:54 19/05/2003.
*            Ultima Modificacion:   
*           Campos que lee en BD:	
*      Campos que Modifica en BD:
*  Descripcion de funcionamiento:   funciones que facilitan el envío de e-mails
*              Funciones que usa:
*                Que falta Hacer:   
*
************************************************************************/
////////////////////////////////////////////////////////////////////////
/////recibe el mensaje en txt y en html y los manda a vp_destinatario///
////////////////////////////////////////////////////////////////////////]
function mandar_mail($vp_destinatario, $vp_responder_a, $vp_de, $vp_asunto,$vp_mensaje_txt,$vp_mensaje_html){
	#$vp_destinatario -> mail/s a quien/s se envía el corro
	#$vp_responder_a  -> a quien responder
	#$vp_de           -> ccampo from
	#$vp_asunto	      -> asunto, subject del correo
	#$vp_mensaje_txt  -> cuerpo del mensje en formato texto
	#$vp_mensaje_html -> cuerpo mensaje en formato html
	
	$vp_mensaje_txt = strip_tags($vp_mensaje_html);
	
	# creo el separador de bloques del mensaje
	$separador ="----=proximo_".md5 (uniqid (rand()));  
	$cabecera .="MIME-Version: 1.0"."\r\n"; 
	$cabecera .="To: $vp_usuario\r\n";

	//$cabecera .= "Return-path: ". $remite."\r\n";
	$cabecera .="Reply-To: $vp_responder\r\n";
	$cabecera = "Date: ".date("l j F Y, G:i")."\r\n"; 

	# AQUÍ DEFINO EL CONTENIDO MULTIPART, fíjate que lo acabo con ";"
	$cabecera .="Content-Type: multipart/alternative; boundary=\"$separador\"\r\n";
	$cabecera .="From: $vp_de\r\n";

	# inserto el primer separador(con los dos guiones delante)
	# antes de insertar la primera parte del mensaje
	# que es el texto plano para el caso de que el cliente de correo
	# no soporte HTML
	$texto_plano ="--$separador\r\n"; 
	$texto_plano .="Content-Type: text/plain;\n\tcharset=\"ISO-8859-1\"\r\n"; 
	$texto_plano .="Content-Transfer-Encoding: 7bit\r\n\r\n"; //7bit
	$texto_plano .=$vp_mensaje_txt;

	# inserto un nuevo separador para señalar el final
	# de la primera parte del mensaje y el comienzo de la segunda 
	# en este caso pongo UN SALTO delante del separado ya que de lo contrario
	# al componer el mensaje se uniría con la cadena texto_plano anterior
	# que no tiene SALTO DE LINEA AL FINAL
	$texto_html ="\n--$separador\r\n";
	$texto_html .="Content-Type: text/html;\n\tcharset=\"ISO-8859-1\"\r\n"; 
	$texto_html .="Content-Transfer-Encoding: 7bit\r\n\r\n";

	#añado la cadena que contiene el mensaje
	$texto_html .= $vp_mensaje_html; 

	# inserto un separador para indicar el final de esta parte
	# y le antepongo un SALTO DE LINEA por la misma razón que en el caso anterior
	$texto_html .="\r\n--$separador--\n"; 
	$mensaje=$texto_plano.$texto_html;
	mail($vp_destinatario, $vp_asunto, $mensaje,$cabecera);
	}
?>