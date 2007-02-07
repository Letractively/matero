<?php
//Valido que venga el id_catedra
if(empty($id_catedra)){
    set_file('pagina','error_grave.html');
    set_var('mensaje','Error de parámetros');
    set_var('donde','error_grave.php');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

//Obtengo los datos de la materia
$consulta=mysql_query("select * from catedra where id_catedra=$id_catedra");
$lacatedra=mysql_fetch_array($consulta);

//Si no encuentra la catedra vuelve a la pagina de la facu
if(!mysql_num_rows($consulta)){
    set_file('pagina','error_grave.html');
    set_var('mensaje','La página de la cátedra seleccionada no existe.');
    set_var('donde','error_grave.php');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

set_file("pagina","include_menu.html");



//Busco los modulos que tiene publicados la pagina
$sql_modulos = "select * from modulos where id_catedra='$id_catedra' order by modulo";
$modulos=mysql_query($sql_modulos);
//echo $sql_modulos;

//Recorro todos los modulos y en base a esto creo las variables $modulo$nroActivado y le asigno 1 o 0
//por ejemplo $modulo1Activado=1 significa que se publica el plan de catedras y
//$modulo7Activado=0 significa que no se publican los horarios
while($unmodulo=mysql_fetch_array($modulos))
{
     $variable='modulo'.$unmodulo['modulo'].'Activado';
     $$variable=$unmodulo['publicar'];
}

//Muestro los datos de la catedra
set_var('materia',strtoupper($lacatedra['nombre']));

//Muestro el path de la universidad virtual
set_var('path',"<a class='barra' href='http://www.frsf.utn.edu.ar/index.php?id=21'>Inicio</a> &gt; <a class='barra' href='http://www.frsf.utn.edu.ar/index.php?id=1'>Académica</a> &gt; <a class='barra' href='http://www.frsf.utn.edu.ar/index.php?id=13'>Sitios Web Cátedras</a>");

//Si la catedra tiene novedades activo el link
$consulta_novedades=mysql_query("select * from novedades where id_catedra=$id_catedra");
if(mysql_num_rows($consulta_novedades)&&$modulo5Activado){
    set_var('link_novedades',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'><A HREF='index.php?id_catedra=$id_catedra&ver=1' class='color_modulo_activo'>Novedades</A>");
    }else{
    set_var('link_novedades',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'>Novedades");
    }

//Si la catedra tiene apuntes activo el link
$consulta_apuntes=mysql_query("select * from apuntes where id_catedra=$id_catedra and publicar=1");
if(mysql_num_rows($consulta_apuntes)&&$modulo4Activado){
    set_var('link_apuntes',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'><a href='index.php?id_catedra=$id_catedra&ver=2'  class='color_modulo_activo'>Apuntes</a>");
    }else{
    set_var('link_apuntes',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'>Apuntes");
    }

//Si la catedra tiene integrantes activo el link
$consulta_integrantes=mysql_query("select * from profesor where id_catedra=$id_catedra");
if(mysql_num_rows($consulta_integrantes)&&$modulo3Activado){
    set_var('link_integrantes',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'><a href='index.php?id_catedra=$id_catedra&ver=3'  class='color_modulo_activo'>Docentes</a>");
    }else{
    set_var('link_integrantes',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'>Docentes");
    }

//Si la catedra tiene objetivos activo el link
$consulta_objetivos=mysql_query("select * from objetivos where id_catedra=$id_catedra");
if(mysql_num_rows($consulta_objetivos)&&$modulo2Activado){
    set_var('link_objetivos',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'><a href='index.php?id_catedra=$id_catedra&ver=4' class='color_modulo_activo'>Objetivos</a>");
    }else{
    set_var('link_objetivos',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'>Objetivos");
    }

//Si la catedra tiene clases activo el link
$consulta_horarios=mysql_query("select * from horarios where id_catedra=$id_catedra");
if(mysql_num_rows($consulta_horarios)&&$modulo7Activado){
    set_var('link_clases',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'><a href='index.php?id_catedra=$id_catedra&ver=5'  class='color_modulo_activo'>Horarios</a>");
    }else{
    set_var('link_clases',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'>Horarios");
    }

//Si la catedra tiene plan activo el link
$consulta_plan=mysql_query("select * from catedra_plan where id_catedra=$id_catedra");
if(mysql_num_rows($consulta_plan)&&$modulo1Activado){
    set_var('link_plan',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'><a href='index.php?id_catedra=$id_catedra&ver=6'  class='color_modulo_activo'>Plan</a>");
    }else{
    set_var('link_plan',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'>Plan");
    }

//Si la catedra tiene alguna bibliografia activo el link
$consulta_biblio=mysql_query("select * from biblio where id_catedra=$id_catedra");
if(mysql_num_rows($consulta_biblio)&&$modulo9Activado){
    set_var('link_biblio',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'><a href='index.php?id_catedra=$id_catedra&ver=7'  class='color_modulo_activo'>Bibliografía</a>");
    }else{
    set_var('link_biblio',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'>Bibliografía");
    }

//Si la catedra tiene algun examen final activo el link
$consulta_final=mysql_query("select * from examen_final where id_catedra=$id_catedra");
if(mysql_num_rows($consulta_final)&&$modulo6Activado){
    set_var('link_final',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'><a href='index.php?id_catedra=$id_catedra&ver=8'  class='color_modulo_activo'>Exámenes Finales</a>");
    }else{
    set_var('link_final',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'>Exámenes Finales");
    }

//Si la catedra tiene algun link activo el link
$consulta_link=mysql_query("select * from links where id_catedra=$id_catedra");
if(mysql_num_rows($consulta_link)&&$modulo10Activado){
    set_var('link_link',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'><a href='index.php?id_catedra=$id_catedra&ver=9'  class='color_modulo_activo'>Links</a>");
    }else{
    set_var('link_link',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'>Links");
    }

//Si la catedra tiene items en el repositorio activo el link
$consulta_repositorio=mysql_query("select * from repositorio where id_catedra=$id_catedra and publicar=1");
if(mysql_num_rows($consulta_repositorio)&&$modulo8Activado){
    set_var('link_repositorio',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'><a href='index.php?id_catedra=$id_catedra&ver=10'  class='color_modulo_activo'>Repositorio</a>");
    }else{
    set_var('link_repositorio',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'>Repositorio");
    }

//Si la catedra tiene algun examen parcial en alguna comision activo el link
$consulta_parcial=mysql_query("select * from examen_parcial, examen_parcial_comision, comision
                               where examen_parcial.id_examen_parcial=examen_parcial_comision.id_examen_parcial
                               and examen_parcial_comision.id_comision=comision.id_comision
                               and comision.id_catedra=$id_catedra");
if(mysql_num_rows($consulta_parcial)&&$modulo11Activado){
    set_var('link_parciales',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'><a href='index.php?id_catedra=$id_catedra&id_comision=0&ver=11'  class='color_modulo_activo'>Exámenes Parciales</a>");
    }else{
    set_var('link_parciales',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'>Exámenes Parciales");
    }

//Si la catedra tiene algun trabajo practico activo el link
/*$consulta_tps=mysql_query("select * from trabajo_practico, tp_comision, comision
                               where trabajo_practico.id_tp=tp_comision.id_tp
                               and tp_comision.id_comision=comision.id_comision
                               and comision.id_catedra=$id_catedra
                               and trabajo_practico.publicar='1'");*/
$consulta_tps=mysql_query("SELECT  * 
FROM  `tp_comision` t, comision c,trabajo_practico tp
WHERE t.id_comision = c.id_comision AND t.id_tp=tp.id_tp 
  AND c.publicar =  '1' AND c.activa =  '1' 
  AND tp.publicar='1' 
  AND c.id_catedra = $id_catedra");
							   
if(mysql_num_rows($consulta_tps)&&$modulo12Activado){
    set_var('link_tps',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'><a href='index.php?id_catedra=$id_catedra&id_comision=0&ver=12'  class='color_modulo_activo'>Trabajos Prácticos</a>");
    }else{
    set_var('link_tps',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'>Trabajos Prácticos");
    }

//Si la catedra trabaja con consultas las activo

$buscar=mysql_query("SELECT * FROM consultas_tema WHERE id_catedra=$id_catedra and publicar=1");

if(mysql_num_rows($buscar) && $modulo14Activado){
    set_var('link_consulta',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'><a href='index.php?id_catedra=$id_catedra&ver=14'  class='color_modulo_activo'>Consultanos</a>");
    }else{
    set_var('link_consulta',"<img src='imagenes/flecha.gif' width='10' height='10' hspace='5'>Consultanos");
    }


set_var("id_catedra",$id_catedra);

set_var("firma",firma_web());
parse("bloquemenu","bloquemenu",true);
pparse("pagina");
?>