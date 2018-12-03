<?php
//include_once'../Models/INSPROM_MODEL.php';
function Comprobar_Inscritos($fecha,$hora){
$INSPROM=new INSPROM_MODEL('','','');
	return $INSPROM->ComprobarInscritos($fecha,$hora);
}

function Comprobar_Inscritos2($fecha,$hora,$actividad){
$INSACT=new INSACT_MODEL('','','','');
	return $INSACT->ComprobarInscritos($fecha,$hora,$actividad);
}
?>