<?php
/*  Archivo php
	Nombre: users_index_View.php
	Autor: 	Miguel Ferreiro
	Fecha de creación: 23/10/2017 
	Función: vista de los elementos que va a contar la sesión del usuario, realizada con una clase
*/

//es la clase del inicio de la página
class Index {

    //es el constructor
	function __construct(){
		
		$this->render();//llamamos a la función para que muestre la vista
	}

    //función que muestra la vista
	function render(){
	
		include '../Locales/Strings_SPANISH.php';//incluimos  el idioma español
		include '../Views/Header.php';//incluimos la cabecera
		include '../Views/Footer.php';//incluimos el footer
	}

}

?>