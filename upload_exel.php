<?php
include('./cm/function.beta.php');
$con = connection();

$file = './banks.php';
if (is_file($file)) {
	$fn = fopen($file, "r");
	$i = 0;
	while ($linea=fgets($fn)) {

			preg_match_all("<option value\=".'\"(\d+)\"'."></option>",
			    "<option value=".'"0134"'.">BANESCO BANCO UNIVERSAL S.A</option>",
			    $out, PREG_PATTERN_ORDER);
			echo $out[0][0] .  "\n";

		// echo "<pre>";
		// echo $linea;
		// var_dump($linea);
		// echo "</pre>";
		echo "<hr>";
		$i++;
	}
	fclose($fn);
}





?>