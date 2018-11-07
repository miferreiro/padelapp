<?php
//include_once'../Models/INSPROM_MODEL.php';
function Comprobar_Inscritos($fecha,$hora){
$INSPROM=new INSPROM_MODEL('','','');
	return $INSPROM->ComprobarInscritos($fecha,$hora);
}
?>