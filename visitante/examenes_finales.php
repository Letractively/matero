<?php
set_file("pagina","examenes_finales.html");

//Obtengo los finales de la materia y la cantidad de notas pasadas
$consulta=mysql_query("select * from examen_final
                       where examen_final.id_catedra=$id_catedra
                       order by examen_final.fecha_examen desc");

//Si no encuentra examenes, vuelve a la pagina principal
if(!mysql_num_rows($consulta)||!$modulo6Activado){
    set_file('pagina','error.html');
    //Incluyo el codigo para que se genere el menu y la informacion del encabezado
    
    set_var('mensaje','No existen exámenes finales.');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

//Muestro los examenes
while($exam=mysql_fetch_array($consulta)){
       set_var('titulo',$exam['nombre']);
       if($exam['descripcion']!='')
           {set_var('com','<b>: </b>'.$exam['descripcion']);
           }else
           {set_var('com','');
           }
       set_var('fecha',convertir_fecha($exam['fecha_examen']));
       set_var('hora',$exam['hora'].' hs.');
       $idf=$exam['id_examen_final'];
       //Veo si hay notas corregidas
       $notas=mysql_query("select * from examen_final_notas where examen_final_notas.id_examen_final=$idf");
       if(mysql_num_rows($notas)){
           set_var('notas',"<a href='index.php?id_catedra=$id_catedra&id_final=$idf&ver=16'>Notas</a>");
       }else{
           set_var('notas','&nbsp;');
       }
       parse("bloquefinal","bloquefinal",true);
       }
set_var("firma",firma_web());
pparse("pagina");
?>