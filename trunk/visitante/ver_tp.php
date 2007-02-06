<?php

//include('seguridad_intranet.php');

//Valido que venga el id_trabajo, el id_catedra y el id_comision
if((empty($id_trabajo))||(empty($id_catedra))||(empty($id_comision))){
    set_file('pagina','error_grave.html');
    set_var('mensaje','Error de parámetros');
    set_var('donde','error_grave.php');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
    }

set_file("pagina","ver_tp.html");

//Incluyo el codigo para que se genere el menu y la informacion del encabezado
//include('include_menu.php');

//Obtengo la informacion del tp
$consulta=mysql_query("select trabajo_practico.* from trabajo_practico, comision, tp_comision
                           where trabajo_practico.id_tp=tp_comision.id_tp
                           and tp_comision.id_comision=comision.id_comision
                           and comision.id_catedra=$id_catedra
                           and comision.publicar='1' and comision.activa='1'
                           and comision.id_comision=$id_comision
                           and trabajo_practico.id_tp=$id_trabajo
                           and trabajo_practico.publicar='1'
                           order by trabajo_practico.fecha_entrega desc");

//Si no encuentra comisiones, vuelve a la pagina principal
/*if(!mysql_num_rows($consulta)||!$modulo12Activado){
    set_file('pagina','error.html');
    //Incluyo el codigo para que se genere el menu y la informacion del encabezado
    include('include_menu.php');
    set_var('mensaje','No existe el trabajo práctico.');
    parse("bloque","bloque",true);
	set_var("firma",firma_web());
    pparse("pagina");
    die();
    }*/

//Muestro el tp
$untp=mysql_fetch_array($consulta);
set_var('titulo',$untp['nombre']);
set_var('descrip',$untp['descrip']);
if (convertir_fecha($untp['fecha_entrega'])!="00-00-0000"){
	set_var('fecha_entrega',convertir_fecha($untp['fecha_entrega']));
	set_var('hora',$untp['hora']);	
}
else {set_var('fecha_entrega',"Sin fecha");	set_var('hora',"");}
set_var('comentario_notas',$untp['comentario_notas']);
//Veo si tiene trabajo practico para bajar
if($untp['archivo']!='')
{
    set_var('bajar',"<img src='img/down.gif' width='10' height='10'>&nbsp;<a href='bajar_tp.php?id_catedra=$id_catedra&id_trabajo=$id_trabajo'>Bajar TP</a>");
}
else
{
    set_var('bajar','');
}

//Veo si tiene notas cargadas
$consulta_notas=mysql_query("select * from trabajo_practico_notas where trabajo_practico_notas.id_tp=$id_trabajo");
if(mysql_num_rows($consulta_notas))
{
   set_var('notas',"<a href='ver_notas_tp.php?id_catedra=$id_catedra&id_trabajo=$id_trabajo&id_comision=$id_comision'>Notas</a>");
}
else
{
   set_var('notas','');
}


parse('bloque2','bloque2',true);

//Seteo para el boton volver
set_var('idc',$id_catedra);
set_var('idcomision',$id_comision);
parse('bloque','bloque',true);
set_var("firma",firma_web());
pparse("pagina");
?>