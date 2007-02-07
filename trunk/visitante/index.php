<? 
include('seguridad_intranet.php');

//Obtengo los datos de la materia
$sql = "select * from catedra where id_catedra=$id_catedra";
//echo $sql;

$consulta=mysql_query($sql);
$lacatedra=mysql_fetch_array($consulta);
//Muestro los datos de la catedra
$nombre=$lacatedra['nombre'];
//Muestro el path de la universidad virtual
$path="<a class='barra' href='http://www.frsf.utn.edu.ar/index.php?id=6'>Inicio</a> &gt; <a class='barra' href='http://www.frsf.utn.edu.ar/index.php?id=62'>Alumnos</a> &gt; <a class='barra' href='http://www.frsf.utn.edu.ar/index.php?id=106'>Alumnos de Grado</a> &gt; <a class='barra'>Sitios Web Cátedras</a>";
?>
<html>
<head>
<title>UTN - FRSF - <? echo $nombre;?></title>
<meta http-equiv="Content-Type" content="text/html; charset=iso-8859-1">
<link rel="stylesheet" href="./imagenes/estilos.css">
</head>

<body bgcolor="#FFFFFF" text="#000000" leftmargin="0" topmargin="0" marginwidth="0" marginheight="0" link="#000000" vlink="#000000" alink="#000000">

<table width="100%" cellpadding="0" cellspacing="0" border="0">
  <tr> 
    <td colspan="2" height="2"> 
	<!-- BEGIN bloqueencabezado -->
      <table width="100%" border="0" cellspacing="0" cellpadding="0">
        <tr> 
          <td width="36%" height="22" bgcolor="#88CC88"><font size="5" face="Verdana, Arial, Helvetica, sans-serif">&nbsp;<font size="2"><strong><? echo $nombre; ?></strong></font></font></td>
          <td width="351" height="22"><img src="./imagenes/encabezado.gif" width="351" height="37"></td>
          <td width="30%" background="./imagenes/fondo_celda_encabezado.gif" height="37">&nbsp;</td>
        </tr>
        <tr> 
          <td colspan="3" height="2"> 
            <table width="100%" border="0" cellspacing="0" cellpadding="0">
              <tr>
                <td width="85%" bgcolor="#BBEEBB">&nbsp;<? echo $path; ?> </td>
                <td width="15%"><img src="./imagenes/final_celda_path.gif" width="20" height="20"></td>
              </tr>
            </table>
          </td>
        </tr>
      </table>
	  <!-- END bloqueencabezado -->
    </td>
  </tr>
  <tr> 
    <td width="15%" background="./imagenes/fondoclaro.gif" height="491" valign="top">
		<? include "include_menu.php"; ?>
    </td>
    <td width="85%" height="491"> 
      <table width="100%" height="100%" cellpadding="0" cellspacing="0" border="0">
        <tr>
          <td width="1" background="./imagenes/linea_lateral.gif">&nbsp;</td>
		  <td width="10">&nbsp;</td>
          <td height="100%" valign="top"> 
            <p class="color_modulo_activo"></p>
            <p><br>
              <? $array_modulos=array(0=>"error.php",1=>"novedades2.php",2=>"apuntes.php",3=>"integrantes.php",4=>"objetivos.php",5=>"horarios.php",6=>"plan.php",7=>"bibliografia.php",8=>"examenes_finales.php",9=>"links.php",10=>"repositorio.php",11=>"examenes_parciales.php",12=>"trabajos_practicos.php",14=>"consultas.php",15=>"ver_notas_tp.php",16=>"ver_notas.php",17=>"ver_notas_parcial.php"); 
			  if (!isset($ver) || !array_key_exists($ver,$array_modulos)) include "novedades2.php"; 
				else include $array_modulos[$ver]; 
				?>
              <br>
              <br></div>
              </p></td>
		  <td width="10">&nbsp;</td>
        </tr>
      </table>
      
    </td>
  </tr>
</table>

<table heigth="10" width="100%" border="0" cellspacing="0" cellpadding="0">
  <tr heigth="10"> 
    <td height="2" width="15%" background="./imagenes/fondoclaro.gif"> 
      <div align="right"><img src="./imagenes/menu_abj.gif" width="26" height="10"></div>
    </td>
    <td height="2" width="48%" background="./imagenes/fondo_celda_inferior_centro.gif"></td>
    <td height="2" width="37%" background="./imagenes/fondo_celda_inferior_derecha.gif"><img src="./imagenes/abj01.gif" width="10" height="10"></td>
  </tr>
</table>
</body>
</html>