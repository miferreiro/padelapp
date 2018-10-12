<?php
/*
	Archivo php
	Nombre: Index_Controller.php
	Autor: 	Miguel Ferreiro
	Fecha de creación: 23/10/2017 
	Función: controlador que comprueba si el usuario está autenticado o no
*/
//session
session_start();
//incluir funcion autenticacion
include '../Functions/Authentication.php';
//si no esta autenticado
if (!IsAuthenticated()){
	header('Location: ../index.php');//redirige a la página de inicio
}
//esta autenticado
else{
	include '../Views/users_index_View.php';//incluimos esa vista
	new Index();// se crea un objeto de tipo Index
}

?>