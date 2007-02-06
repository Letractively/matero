<?php


set_file("pagina","examenes_parciales.html");


$cons=mysql_query("select * from comision where id_catedra=$id_catedra and publicar='1' and activa='1'");
//Me aseguro de setear la comision que venga el id_comision
if(!$id_comision)
	if(mysql_num_rows($cons)==1){
		$vl_fila=mysql_fetch_array($cons);
		$id_comision=$vl_fila['id_comision'];
	}

//Selecciono todas las comisiones de la catedra
$cons=mysql_query("select * from comision where id_catedra='$id_catedra' and publicar='1' and activa='1'");

//Si no encuentra comisiones, vuelve a la pagina principal
if(!mysql_num_rows($cons)||!$modulo11Activado){
    set_file('pagina','error.html');
    //Incluyo el codigo para que se genere el menu y la informacion del encabezado
   
    set_var('mensaje','No existen parciales.');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

//Muestro las comisiones
while($comis=mysql_fetch_array($cons)){
        set_var('valoropcion',$comis['id_comision']);
        set_var('nombreopcion',$comis['nombre']);
        if($id_comision==$comis['id_comision']){
            set_var('selected','selected');
            }else{
            set_var('selected','');
            }
        parse("bloquecomision","bloquecomision",true);
        }

//Si esta seteada la comision muestro, sino muestro mensaje
if($id_comision){
    //Obtengo los parciales de la materia en la comision id_comision
    $consulta=mysql_query("select examen_parcial.* from examen_parcial, examen_parcial_comision, comision
                           where examen_parcial.id_examen_parcial=examen_parcial_comision.id_examen_parcial
                           and examen_parcial_comision.id_comision=comision.id_comision
                           and comision.id_catedra=$id_catedra
                           and comision.publicar='1' and comision.activa='1'
                           and examen_parcial.publicar='1'
                           and comision.id_comision=$id_comision
                           order by examen_parcial.fecha desc");

    //Si no encuentra examenes muestra el mensaje, si encuentra los muestra
    if(!mysql_num_rows($consulta)){
        set_var('mensaje','No existen exámenes parciales en esta comisión.');
        set_var('comentario1','<!--');
        set_var('comentario2','-->');
        parse("bloquecomentario1","bloquecomentario1",true);
        parse("bloquecomentario2","bloquecomentario2",true);
     }else{
        //Muestro los examenes
        while($exam=mysql_fetch_array($consulta)){
        set_var('titulo',$exam['nombre']);
        if($exam['descrip']!='')
           {set_var('com','<b>: </b>'.$exam['descrip']);
           }else
           {set_var('com','');
           }
        set_var('fecha',convertir_fecha($exam['fecha']));
        set_var('hora',$exam['hora'].' hs.');
        $idp=$exam['id_examen_parcial'];
        //Veo si hay notas corregidas
        $notas=mysql_query("select * from examen_parcial_notas, examen_parcial, examen_parcial_comision, alumno_comision
                            where examen_parcial_notas.id_examen_parcial=examen_parcial.id_examen_parcial
                            and examen_parcial.id_examen_parcial=examen_parcial_comision.id_examen_parcial
                            and (examen_parcial_notas.nota!='' or examen_parcial_notas.comentario!='')
                            and alumno_comision.id_comision=examen_parcial_comision.id_comision
                            and alumno_comision.id_alumno=examen_parcial_notas.id_alumno
                            and examen_parcial_notas.id_examen_parcial=$idp
                            and examen_parcial_comision.id_comision=$id_comision");

        if(mysql_num_rows($notas)){
            set_var('notas',"<a href='index.php?id_catedra=$id_catedra&id_parcial=$idp&id_comision=$id_comision&ver=17'?>Notas</a>");
        }else{
            set_var('notas','&nbsp;');
        }
        parse("bloqueparcial","bloqueparcial",true);
        }//del while
        set_var('mensaje','');
        set_var('comentario1','');
        set_var('comentario2','');
        parse("bloquecomentario1","bloquecomentario1",true);
        parse("bloquecomentario2","bloquecomentario2",true);
        }//del else
    }else{
    set_var('mensaje','');
    set_var('comentario1','<!--');
    set_var('comentario2','-->');
    parse("bloquecomentario1","bloquecomentario1",true);
    parse("bloquecomentario2","bloquecomentario2",true);
    }

set_var('idc',$id_catedra);
set_var("firma",firma_web());
pparse("pagina");
?>