<?php
/*
	Archivo php
	Nombre: Register_Controller.php
	Autor: Miguel Ferreiro
	Fecha de creación: 23/10/2017 
	Función: controlador que realiza las operaciones necesarias para realizar un registro correcto de un nuevo usuario
*/
session_start();//se inicia la sesión
include_once '../Locales/Strings_'.$_SESSION['idioma'].'.php';//incluimos los strings para poder cambiar de idioma(español,galego,inglés)

if(!isset($_POST['login'])){//Si no se han recibido datos del login
	include '../Views/REGISTRO_View.php';//incluimos la vista para Registrarse
	$register = new Register();//Variable que almacena un objeto de tipo Registro para registrarnos
}
else{
		
	include '../Models/USUARIO_MODEL.php';//incluye el contenido del modelo USUARIO_MODEL
	//Variable que almacena un objecto de usuarios model
	$usuario = new USUARIO_MODEL($_REQUEST['login'],$_REQUEST['password'],$_REQUEST['DNI'],$_REQUEST['nombre'],$_REQUEST['apellidos'],$_REQUEST['email'],$_REQUEST['direc'],$_REQUEST['telefono'],'');//creamos un objeto del modelo USUARIO_MODEL donde le pasamos todos los datos del usuario registrado
	//Variable que almacena la respuesta de si esta existe el login o no para poder registrarse
	$respuesta = $usuario->Register();

	//Si no existe el login en la base de datos
	if ($respuesta == 'true'){
			$respuesta = $usuario->ADD();//Variable que almacena la respuesta de añadir este usuario a la base de datos
		//Incluye la vista mensaje
		include '../Views/MESSAGE_View.php';//incluimos la vista para que nos mandé un mensaje por pantalla
		new MESSAGE($respuesta, '../index.php');//creamos un objeto de tipo mensaje que mostrara el mensaje que viene del modelo.
	}
	//Si existe en la base de datos
	else{
		//Incluye la vista mensaje
		include '../Views/MESSAGE_View.php';//incluimos la vista para que nos mandé un mensaje por pantalla
		new MESSAGE($respuesta, '../index.php');//creamos un objeto de tipo mensaje que mostrara el mensaje que viene del modelo.
	}

}

?>

