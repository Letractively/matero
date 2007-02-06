<?php
set_file("pagina","links.html");

//Obtengo los links de la catedra
$consulta=mysql_query("select link_tipo.id_link_tipo, link_tipo.id_catedra, link_tipo.nombre as nombrecat,
                       links.nombre as nombrelink, links.descripcion as descrip, links.url as url
                       from link_tipo, links
                       where link_tipo.id_catedra=$id_catedra
                       and link_tipo.id_link_tipo=links.id_link_tipo
                       order by link_tipo.nombre");

//Si no encuentran links, vuelve a la pagina principal
if(!mysql_num_rows($consulta)||!$modulo10Activado){
    set_file('pagina','error.html');
    //Incluyo el codigo para que se genere el menu y la informacion del encabezado
    
    set_var('mensaje','No existen links.');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

//Muestro los tipos de link y los link(manganeta porque no puedo tener bloques anidados)
$tipoviejo="";
while($unlink=mysql_fetch_array($consulta)){
       //Si es un tipo nuevo, lo muestro
       if($tipoviejo!=$unlink['id_link_tipo']){
           set_var('link','<BR><BR><table width="100%"><tr><th bgcolor="#CCCCCC" height="1"><th></tr></table>*&nbsp;<U>'.$unlink['nombrecat'].'</U>');
           parse("bloquelink","bloquelink",true);
           }
       $tipoviejo=$unlink['id_link_tipo'];
       //Muestro el link
       if($unlink['descrip']!='')
       {
       set_var('link',"<br><b><a href=".$unlink['url']." target='_blank'>".$unlink['nombrelink']."</a></b>".': '.nl2br($unlink['descrip']));
       }
       else
       {
       set_var('link',"<br><b><a href=".$unlink['url']." target='_blank'>".$unlink['nombrelink']."</a></b>");
       }
       parse("bloquelink","bloquelink",true);
       }
set_var("firma",firma_web());
pparse("pagina");
?>