<?php
set_file("pagina","trabajos_practicos.html");

//Selecciono todas las comisiones de la catedra
$cons=mysql_query("select * from comision where id_catedra=$id_catedra and publicar='1' and activa='1'");
//Me aseguro de setear la comision que venga en id_comision
if(!$id_comision)
	if(mysql_num_rows($cons)==1){
		$vl_fila=mysql_fetch_array($cons);
		$id_comision=$vl_fila['id_comision'];
	}


//Selecciono todas las comisiones de la catedra
$cons=mysql_query("select * from comision where id_catedra=$id_catedra and publicar='1' and activa='1'");


//Si no encuentra comisiones, vuelve a la pagina principal
if(!mysql_num_rows($cons)||!$modulo12Activado){
    set_file('pagina','error.html');
    //Incluyo el codigo para que se genere el menu y la informacion del encabezado
    
    set_var('mensaje','No existen trabajos prácticos.');
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
    //Obtengo los tps de la materia en la comision id_comision
    $consulta=mysql_query("select trabajo_practico.* from trabajo_practico, tp_comision, comision
                           where trabajo_practico.id_tp=tp_comision.id_tp
                           and tp_comision.id_comision=comision.id_comision
                           and comision.id_catedra=$id_catedra
                           and comision.publicar='1' and comision.activa='1'
                           and comision.id_comision=$id_comision
                           and trabajo_practico.publicar='1'
                           order by trabajo_practico.nombre asc");

    //Si no encuentra tps muestra el mensaje, si encuentra los muestra
    if(!mysql_num_rows($consulta)){
        set_var('mensaje','No existen trabajos prácticos en esta comisión.');
        set_var('comentario1','<!--');
        set_var('comentario2','-->');
        parse("bloquecomentario1","bloquecomentario1",true);
        parse("bloquecomentario2","bloquecomentario2",true);
        }else{
        //Muestro los tps
        while($untp=mysql_fetch_array($consulta)){
		
		
       set_var('titulo',$untp['nombre']);
        if($untp['descrip']!='')
           {set_var('com','<b>: </b>'.$untp['descrip']);
           }else
           {set_var('com','');
           }
        
        



        $idtp=$untp['id_tp'];
		if(convertir_fecha($untp['fecha_entrega'])!="00-00-0000"){
			set_var('fecha',$untp['fecha_entrega']);
			set_var('hora',"<b>Hora: </b>".$untp['hora'].' hs.');
		}
		else{
			set_var('fecha',"sin fecha");
			set_var('hora',"");
		}
		if($untp['archivo']!='')
		{
			set_var('bajar',"<img src='img/down.gif' width='10' height='10'>&nbsp;<a href='bajar_tp.php?id_catedra=$id_catedra&id_trabajo=$idtp'>Bajar TP</a>");
		}
		else
		{
			set_var('bajar','');
		}
		
		
		
        
        //Veo si hay notas corregidas
        $notas=mysql_query("select * from trabajo_practico_notas, tp_comision, alumno_comision, trabajo_practico
                            where trabajo_practico_notas.id_tp=trabajo_practico.id_tp
                            and trabajo_practico.id_tp=tp_comision.id_tp
                            and (trabajo_practico_notas.nota!='' or trabajo_practico_notas.comentario!='')
                            and alumno_comision.id_comision=tp_comision.id_comision
                            and alumno_comision.id_alumno=trabajo_practico_notas.id_alumno
                            and tp_comision.id_comision=$id_comision
                            and trabajo_practico_notas.id_tp=$idtp");
        if(mysql_num_rows($notas)){
            set_var('notas',"<a href='index.php?ver=15&id_catedra=$id_catedra&id_trabajo=$idtp&id_comision=$id_comision'>Notas</a>");
        }else{
            set_var('notas','&nbsp;');
        }
        parse("bloquetp","bloquetp",true);
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