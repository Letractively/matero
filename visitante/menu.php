<?php
set_file("pagina","menu.html");

//Obtengo los datos de la materia
$consulta=mysql_query("select * from catedra where id_catedra=$id_catedra");
$lacatedra=mysql_fetch_array($consulta);

//Si no encuentra la catedra vuelve a la pagina de la facu
if(!mysql_num_rows($consulta)){
    set_file('pagina','error.html');
    set_var('mensaje','La página de la cátedra seleccionada no existe.');
    set_var('donde','error_grave.php');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

//Muestro los datos de la catedra
set_var('materia',$lacatedra['nombre']);

//Si la catedra tiene novedades activo el link
$consulta_novedades=mysql_query("select * from novedades where id_catedra=$id_catedra");
if(mysql_num_rows($consulta_novedades)){
    set_var('link_novedades',"<a href='novedades.php?id_catedra=$id_catedra'>Novedades</a>");
    }else{
    set_var('link_novedades','Novedades');
    }

//Si la catedra tiene apuntes activo el link
$consulta_apuntes=mysql_query("select * from apuntes where id_catedra=$id_catedra and publicar=1");
if(mysql_num_rows($consulta_apuntes)){
    set_var('link_apuntes',"<a href='apuntes.php?id_catedra=$id_catedra'>Apuntes</a>");
    }else{
    set_var('link_apuntes','Apuntes');
    }

//Si la catedra tiene integrantes activo el link
$consulta_integrantes=mysql_query("select * from profesor where id_catedra=$id_catedra");
if(mysql_num_rows($consulta_integrantes)){
    set_var('link_integrantes',"<a href='integrantes.php?id_catedra=$id_catedra'>Docentes</a>");
    }else{
    set_var('link_integrantes','Docentes');
    }

//Si la catedra tiene objetivos activo el link
$consulta_objetivos=mysql_query("select * from objetivos where id_catedra=$id_catedra and publicar=1");
if(mysql_num_rows($consulta_objetivos)){
    set_var('link_objetivos',"<a href='objetivos.php?id_catedra=$id_catedra'>Objetivos</a>");
    }else{
    set_var('link_objetivos','Objetivos');
    }

//Si la catedra tiene clases activo el link
$consulta_horarios=mysql_query("select * from horarios where id_catedra=$id_catedra");
if(mysql_num_rows($consulta_horarios)){
    set_var('link_clases',"<a href='horarios.php?id_catedra=$id_catedra'>Horarios</a>");
    }else{
    set_var('link_clases','Horarios');
    }

//Si la catedra tiene plan activo el link
$consulta_plan=mysql_query("select * from catedra_plan where id_catedra=$id_catedra and publicar=1");
if(mysql_num_rows($consulta_plan)){
    set_var('link_plan',"<a href='plan.php?id_catedra=$id_catedra'>Plan</a>");
    }else{
    set_var('link_plan','Plan');
    }

//Si la catedra tiene alguna bibliografia activo el link
$consulta_biblio=mysql_query("select * from biblio where id_catedra=$id_catedra");
if(mysql_num_rows($consulta_biblio)){
    set_var('link_biblio',"<a href='bibliografia.php?id_catedra=$id_catedra'>Bibliografía</a>");
    }else{
    set_var('link_biblio','Bibliografía');
    }

//Si la catedra tiene algun examen final activo el link
$consulta_final=mysql_query("select * from examen_final where id_catedra=$id_catedra");
if(mysql_num_rows($consulta_final)){
    set_var('link_final',"<a href='examenes_finales.php?id_catedra=$id_catedra'>Exámenes Finales</a>");
    }else{
    set_var('link_final','Exámenes Finales');
    }

//Si la catedra tiene algun link activo el link
$consulta_link=mysql_query("select * from links where id_catedra=$id_catedra");
if(mysql_num_rows($consulta_link)){
    set_var('link_link',"<a href='links.php?id_catedra=$id_catedra'>Links</a>");
    }else{
    set_var('link_link','Links');
    }

//Si la catedra tiene items en el repositorio activo el link
$consulta_repositorio=mysql_query("select * from repositorio where id_catedra=$id_catedra and publicar=1");
if(mysql_num_rows($consulta_repositorio)){
    set_var('link_repositorio',"<a href='repositorio.php?id_catedra=$id_catedra'>Repositorio</a>");
    }else{
    set_var('link_repositorio','Repositorio');
    }

//Si la catedra tiene algun examen parcial en alguna comision activo el link
$consulta_parcial=mysql_query("select * from examen_parcial, comision
                               where examen_parcial.id_comision=comision.id_comision
                               and comision.id_catedra=$id_catedra");
if(mysql_num_rows($consulta_parcial)){
    set_var('link_parciales',"<a href='examenes_parciales.php?id_catedra=$id_catedra&id_comision=0'>Exámenes Parciales</a>");
    }else{
    set_var('link_parciales','Exámenes Parciales');
    }

parse("bloque","bloque",true);
set_var("firma",firma_web());
pparse("pagina");
?>