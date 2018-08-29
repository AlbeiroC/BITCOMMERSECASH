<?php
	include('./functions.php');
	header('Content-type: text/json');
	function retourned($array){
		if (!empty($array)) {
			$paises = array();
			$countries = (!is_array($array)) ? json_decode(getURL('https://restcountries.eu/rest/v2/all'), true) : $array;
			$_SESSION['countries'] = $countries;
			$i = 0;
			foreach ($countries as $index => $pais) {
				$array = array(
					"title"=>$pais['name'],
					"currencie_symbol"=>$pais['currencies'][0]['symbol'],
					"currencie_name"=>$pais['currencies'][0]['name'],
					"currencie_code"=>$pais['currencies'][0]['code'],
					"flag"=>http().$_SERVER['HTTP_HOST'].'/api_v2/countries/'.$pais['alpha3Code'].'.svg',
					"iso2"=>$pais['alpha2Code'],
					"iso3"=>$pais['alpha3Code'],
				);
				$keyterm = (!empty($_GET['title'])) ? trim(strtolower($_GET['title'])) : '';
				$keycode = str_replace(' ', '', strtolower(trim($array['title'])));

				if (!empty($keyterm)&&strstr($keycode, $keyterm)) {
					array_push($paises, $array);
				}
				else if(empty($keyterm)){
					array_push($paises, $array);
				}			
			}
			return json_encode($paises, JSON_PRETTY_PRINT);
		}
	}

	print_r((!empty($_SESSION['countries'])) ? retourned($_SESSION['countries']) : retourned(json_decode(file_get_contents('./country_list.json'), true)));
?>