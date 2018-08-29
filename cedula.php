<?php
include('./cm/function.beta.php');
$cedula = (!empty($_GET['cedula'])) ? $_GET['cedula'] : false;
$cedula = (empty($cedula)&&!empty($_POST['cedula'])) ? $_POST['cedula'] : $cedula;
if (!empty($cedula)) {
	print_r(getURL('http://oficinavirtual.saren.gob.ve/permiso_viajes/validarcedula.php','post',"cedula=".$cedula."&letra=V"));
}
else{
	echo "CEDULA_VACIA";
}

?>