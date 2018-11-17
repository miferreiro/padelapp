<?php

function IsAuthenticated(){

	if (!isset($_SESSION['login']) && !isset($_SESSION['tipo'])){
		return false;
	}
	else{
		return true;
	}

} 
?>