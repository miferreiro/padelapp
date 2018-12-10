
<?php
	session_start();

	include '../Views/DEFAULT_View.php';
	include '../Functions/ActualizarPistas.php';
    include '../Models/NOTICIA_MODEL.php';  
    ActualizarPistas();

	$NOTICIA = new NOTICIA_MODEL( '', '', '');
    $datos = $NOTICIA->SEARCH();
	$USUARIO_DEFAULT = new USUARIO_DEFAULT($datos);
		
?>