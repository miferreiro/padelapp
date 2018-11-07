<?php
//include_once'../Models/PISTA_MODEL.php';
function Comprobar_Inscritos($hora,$fecha){
$INSPROM=new INSPROM_MODEL('','','','');
	return $PISTA->ComprobarDisp($hora,$fecha);
}
?>