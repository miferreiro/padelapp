<?php
/*
	Archivo php
	Nombre: Login_Controller.php
	Autor: Miguel Ferreiro
	Fecha creación: 23/10/2017 
	Función: controlador que realiza las operaciones necesarias para realizar un logeo correcto de un usuario
*/
session_start();//se inicia la sesión
if(!isset($_REQUEST['login']) && !(isset($_REQUEST['password']))){//mira si no existe el login y no existe la password
	//Incluye la vista login
	include '../Views/LOGIN_View.php';
	//Variable que almacena un objecto de login
	$login = new Login();
}
else{//si existe el y la password
	//Incluye la función para conectarse a la base de datos
	include '../Functions/BdAdmin.php';

	//Incluye el acceso al modelo de datos
	include '../Models/USUARIO_MODEL.php';
	$usuario = new USUARIO_MODEL($_REQUEST['login'],$_REQUEST['password'], '', '', '', '', '', '','');//Variable que almacena un objeto del modelo USUARIOS_MODEL
	$respuesta = $usuario->login();//Variable que almacena la respuesta al método login de USARIOS_MODEL para saber si está bien logeado

	//Si existe el usuario se devuelve true y le asignamos a la variable de sesion el valor del login
	if ($respuesta == 'true'){
		session_start();//se inicia la sesión
		$_SESSION['login'] = $_REQUEST['login'];//le asignamos a la variable de sesión del login el login que se introdujo
		header('Location:../Controllers/USUARIO_CONTROLLER.php');//se redirige al controlador de USUARIOS_CONTROLLER.php
	}
	//Si no esta en la base de datos, se muestra la respuesta en la vista mensaje
	else{
		//Incluye la vista de mensaje
		include '../Views/MESSAGE_View.php';
		//Vista de mensaje con la respuesta y ruta de vuelta atras
		new MESSAGE($respuesta, '../Controllers/Login_Controller.php');
	}

}

?>

