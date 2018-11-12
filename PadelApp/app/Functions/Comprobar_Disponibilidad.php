<?php
//include_once'../Models/PISTA_MODEL.php';
function Comprobar_Disponibilidad($idPista,$hora,$fecha){
$PISTA=new PISTA_MODEL('','','','');
	return $PISTA->ComprobarDisp($idPista,$hora,$fecha);
}
function Comprobar_Disponibilidad2($hora,$fecha){
$PISTA=new PISTA_MODEL('','','','');
	return $PISTA->HORASPROMOCION($hora,$fecha);
}
?>