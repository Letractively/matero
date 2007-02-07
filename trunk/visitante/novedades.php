<?php
include("../includes/configuracion.php");

$id_catedra = $_REQUEST['id_catedra'];
header("Location:index.php?id_catedra=$id_catedra&ver=novedades2.php");

?>