<?php
/*
	Archivo php
	Nombre: CambioIdioma.php
	Autor: 	Miguel Ferreiro Díaz
	Fecha de creación: 23/10/2017 
	Función: controla el cambio de idioma
*/
	session_start();
	$idioma = $_POST['idioma'];//Recogemos el idioma establecido
	$_SESSION['idioma'] = $idioma;//Incluimos a una variable idioma, que es de sesion, el idioma selecionado
	header('Location:' . $_SERVER["HTTP_REFERER"]);
?>