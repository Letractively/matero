<?PHP

include("seguridad_intranet.php");

set_file('pagina','sindicarse.html');

$sql = "SELECT * FROM catedra WHERE id_catedra = $_GET[id_catedra]";
$rs = mysql_query($sql);

$catedra = mysql_fetch_array($rs);

$nombre_catedra = $catedra[nombre];

set_var("id_catedra",$_GET[id_catedra]);
set_var("nombre_catedra",$nombre_catedra);

parse("bloque","bloque",true);

pparse('pagina');

?>
