<?php
include_once'../Models/PISTA_MODEL.php';
function ActualizarPistas(){
$PISTA=new PISTA_MODEL('','','','');
$respuesta = $PISTA->ACTUALIZAR();

}
?>