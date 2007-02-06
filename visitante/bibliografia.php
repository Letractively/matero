<?php
set_file("pagina","bibliografia.html");

//Obtengo la bibliografia de la catedra
$consulta=mysql_query("select biblio_tipo.id_biblio_tipo, biblio_tipo.id_catedra, biblio_tipo.nombre as nombrecat,
                       biblio.nombre as nombrebiblio, biblio.descripcion as descrip
                       from biblio_tipo, biblio
                       where biblio_tipo.id_catedra=$id_catedra
                       and biblio_tipo.id_biblio_tipo=biblio.id_biblio_tipo
                       order by biblio_tipo.nombre");


//Si no encuentran bibliografia, vuelve a la pagina principal
if(!mysql_num_rows($consulta)||!$modulo9Activado){
    set_file('pagina','error.html');
    //Incluyo el codigo para que se genere el menu y la informacion del encabezado
    
    set_var('mensaje','No existe bibliografía.');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

//Muestro los tipos de bibliografia y la bibliografia(manganeta porque no puedo tener bloques anidados)
$tipoviejo="";
while($unabiblio=mysql_fetch_array($consulta)){
       //Si es un tipo nuevo, lo muestro
       if($tipoviejo!=$unabiblio['id_biblio_tipo']){
           set_var('biblio','<br><br><table width="100%"><tr><th bgcolor="#CCCCCC" height="1"><th></tr></table>*&nbsp;<u>'.$unabiblio['nombrecat']."</u>");
           parse("bloquebiblio","bloquebiblio",true);
           }
       $tipoviejo=$unabiblio['id_biblio_tipo'];
       //Muestro la bibliografia
       set_var('biblio',"<br><b>".$unabiblio['nombrebiblio']."</b>: ".nl2br($unabiblio['descrip']));
       parse("bloquebiblio","bloquebiblio",true);
       }
set_var("firma",firma_web());

pparse("pagina");
?>