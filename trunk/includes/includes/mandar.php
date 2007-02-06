<?php
// hay que borrarlo pruebo a mandar mail
include("./mail.php");

//mandar_mail($vp_destinatario, $vp_responder_a, $vp_de, $vp_asunto,$vp_mensaje_txt,$vp_mensaje_html);

$vl_mensaje_html = "Hola, este mensaje está en formata de <b>html</b> y ahora


 voy hacer<br>
  dos saltso de línes larga larga larga larga larga larga larga larga larga larga larga larga línes larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga
<b>larga</b> larga larga larga larga larga larga larga larga larga larga larga línes larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga línes larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga línes larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga larga
ahora voy a pner dos br <br><br> ahora voy a poner dos barra n barra r \n\r chau
";

mandar_mail("mbotta@arnet.com.ar", "Marcos <mbotta@arnet.com.ar>", "Marcos <mbotta@arnet.com.ar>", "Hola","",$vl_mensaje_html);
die();
?>