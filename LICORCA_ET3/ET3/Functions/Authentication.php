<?php

/*	
	Autor:	Miguel Ferreiro
	Fecha de creaci�n: 9/10/2017 
    Este fichero lo que va a hacer es ver si existe una sesi�n de un usuario � no. 
*/


//Esta funci�n mira si existe una variable de sessi�n del login, si existe retorna true, en caso contrario false.
function IsAuthenticated(){

	if (!isset($_SESSION['login'])){//mira si no existe la variable de sesi�n del login
		return false;//retorna false
	}
	else{//si existe la variable de sesi�n del login retorna true
		return true;
	}

} //fin de la funci�n IsAuthenticated()
?>