<?php

/*	
	Autor:	Miguel Ferreiro
	Fecha de creación: 9/10/2017 
    Este fichero lo que va a hacer es ver si existe una sesión de un usuario ó no. 
*/


//Esta función mira si existe una variable de sessión del login, si existe retorna true, en caso contrario false.
function IsAuthenticated(){

	if (!isset($_SESSION['login'])){//mira si no existe la variable de sesión del login
		return false;//retorna false
	}
	else{//si existe la variable de sesión del login retorna true
		return true;
	}

} //fin de la función IsAuthenticated()
?>