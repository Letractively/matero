<?php
//include("seguridad_intranet.php");


set_file("pagina","consultas.html");

//Establesco lo primero que voy a mostrar
if(!isset($vf_id_tema)){
    $query=mysql_query("SELECT * FROM consultas_tema WHERE actual=1 and id_catedra=$id_catedra");
	$fila=mysql_fetch_array($query);
	$vl_tema=$fila['id_tema'];
}
else
	$vl_tema=$vf_id_tema;

//Selecciono todas las ...
$cons=mysql_query("select * from consultas_tema where id_catedra='$id_catedra'");

//Si no ...
if(!mysql_num_rows($cons)||!$modulo11Activado){
    set_file('pagina','error.html');
    //Incluyo el codigo para que se genere el menu y la informacion del encabezado
    
    set_var('mensaje','No existen consultas.');
    parse("bloque","bloque",true);
    pparse("pagina");
    die();
}

//Muestro los temas
while($tema=mysql_fetch_array($cons)){
		$query=mysql_query("select * from consultas where id_tema=$tema[id_tema] and publicar=1");
		if(mysql_num_rows($query)){
        	set_var('valoropcion',$tema['id_tema']);
        	set_var('nombreopcion',$tema['nombre']);
        	if($vl_tema==$tema['id_tema']){
           		set_var('selected','selected');
            }else{
            	set_var('selected','');
            }
			parse("bloquecomision","bloquecomision",true);
		}
        
}




  $consulta=mysql_query("select * 
	                       from consultas 
                           where id_catedra=$id_catedra and
						   publicar='1' and
						   id_tema=$vl_tema
                           order by fecha_respuesta desc,posicion desc");


if(mysql_num_rows($consulta)){
    

    //Si no encuentra consultas muestra el mensaje, si encuentra los muestra
    if(!mysql_num_rows($consulta)){
        set_var('mensaje','No existen consultas en este tema.');
        set_var('comentario1','<!--');
        set_var('comentario2','-->');
        parse("bloquecomentario1","bloquecomentario1",true);
        parse("bloquecomentario2","bloquecomentario2",true);
        }else{
        //Muestro las consultas
       		while($consul=mysql_fetch_array($consulta)){
					set_var('fecha_consulta',convertir_fecha($consul['fecha_consulta']));
					set_var('consulta',$consul['texto']);
					set_var('fecha_respuesta',convertir_fecha($consul['fecha_respuesta']));
               	    set_var('respuesta',$consul['respuesta']);
						
		       	    $idp=$consul['id_consulta'];
        
              		parse("bloqueconsulta","bloqueconsulta",true);
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
set_var('vf_tema',$vl_tema);
set_var('catedra',$id_catedra);
set_var("firma",firma_web());
pparse("pagina");
?>