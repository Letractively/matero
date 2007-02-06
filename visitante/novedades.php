<?php
include("../includes/configuracion.php");

//Truco para hacer globales las variables por get y post con register_globals en off
getpost_ifset();
header("Location:index.php?id_catedra=$id_catedra&ver=novedades2.php");

?>