<?php

set_file('pagina','error.html');
set_var('mensaje',$mensaje_error);
parse("bloque","bloque",true);
pparse("pagina");
die();

?>