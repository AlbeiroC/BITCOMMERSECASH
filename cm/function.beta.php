<?php
session_start();

function host($need='host'){
	switch (strtolower(trim($need))) {
		// Obtenemos el nombre del dominio
		case 'host':
		case 'server':
			return strtolower(trim($_SERVER['HTTP_HOST']));
			break;
		// Conocemos si es local o remoto
		case 'type':
			return (strstr(host(), '.com')) ? 'remote' : 'local';
			break;
		case 'is_remote':
			return strstr('.com', host()) ? true : false;
			break;
		// Obtenemos la url con el protocolo incluido
		case 'url':
			return host('http').strtolower(trim($_SERVER['HTTP_HOST'])).'/';
			break;
		// Obtenemos la ruta directa al directorio principal del sitio web
		case 'root':
			$script_dir = $_SERVER['SCRIPT_FILENAME'];
			$explode = (host('type')=='local') ? 'htdocs' : 'public_html';
			$arr = explode($explode, $script_dir);
			unset($arr[0]);
			$arr = explode('/', implode($explode, $arr));
			$path = '';
			$i = 1;
			foreach ($arr as $key => $value) {
				if ($i<count($arr)) {
					$path .= (empty($path)) ? './' : '../';
				}
				$i++;
			}
			return $path;
			break;
		case 'http':
		case 'https':
			return (!empty($_SERVER['HTTPS'])) ? 'https://' : 'http://';
		break;
		case 'is_https':
		case 'is_secure':
			return (!empty($_SERVER['HTTPS'])) ? true : false;
		break;
		default:
			return strtolower(trim($_SERVER['HTTP_HOST']));
			break;
	}
}

// Relizar una nueva conexion con el servidor
function connection($arg=array()){
	$con = false;
	$data_db = (count($arg)>0) ? $arg : array(
		"local"=>array(
			"host"=>"localhost",
			"user"=>"root",
			"password"=>"",
			"database"=>"bitcomme_principal"
		),
		"remote"=>array(
			"host"=>"localhost",
			"user"=>"bitcomme",
			"password"=>"arcaelas123",
			"database"=>"bitcomme_principal"
		),
	);
	$arg = (count($arg)>0) ? $arg : $data_db[host('type')];
	$con = mysqli_connect($arg['host'],$arg['user'],$arg['password'],$arg['database']);
	return $con;
}

// Verificamos si una variable es Json o Array o String
function isJson($string) {
	if (json_decode($string)) {
		return (json_last_error() == JSON_ERROR_NONE);
	}
	return false;
}

// Limpiar de caracteres raros
function eraseStr($string) {
	$string = trim($string); 
	$string = str_replace( array('á', 'à', 'ä', 'â', 'ª', 'Á', 'À', 'Â', 'Ä'), array('a', 'a', 'a', 'a', 'a', 'A', 'A', 'A', 'A'), $string ); 
	$string = str_replace( array('é', 'è', 'ë', 'ê', 'É', 'È', 'Ê', 'Ë'), array('e', 'e', 'e', 'e', 'E', 'E', 'E', 'E'), $string ); 
	$string = str_replace( array('í', 'ì', 'ï', 'î', 'Í', 'Ì', 'Ï', 'Î'), array('i', 'i', 'i', 'i', 'I', 'I', 'I', 'I'), $string ); 
	$string = str_replace( array('ó', 'ò', 'ö', 'ô', 'Ó', 'Ò', 'Ö', 'Ô'), array('o', 'o', 'o', 'o', 'O', 'O', 'O', 'O'), $string ); 
	$string = str_replace( array('ú', 'ù', 'ü', 'û', 'Ú', 'Ù', 'Û', 'Ü'), array('u', 'u', 'u', 'u', 'U', 'U', 'U', 'U'), $string ); 
	$string = str_replace( array('ñ', 'Ñ', 'ç', 'Ç'), array('n', 'N', 'c', 'C',), $string );
	$string = str_replace( array("'"), '', $string );
    return $string;
}

function countSQL($table=false,$field=false,$query=false){
	$exist = false;
	if (!empty($table)&&!empty($field)&&!empty($query)) {
		if ($con=connection()) {
			$sql = "SELECT ".$field." FROM ".$table." WHERE ".$field." = '".$query."' LIMIT 2";
			if ($res=$con->query($sql)) {
				if ($res->num_rows>0) {
					$exist = $res->num_rows;
				}
			}
			$con->close();
		}
	}
	return $exist;
}


function security($code=false){
	if (!is_bool($code)) {
		switch ($code) {
			case is_array($code):
				$str_validate = (!empty($code['str_validate'])) ? $code['str_validate'] : false;
				$nw = (!empty($code['nw'])) ? $code['nw'] : false;
				$f_t = (!empty($code['f_t'])) ? $code['f_t'] : false;
				$bs4 = (!empty($code['bs4'])) ? $code['bs4'] : false;
				$md5 = (!empty($code['md5'])) ? $code['md5'] : false;
				if (empty($str_validate)||empty($nw)||empty($f_t)||empty($bs4)||empty($md5)) {
					return false;
				}
				else{
					return (($str_validate>$nw)&& (is_int(intval(base64_decode($bs4)))&&(($str_validate/2)==base64_decode($bs4)))&& (md5($nw)==$md5)&& (base64_encode($f_t)==$bs4));
				}
			break;
			case is_string($code):
				$code = explode('_', $code);
				$str_validate = (!empty($code[0])) ? $code[0] : false;
				$nw = (!empty($code[1])) ? $code[1] : false;
				$f_t = (!empty($code[2])) ? $code[2] : false;
				$bs4 = (!empty($code[3])) ? $code[3] : false;
				$md5 = (!empty($code[4])) ? $code[4] : false;
				if (empty($str_validate)||empty($nw)||empty($f_t)||empty($bs4)||empty($md5)) {
					return false;
				}
				else{
					return (($str_validate>$nw)&& (is_int(intval(base64_decode($bs4)))&&(($str_validate/2)==base64_decode($bs4)))&& (md5($nw)==$md5)&& (base64_encode($f_t)==$bs4));
				}
			break;
		}
		return false;
	}
	$life_time = 15;
	$security = (!empty($_SESSION['security_channel'])) ? $_SESSION['security_channel'] : false;
	$security = (!empty($security)&&!empty($security['nw'])&&((strtotime("now")-$security['nw'])<$life_time)) ? $security : false;
	$n = function(){
		$n = rand(strtotime("now"),strtotime("+10 year"));
		$n = (is_float(($n/2))) ? $n+1 : $n;
		return $n;
	};
	$n = $n();
	$now = strtotime("now");
	$_SESSION['security_channel'] = $security = (!empty($security)) ? $security : array(
		"str_validate" => $n,
		"nw"=>$now,
		"f_t"=>($n/2),
		"bs4"=>base64_encode($n/2),
		"md5"=>md5($now),
	);
	return (!empty($code)&&is_bool($code)) ? implode('_', $security) : $security;
}



function getTasa(){
	$tasa = array(
		"id"=>1,
		"tasa_popular"=>0.0026,
		"tasa_vip"=>0.0025,
		"fecha"=>strtotime("now"),
	);
	$con = connection();
	$sql = "SELECT * FROM tasa_bitsend ORDER BY id DESC LIMIT 1";
	if ($res=$con->query($sql)) {
		$tasa = ($res->num_rows>0) ? $res->fetch_array(MYSQLI_ASSOC) : $tasa;
		$tasa['tasa_popular'] = (strlen($tasa['tasa_popular'])<3) ? ($tasa['tasa_popular']/10000) : $tasa['tasa_popular'];
		$tasa['tasa_vip'] = (strlen($tasa['tasa_vip'])<3) ? ($tasa['tasa_vip']/10000) : $tasa['tasa_vip'];
		$tasa['fecha'] = strtotime($tasa['fecha']);
	}
	$con->close();
	return $tasa;
}



function dateFormat($fecha=false,$format='default',$lang='es'){
	$fecha = empty($fecha) ? strtotime("now") : $fecha;
	$str_time = $fecha = (empty(is_numeric($fecha))) ? strtotime($fecha) : $fecha;
	$dias_espanol = array('lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo', 'lun', 'mar', 'mie', 'jue', 'vie', 'sab', 'dom');
	$dias_ingles = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun');
	$meses_ingles = array("january", "february", "march", "april", "may", "june", "july", "august", "september", "october", "november", "december", "jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec");
	$meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre', 'ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
	$now = strtotime("now");
	$time = ($now-$fecha);
	$segundos = ($time>=0) ? $time : ($time*(0-1));
	$minutos = ($time>=0) ? intval($time/60) : intval(($time*(0-1))/60);
	$horas = ($time>=0) ? intval($time/3600) : intval(($time*(0-1))/3600);
	$dias = intval($horas/24);
	$semanas = intval($dias/7);
	$t = $segundos;
	$t = ($t>59) ? $minutos : $t;
	$t = ($t>=60) ? $horas : $t;
	$t = ($t>=24) ? $dias : $t;
	$t = ($t>=168) ? $semanas : $t;
	$real_time = "segundos";
	$real_time = ($segundos>59&&$minutos<60) ? 'minutos' : $real_time;
	$real_time = ($minutos>59&&$horas<24) ? 'horas' : $real_time;
	$real_time = ($horas>23&&$dias<7) ? 'dias' : $real_time;
	$real_time = ($dias>7&&$semanas>0) ? 'semanas' : $real_time;
	$real_time = $t." ".$real_time;
	$real_time = ($semanas>=2) ? ucwords(str_replace($dias_ingles, $dias_espanol, str_replace($meses_ingles, $meses_espanol, strtolower(gmdate("E\l D d F \a \l\a\s h:i a", $str_time))))) : $real_time;
	switch ($time) {
		case ($time==0):
			return "Hace un momento";
			break;
		case ($time>0):
			return ($semanas>=2) ? $real_time : "Hace ".$real_time;
			break;
		case ($time<0):
			return ($semanas>=2) ? $real_time : "Dentro de ".$real_time;
			break;
		default:
			return "0000-00-00 00:00:00";
			break;
	}
}



function notification($arg=array()){
	$defaults = array(
		"id"=>"NULL",
		"user"=>false,
		"icon"=>'',
		"title"=>"Nueva alerta",
		"texto"=>"Tienes una notificacion guardada en tu historial.",
		"code"=>"default",
		"encode"=>true,
	);
	$params = array_merge($defaults,$arg);
	
	$u_ = 1907;

	$params['user'] = (empty($params['user'])) ? $u_ : $params['user'];
	if (!empty($params['user'])) {
		$con = connection();
		$field = $values = '';
		foreach ($params as $key => $value) {
			if (trim(strtolower($key))!='encode'&&trim(strtolower($key))!='status') {
				$field .= empty($field) ? $key : ','.$key;
				$values .= empty($values) ? '"'.$value.'"' : ',"'.$value.'"';
			}
		}
		$sql = 'INSERT INTO history ('.$field.') VALUES ('.$values.')';
		if ($con->query($sql)) {
			$s = 'success';
			$params['id'] = $con->insert_id;
		}
		else{
			$s = 'error';
		}
	}
	$params = array(
		"status"=>$s,
		"data"=>$params,
	);
	return (!empty($params['encode'])) ? json_encode($params, JSON_PRETTY_PRINT) : $params;
}


function error_success($type='success',$response=false){
	$default = array(
		"type"=>"success",
		"response"=>false,
		"url"=>false,
		"encode"=>false
	);
	$arg = (is_array($type)) ? array_merge($default,$type) : $default;
	$arg['response'] = ($arg['type']=='success'&&empty($arg['response'])) ? 'Proceso exitoso' : $arg['response'];
	$arg['response'] = ($arg['type']=='error'&&empty($arg['response'])) ? 'Oops! Tuvimos un problema.' : $arg['response'];
	return (!empty($arg['encode'])) ? json_encode($arg, JSON_PRETTY_PRINT) : $arg;
}

function user_tables(){
	return array(
		'about',
		'email',
		"facebook",
		'imagen',
		"instagram",
		'nombre',
		'password',
		"paypal",
		"twitter",
		'username',
		"wallet",
	);
}


//Convertir cadena de separadores en array recursivos
// Ejemplo imagen.cantidad.34,imagen.tamano.300K
function toArray($str=false,$s1=',',$s2='.'){
	$array = [] ;
	$items = explode($s1,$str);
	foreach ($items as $item) {
	    $parts = explode($s2, $item);
	    $last = array_pop($parts);
	    $ref = &$array ;
	    foreach ($parts as $part) {
	        if (!isset($ref[$part])) $ref[$part]=[];
	        $ref = &$ref[$part];
	    }
	    $ref = $last;
	}
	return $array;
}
//Fin de convertir cadena de separadores en array recursivos


//$url indica la direccion que estamos llamando.
function getURL($url,$type="get",$params=""){
	if (!empty($url)) {
		$handler = curl_init();
		curl_setopt($handler, CURLOPT_URL, $url);
		curl_setopt($handler, CURLOPT_POST,true);
		switch (trim(strtolower($type))) {
			case 'post':
				curl_setopt($handler, CURLOPT_POSTFIELDS, $params);
			break;
		}
		curl_setopt($handler, CURLOPT_RETURNTRANSFER, 1);
		curl_setopt($handler, CURLOPT_FAILONERROR, true);
		curl_setopt($handler, CURLOPT_SSL_VERIFYHOST, false);
		curl_setopt($handler, CURLOPT_SSL_VERIFYPEER, false);
		curl_setopt($handler, CURLOPT_FOLLOWLOCATION, true);		
		curl_setopt($handler, CURLOPT_TIMEOUT, 10);
		$data = curl_exec($handler);
		if ($data===false) {
		  	$data = curl_error($handler);
		}
		curl_close($handler);
		return $data;
	}
	return false;
}


function BitcoinPrice($encode=false,$unset=false,$wallet=false,$api=false){
	$api_key = (!empty($api)) ? $api : 'bf8c-df53-1945-4b24';
	$is_multi = (!empty($wallet)&&(strstr($wallet, ',')||is_array($wallet))) ? true : false;
	$wallet = (!empty($wallet)&&is_array($wallet)) ? implode(',', $wallet) : $wallet;
	$to_price = empty($wallet);
	$url = (!empty($wallet)) ? 'https://block.io/api/v2/get_address_balance/?api_key='.$api_key.'&addresses='.$wallet : 'https://chain.so/api/v2/get_info/BTC';
	$wallet_array = (!empty($wallet)) ? explode(',', $wallet) : false;
	if (!empty($wallet_array)) {
		$non_balance = array();
		$address_done = array();
		$test = array();
		foreach ($wallet_array as $key) {
			if (!empty($_SESSION['wallets'][$key])) {
				$address_done[$key] = $_SESSION['wallets'][$key];
				$test[$key] = $address_done[$key];
				$life_time = 3600;
				$life_time = ($life_time-(strtotime("now")-($address_done[$key]['timestamp'])));
				if ($life_time<=0) {$non_balance[] =  $key; }
			}
			else{
				$non_balance[] =  $key;
			}
		}
		$url = (!empty($non_balance)) ? 'https://block.io/api/v2/get_address_balance/?api_key='.$api_key.'&addresses='.implode(',', $non_balance) : false;
		$json = (!empty($url)) ? getURL($url) : array();
		$json = (is_array($json)) ? $json : json_decode($json, true);
		if (!empty($json['status'])&&$json['status']=='success') {
			$data = $json['data']['balances'];
			foreach ($data as $key => $address) {
				$w = $address['address'];
				$_SESSION['wallets'][$w] = $test[$w] = array(
					"avaible" => $address['available_balance'],
					"pending" => $address['pending_received_balance'],
					"timestamp" => strtotime("now"),
				);
			}
		}
		$test['balance'] = $test['pending'] = 0;
		foreach ($test as $key => $value) {
			$test['balance'] = floatval(($value['avaible']+$test['balance']));
			$test['pending'] = floatval(($value['pending']+$test['pending']));
		}
		return $test;
	}
	else{
		$name_ck = 'api_v2_btc';
		$url = 'http://blockexplorer.com/api/currency';
		$now = strtotime("now");
		$seconds = 30;
		$params = (!empty($_SESSION[$name_ck])&&empty($unset)) ? $_SESSION[$name_ck] : getURL($url);
		$_SESSION[$name_ck] = (is_array($params)) ? $params : json_decode($params, true);
		$_SESSION[$name_ck]['data'] = array(
			"price"=>(!empty($_SESSION[$name_ck]['data']['bitstamp'])) ? floatval($_SESSION[$name_ck]['data']['bitstamp']) : $_SESSION[$name_ck]['data']['price'],
		);
		$_SESSION[$name_ck]['timestamp'] = (!empty($_SESSION[$name_ck]['timestamp'])) ? $_SESSION[$name_ck]['timestamp'] : $now;
		$_SESSION[$name_ck]['life_time'] = ($seconds-($now-$_SESSION[$name_ck]['timestamp']));
		$params = $_SESSION[$name_ck];
		$params = ($params['life_time']<=0) ? BitcoinPrice($encode,true) : $params;		
	}
	return (!empty($encode)&&empty($unset)) ? json_encode($params, JSON_PRETTY_PRINT) : $params;
}



function utf8ize($d) {
    if (is_array($d)) {
        foreach ($d as $k => $v) {
            $d[$k] = utf8ize($v);
        }
    } else if (is_string ($d)) {
        return utf8_encode($d);
    }
    return $d;
}



function is_session($user=false,$encode=false){
	$con = connection();
	$tablas = user_tables();
	if (!empty($_COOKIE['user_login'])) {$token = $_COOKIE['user_login'];}
	else if (!empty($_SESSION['user_login'])) {$token = $_SESSION['user_login'];}
	else if(empty($user)&&empty($token)){return false;}
	$user = (empty($user)&&!empty($token)) ? $token : $user;
	$token = (!is_numeric($user)) ? $user : false;
	$user_token = $user = is_numeric($user) ? $user : false;
	$code = (!empty($user)) ? $user : $token;
	$now = strtotime("now");
	$seconds = 60;
	if (!empty($_SESSION['profiles'][$code])) {
		$timestamp = $_SESSION['profiles'][$code]['timestamp'];
		$life_time = ($seconds-($now-$timestamp));
		if ($life_time>0) {
			return !empty($encode) ? json_encode($_SESSION['profiles'][$code], JSON_PRETTY_PRINT) : $_SESSION['profiles'][$code];
		}
	}
	$selector = (!empty($user)) ? $user : "(SELECT user FROM tokens WHERE token = '".$token."' AND type = 'sesion' LIMIT 1)";
	$sql = "SELECT
	users.id           as user_id, 
	users.referido     as user_referido, 
	users.status       as user_status, 
	users.cedula       as user_cedula, 
	users.vip          as user_vip, 
	users.comision     as user_comision, 
	users.grants       as user_grants, 
	lower(users.admin) as user_admin, 
	users.webmail      as user_webmail, 
	users.plan         as user_plan, 
	users.username     as user_username, 
	users.password     as user_password, 
	users.btc_price    as btc_price, 
	ifnull((select		facebook 			from     empresa_facebook where    user = ".$selector." and      status = 'active' order by fecha desc limit 1), users.facebook) as user_facebook,
	ifnull((select		nombre 				from     empresa_nombre where    user = ".$selector." and      status = 'active' order by fecha desc limit 1), users.nombre) as user_nombre,
	ifnull((select		email 				from     empresa_email where    user = ".$selector." and      status = 'active' order by fecha desc limit 1), users.email) as user_email,
	ifnull((select		about 				from     empresa_about where    user = ".$selector." and      status = 'active' order by fecha desc limit 1), users.about) as user_about,
	ifnull((select		imagen 				from     empresa_imagen where    user = ".$selector." and      status = 'active' order by fecha desc limit 1), users.imagen) as user_imagen,
	ifnull((select		paypal 				from     empresa_paypal where    user = ".$selector." and      status = 'active' order by fecha desc limit 1), users.paypal) as user_paypal,
	ifnull((SELECT 		count(id) 			from   items_to_sell where  user = ".$selector." and    trash != 'true'), 0) as user_publicaciones,
	ifnull((SELECT 		count(favoritos.id) from   favoritos, items_to_sell where  favoritos.user = 1013646805 and    favoritos.item = items_to_sell.id and    items_to_sell.trash != 'true'), 0) as user_favoritos,
	ifnull((SELECT 		count(imbox.id) as user_imbox from   imbox where  para = ".$selector." and    status = 0 limit 101), 0) as user_imbox,
	lower(paises.pais)                                   as pais_nombre, 
	lower(paises.iso2)                                   as pais_code, 
	lower(paises.moneda)                                 as pais_moneda, 
	lower(paises.simbolo_moneda)                         as pais_simbolo, 
	lower(paises.bandera)                                as pais_bandera
    from
    users, paises
	where    users.id = ".$selector." 
    and      paises.iso3 = users.pais limit 1
";
	if ($res=$con->query($sql)) {
		if ($res->num_rows>0) {
			$data = $res->fetch_array(MYSQLI_ASSOC);
			$user = array();
			foreach ($data as $key => $value) {
				$s = explode('_', $key);
				$a = $s[0];
				$b = (!empty($s[1])) ? $s[1] : false;
				$user[$a] = (empty($user[$a])) ? array() : $user[$a];
				if (!empty($b)) {
					$user[$a][$b] = $value;
				}
				else{
					$user[$a] = $value;
				}
			}
			$user['user']['grants'] = toArray($data['user_grants']);
			// Reunimos todas las carteras del usuario y sumamos su saldo disponible
			$user['user']['balance'] = array(
				"status"=>"error",
				"timestamp"=>strtotime("now"),
				"data"=>array(
					"balance"=>0,
					"pending"=>0,
					"address"=>array(),
				),
			);
			$sql_wallets = "SELECT * FROM wallets WHERE TRIM(LOWER(user)) = TRIM(LOWER('".$user['user']['id']."'))";
			if ($res_wallets=$con->query($sql_wallets)) {
				$user['user']['balance']['status'] = 'success';
				while ($address=$res_wallets->fetch_array(MYSQLI_ASSOC)) {$user['user']['balance']['data']['address'][] = $address['direccion']; }
				$user['user']['balance']['data'] = BitcoinPrice(false,false,implode(',', $user['user']['balance']['data']['address']));
			}
			// Fin de Reunimos todas las carteras del usuario y sumamos su saldo disponible

			$user['btc'] = BitcoinPrice();
			$response = array(
				"status"=>"success",
				"timestamp"=>strtotime("now"),
				"data"=>$user,
			);
			$response['data']['user']['token'] = (!empty($token)) ? $token : $user_token;
			$_SESSION['profiles'] = (!empty($_SESSION['profiles'])) ? $_SESSION['profiles'] : array();
			$_SESSION['profiles'][$code] = $response;
			$con->close();
			return !empty($encode) ? json_encode($response, JSON_PRETTY_PRINT) : $response;
		}
	}
	return false;	
}


function userInfo($user=false,$encode=false){
	$is_token = (empty(is_numeric($user)));
	$user = is_session($user,$encode);
	$user = (is_array($user)) ? $user : json_decode($user, true);
	if (!$is_token) {
		unset($user['data']['user']['admin']);
		unset($user['data']['user']['webmail']);
		unset($user['data']['user']['balance']);
	}
	unset($user['data']['user']['password']);
	$me = is_session();
	$user['btc'] = (empty($user['btc'])) ? BitcoinPrice() : $user['btc'];
	$user['is_my'] = (!empty($me['data']['user']['id'])&&!empty($user['data']['user']['id'])&&($user['data']['user']['id']==$me['data']['user']['id'])) ? true : false;
	return (!empty($encode)) ? json_encode($user, JSON_PRETTY_PRINT) : $user;
}




function itemInfo($id=false,$encode=false){
	if (!empty($id)) {
		$con = connection();
		$me = is_session();
		$sql = "
			SELECT
			items_to_sell.id AS item_id,
			items_to_sell.key_ AS item_key,
			items_to_sell.user AS item_userid,
			items_to_sell.nombre AS item_nombre,
			items_to_sell.descripcion AS item_descripcion,
			items_to_sell.categoria AS item_categoria,
			items_to_sell.stock AS item_stock,
			items_to_sell.currency AS item_moneda,
			items_to_sell.precio_usd AS item_precioUSD,
			items_to_sell.precio_btc AS item_precioBTC,
			items_to_sell.destination AS item_shipping,
			items_to_sell.payment AS item_payments,
			items_to_sell.imagenes AS item_imagenes,
			items_to_sell.fecha AS item_uploaded
			FROM
			items_to_sell
			WHERE
			id IN (".$id.")  AND trash != 'true'";
			if ($res=$con->query($sql)) {
				if ($res->num_rows>0) {
					$list = array();
					while ($data = $res->fetch_array(MYSQLI_ASSOC)) {
						$item = array();
						foreach ($data as $key => $value) {
							$s = explode('_', $key);
							$a = $s[0];
							$b = (!empty($s[1])) ? $s[1] : false;
							$item[$a] = (empty($item[$a])) ? array() : $item[$a];
							if (!empty($b)) {
								$item[$a][$b] = $value;
							}
							else{
								$item[$a] = $value;
							}
						}
						$item['item']['ads'] = host('url').'view.php?id='.$item['item']['id'];
						$item['item']['imagenes'] = explode('[EXPLODE_IMAGES]', $item['item']['imagenes']);
						$item['user'] = userInfo($item['item']['userid'], false);
						$item['item']['is_my'] = (!empty($me['data']['user']['id'])&&$me['data']['user']['id']==$item['user']['data']['user']['id']) ? true : false;						
						$item['item']['is_fav'] = (!empty(itemFav($item['item']['id'],true,true)));
						$item['item']['precioBTC'] = (is_string($item['item']['precioBTC'])||is_bool($item['item']['precioBTC'])) ? false : $item['item']['precioBTC'];
						$btc_price = ($item['user']['data']['btc']['data']['price']>=1) ? $item['user']['data']['btc']['data']['price'] : false;
						if (!empty($btc_price)) {
							$item['item']['precioBTC'] = (!$item['item']['precioBTC']) ? floatval(number_format((($item['item']['precioUSD']*1)/($btc_price*1)),8)) : $item['item']['precioBTC'];
						}
						else{
							$item['item']['precioBTC'] = 0;
						}
						$list[] = $item;
					}
				}
				else{
					$list = array();
				}
				$list = (count($list)>=1) ? $list : false;
				$list = (!empty($list)&&count($list)==1) ? $list[0] : $list;
				$con->close();
				return (!empty($encode)) ? json_encode($list, JSON_PRETTY_PRINT) : $list;
			}
	}
	return false;
}


function getItems($array= array()){
	$params = array_merge(array(
		"query"=>false,
		"min_price"=>0,
		"max_price"=>"99999999999999999999999",
		"min_stock"=>0,
		"max_stock"=>"99999999999999999999999",
		"destino"=>"national",
		"pais"=>false,
		"limit"=>12,
		"list"=>"0",
	),$array);
	$me = is_session();
	$query = (!empty($params['query'])&&strtolower(trim($params['query']))!='rand') ? $params['query'] : 'id';
	$find = $query = strtolower(trim($query));
	$query = ($query!='my_items'&&$query!='favoritos'&&(!empty($find)&&$find!='id')) ? " (TRIM(LOWER(items_to_sell.nombre)) LIKE ('%".$query."%') OR TRIM(LOWER(items_to_sell.descripcion)) LIKE ('%".$query."%')) " : $query;
	$query = ($query=='my_items'&&!empty($me['data']['user']['id'])) ? " user = '".$me['data']['user']['id']."' " : $query;
	$query = ($query=='favoritos'&&!empty($me['data']['user']['id'])) ? " items_to_sell.id IN (SELECT item FROM favoritos WHERE user = '".$me['data']['user']['id']."') " : $query;
	$query = (empty($me['data']['user']['id'])&&($query=='my_items'||$query=='favoritos')) ? 'id' : $query;
	$query = strtolower(trim($query));
	$min_price = (is_numeric($params['min_price'])) ? $params['min_price'] : 0;
	$max_price = (is_numeric($params['max_price'])) ? $params['max_price'] : "999999999999999999999999";
	$price_range = " AND (items_to_sell.precio_usd >= ".$min_price." AND items_to_sell.precio_usd <= ".$max_price.") ";
	$min_stock = (is_numeric($params['min_stock'])) ? $params['min_stock'] : 0;
	$max_stock = (is_numeric($params['max_stock'])) ? $params['max_stock'] : "999999999999999999999999";
	$stock_range = " AND (items_to_sell.stock >= ".$min_price." AND items_to_sell.stock <= ".$max_price.") ";
	$pais = (!empty($params['pais'])) ? $params['pais'] : false;
	$pais = (!empty($params['pais'])) ? " AND TRIM(LOWER(users.pais)) = TRIM(LOWER('".$pais."')) " : false;
	$order = (!empty($find)&&$find!='id') ? " ORDER BY 
    CASE
        WHEN TRIM(LOWER(items_to_sell.nombre)) LIKE '".strtolower(trim(substr($find, 0, 1)))."%' THEN 1
        ELSE 0
    END
    DESC,
    CASE
        WHEN TRIM(LOWER(items_to_sell.descripcion)) LIKE '".strtolower(trim(substr($find, 0, 1)))."%' THEN 1
        ELSE 0
    END
    DESC" : " ORDER BY RAND() ";

    $params['list'] = (!empty($params['list'])) ? $params['list'] : "0";
    $list = (is_array($params['list'])) ? $params['list'] : explode(',', $params['list']);
    $l = '';
    foreach ($list as $key) {
    	if (!empty($key)) {
	    	$l .= (empty($l)) ? "'".$key."'" : ",'".$key."'";
    	}
    }
    $list = $l;
    $list = (!empty($params['list'])) ? " AND items_to_sell.id NOT IN (".$params['list'].") " : false;

	$sql = "SELECT items_to_sell.id".((!empty($params['pais'])) ? ",users.pais" : false)." FROM items_to_sell".((!empty($params['pais'])) ? ",users" : false)." WHERE ".$query." ".$list." ".$price_range." ".$stock_range." ".$pais." ".$order." LIMIT ".$params['limit'];
	$sql = preg_replace('/\s+/', ' ', $sql);
	$sql = str_replace('where id ', 'where items_to_sell.id ', strtolower(trim($sql)));
	$list = array(
		"status"=>"success",
		"timestamp"=>strtotime("now"),
		"data"=>array(),
	);
	$con = connection();
	if ($res=$con->query($sql)) {
		$d = '';
		while ($id=$res->fetch_array(MYSQLI_ASSOC)) {
			$d .= (empty($d)) ? $id['id'] : ','.$id['id'];
		}
		$list['data'] = itemInfo($d);
	}
	else{
		$list['status'] = 'error';
	}
	$con->close();
	return (!empty($params['encode'])) ? json_encode($list, JSON_PRETTY_PRINT) : $list;
}



function deleteItem($id,$pass=false,$token=false){
	$response = array(
		"status"=>"error",
		"timestamp"=>strtotime("now"),
		"code"=>400,
		"data"=>array(),
	);
	$me = is_session();
	if (!empty($id)&&!empty($pass)&&!empty($me['data']['user']['id'])) {
		$item = itemInfo($id);
		$response['data'] = $item;
		if (!empty($item['item'])) {
			if ($item['item']['userid']==$me['data']['user']['id']) {
				if (strtolower(trim($me['data']['user']['password']))===strtolower(trim($pass))) {
					$sql = "SELECT id FROM orden_de_compras WHERE id_producto = '".$item['item']['id']."' AND status = 'pending' LIMIT 1";
					$con = connection();
					if ($res=$con->query($sql)) {
						if ($res->num_rows<1) {
							$sql = "UPDATE items_to_sell SET trash = 'true' WHERE user = '".$me['data']['user']['id']."' AND id = '".$item['item']['id']."'";
							if ($res=$con->query($sql)) {
								$response['code'] = 1;
								$response['status'] = "success";
								$response['data'] = $item;
							}
							else{
								$response['code'] = 500;
							}
						}
						else{
							$response['code'] = 401;
						}
					}
					else{
						$response['code'] = 500;
					}
					$con->close();
				}
				else{
					$response['status'] = "success";
					$response['response'] = "token";
					$response['code'] = 400;
				}
			}
			else{
				$response['status'] = "error";
				$response['response'] = false;
				$response['code'] = 400;
			}
		}
		else{
			$response['code'] = 404;
		}
	}
	return json_encode($response, JSON_PRETTY_PRINT);
}





function comentarios($arg=array()){
	$params = array_merge(array(
		"id"=>false,
		"min_id"=>0,
		"max_id"=>"9999999999999999999999999999",
		"limit"=>12,
		"encode"=>false,
	),$arg);
	$response = array(
		"status"=>"success",
		"timestamp"=>strtotime("now"),
		"data"=>array(),
	);
	$me = is_session();
	$query = (empty($params['id'])||is_bool($params['id'])) ? false : $params['id'];
	$query = (is_numeric($query)) ? $query : false;
	$query = (empty($query)&&empty($me['data']['user']['id'])) ? false : $query;
	if (!empty($query)) {
		$item = itemInfo($query);
		if (!empty($item['item'])) {
			$min_id = (!empty($params['min_id'])&&is_numeric($params['min_id'])) ? $params['min_id'] : 0;
			$max_id = (!empty($params['max_id'])&&is_numeric($params['max_id'])) ? $params['max_id'] : "999999999999999999999999999";
			$id_range = " AND (id >= ".$min_id." AND id <= ".$max_id.") ";
			$limit = (!empty($params['limit'])&&is_numeric($params['limit'])) ? $params['limit'] : 12;
			$order = (!empty($params['order'])) ? strtolower(trim($params['order'])) : 'ASC';
			$order = ($order=='desc') ? "DESC" : "ASC";
			$sql = "SELECT * FROM comentarios WHERE post = ".$query." ".$id_range." ORDER BY id ".$order." LIMIT ".$limit;
			$sql = preg_replace('/\s+/', ' ', $sql);
			$con = connection();
			if ($res=$con->query($sql)) {
				$response['status'] = "success";
				while ($comentario=$res->fetch_array(MYSQLI_ASSOC)) {
					$data = $comentario;
					$data['id'] = intval($data['id']);
					$data['texto'] = html_entity_decode($data['comentario']);
					$data['fecha'] = (!empty($data['visto'])) ? strtotime($data['visto']) : strtotime($data['fecha']);
					$data['visto'] = (!empty($data['visto'])) ? false : false;
					unset($data['comentario']);
					unset($data['visto']);
					$data['user'] = userInfo($data['user']);
					$response['data'][] = $data;
				}
			}
			else{
				$response['status'] = "error";
				$response['code'] = 500;
			}
			$con->close();
		}
		else{
			$response['status'] = "error";
		}
	}
	else if(empty($query)&&!empty($me['data'])){
		$min_id = (!empty($params['min_id'])&&is_numeric($params['min_id'])) ? $params['min_id'] : 0;
		$max_id = (!empty($params['max_id'])&&is_numeric($params['max_id'])) ? $params['max_id'] : "999999999999999999999999999";
		$id_range = " AND comentarios.id BETWEEN ".$min_id." AND ".$max_id." ";
		$limit = (!empty($params['limit'])&&is_numeric($params['limit'])) ? $params['limit'] : 12;
		$sql = "SELECT MAX(comentarios.id) AS id,comentarios.user AS from_user, comentarios.comentario AS comentario, comentarios.post AS post_id, items_to_sell.imagenes AS imagen, items_to_sell.nombre AS nombre, items_to_sell.descripcion AS descripcion FROM users,items_to_sell,comentarios WHERE users.id = ".$me['data']['user']['id']." AND comentarios.user != users.id AND comentarios.post IN (SELECT items_to_sell.id FROM items_to_sell WHERE user = ".$me['data']['user']['id']." AND trash = 'false') ".$id_range." AND items_to_sell.id = comentarios.post GROUP BY comentarios.post ORDER BY comentarios.id DESC LIMIT ".$limit;
		$sql = preg_replace('/\s+/', ' ', $sql);
		$con = connection();
		if ($res=$con->query($sql)) {
			while ($comentario=$res->fetch_array(MYSQLI_ASSOC)) {
				$data = $comentario;
				$data['imagen'] = explode('[EXPLODE_IMAGES]', $data['imagen']);
				$data['imagen'] = $data['imagen'][0];
				$data['texto'] = html_entity_decode($data['comentario']);
				unset($data['comentario']);
				$response['data'][] = $data;
			}
		}
		else{
			$response['code'] = 500;
			$response['code'] = $con->error;
		}
		$con->close();
	}
	else{
		$response['status'] = "error";
	}


	$sort = (!empty($params['sort'])) ? $params['sort'] : "asc";
	function array_orderby(){
	    $args = func_get_args();
	    $data = array_shift($args);
	    foreach ($args as $n => $field) {
	        if (is_string($field)) {
	            $tmp = array();
	            foreach ($data as $key => $row)
	                $tmp[$key] = $row[$field];
	            $args[$n] = $tmp;
	            }
	    }
	    $args[] = &$data;
	    call_user_func_array('array_multisort', $args);
	    return array_pop($args);
	}
	$response['data'] = ($sort=='asc') ? array_orderby($response['data'], 'id', SORT_ASC) : $response['data'];
	return (!empty($params['encode'])) ? json_encode($response, JSON_PRETTY_PRINT) : $response;
}

function imbox($arg=array(),$encode=false){
	$encode = (is_array($arg)) ? (!empty($arg['encode'])) : (!empty($encode));
	$arg = (!is_array($arg)) ? array(
		"id"=>$arg,
		"encode"=>$encode,
	) : $arg;
	$params = array_merge(array(
		"id"=>false,
		"min_id"=>0,
		"max_id"=>"9999999999999999999999999999",
		"limit"=>12,
		"encode"=>false,
	),$arg);
	$response = array(
		"status"=>"success",
		"timestamp"=>strtotime("now"),
		"data"=>array(),
	);
	$me = is_session();
	if (empty($me['data']['user']['id'])) {$response['status'] = 'error'; return $response; }
	$selector = (!empty($params['id'])) ? $params['id'] : false;
	$selector = (!empty($selector)&&strstr($selector, '=')) ? base64_decode($selector) : $selector;

	$is_md5 = (!is_numeric($selector)&&!is_bool($selector));	
	$is_all = (trim(strtolower($selector))=='all');
	$selector = (!$is_all&&!empty($selector)&&empty($is_md5)) ? " TRIM(LOWER(SUBSTR(imbox.referencia, 10))) = TRIM(LOWER('".$selector."')) " : $selector;
	$selector = ($is_all) ? " imbox.para = '".$me['data']['user']['id']."' " : $selector;
	$min_id = (!empty($params['min_id'])&&is_numeric($params['min_id'])) ? $params['min_id'] : 0;
	$max_id = (!empty($params['max_id'])&&is_numeric($params['max_id'])) ? $params['max_id'] : "999999999999999999999999999";
	$id_range = " AND imbox.id BETWEEN ".$min_id." AND ".$max_id." ";
	$order = (!empty($params['order'])) ? strtolower(trim($params['order'])) : 'ASC';
	$order = ($order=='desc') ? "DESC" : "ASC";
	$limit = (!empty($params['limit'])&&is_numeric($params['limit'])) ? $params['limit'] : 12;
	$limit = ($is_all) ? 101 : $limit;
	
	$sql = (!$is_all) ? "SELECT * FROM imbox WHERE ".$selector." ".$id_range." ORDER BY id ".$order." LIMIT ".$limit : "SELECT imbox.id AS id,MD5(SUBSTR(imbox.referencia, 10)) AS referencia , imbox.user AS user_id, users.nombre AS user_by, imbox.mensaje AS texto, imbox.status AS status, imbox.visto AS visto, imbox.fecha AS fecha FROM imbox,users WHERE ".$selector." AND imbox.user = users.id AND imbox.id ".$id_range." GROUP BY imbox.referencia ORDER BY imbox.referencia DESC LIMIT ".$limit;

	$sql = preg_replace('/\s+/', ' ', $sql);
	$con = connection();
	if ($res=$con->query($sql)) {
		while ($imbox=$res->fetch_array(MYSQLI_ASSOC)) {
			$data = $imbox;
			$data['referencia'] = base64_encode(md5(substr($data['referencia'], 0,10)));
			$data['texto'] = (!empty($data['mensaje'])) ? html_entity_decode($data['mensaje']) : $data['texto'];
			if (!empty($data['mensaje'])) {unset($data['mensaje']); }
			$data['fecha'] = (!empty($data['visto'])) ? strtotime($data['visto']) : strtotime($data['fecha']);
			$data['visto'] = (!empty($data['visto'])) ? false : false;
			unset($data['visto']);
			$data['user'] = (!empty($data['user_id'])) ? userInfo($data['user_id']) : userInfo($data['user']);
			$response['data'][] = $data;
		}
	}
	else{
		$response['status'] = 'error';
		$response['code'] = $sql;
	}
	$con->close();

	$sort = (!empty($params['sort'])) ? $params['sort'] : "asc";
	function array_orderby(){
	    $args = func_get_args();
	    $data = array_shift($args);
	    foreach ($args as $n => $field) {
	        if (is_string($field)) {
	            $tmp = array();
	            foreach ($data as $key => $row)
	                $tmp[$key] = $row[$field];
	            $args[$n] = $tmp;
	            }
	    }
	    $args[] = &$data;
	    call_user_func_array('array_multisort', $args);
	    return array_pop($args);
	}
	$response['data'] = ($sort=='asc') ? array_orderby($response['data'], 'id', SORT_ASC) : $response['data'];
	return (!empty($params['encode'])) ? json_encode($response, JSON_PRETTY_PRINT) : $response;
}

function itemFav($arg=array(),$check=false,$only=false){
	$id = (is_array($arg)&&!empty($arg['id'])) ? $arg['id'] : false;
	$id = (empty($id)&&is_numeric($arg)) ? $arg : false;
	$check = (!is_array($arg)&&!empty($check)) ? true : false;
	$check = (is_array($arg)&&!empty($arg['check'])) ? $arg['check'] : $check;
	$only = (!is_array($arg)&&!empty($only)) ? true : false;
	$only = (is_array($arg)&&!empty($arg['only'])) ? $arg['only'] : $only;
	$arg = (is_array($arg)) ? $arg : array(
		"id"=>$id,
		"check"=>$check,
		"only"=>$only,
	);
	$default = array(
		"id"=>false,
		"check"=>false,
		"only"=>false,
		"encode"=>false,
	);
	$params = array_merge($default, $arg);
	$response = array(
		"status"=>"success",
		"timestamp"=>strtotime("now"),
		"data"=>array(
			"type"=>(!empty($params['check'])) ? 'check' : "fav",
			"code"=>0,
		)
	);
	$me = is_session();
	if (!empty($params['id'])&&!empty($me['data']['user']['id'])) {
		$sql_check = "SELECT * FROM favoritos WHERE user = '".$me['data']['user']['id']."' AND item = '".$params['id']."' LIMIT 1";
		$sql_insert = "INSERT INTO favoritos (user,item) VALUES ('".$me['data']['user']['id']."','".$params['id']."')";
		$sql_delete = "DELETE FROM favoritos WHERE user = '".$me['data']['user']['id']."' AND item = '".$params['id']."'";
		$con = connection();
		if ($res=$con->query($sql_check)) {
			$response['status'] = "success";
			switch ($res->num_rows>0) {
				case true:
					if (!empty($params['check'])) {
						$response['data']['type'] = 'check';
						$response['data']['code'] = 1;
					}
					else if($res=$con->query($sql_delete)){
						$response['data']['type'] = 'fav';
						$response['data']['code'] = false;
					}
					break;
				
				default:
					if (!empty($params['check'])) {
						$response['data']['type'] = 'check';
						$response['data']['code'] = false;
					}
					else if($res=$con->query($sql_insert)){
						$response['data']['type'] = 'fav';
						$response['data']['code'] = 1;
					}
					break;
			}
		}
		$con->close();
	}
	$response = (!empty($params['only'])) ? $response['data']['code'] : $response;
	return (!empty($params['encode'])) ? json_encode($response, JSON_PRETTY_PRINT) : $response;
}



function send($arg=array()){
	$response = array(
		"status"=>"error",
		"code"=>0,
		"timestamp"=>strtotime("now"),
		"data"=>array(),
	);
	if (is_array($arg)&&!empty($arg['id'])) {
		$me = is_session();
		if (!empty($me['data']['user']['id'])) {
			if (!empty($arg['texto'])&&!empty($arg['type'])&&is_string($arg['type'])) {
				$id = (!empty($arg['id'])&&is_numeric($arg['id'])) ? $arg['id'] : false;
				$from = $me['data']['user']['id'];
				$para = (!empty($arg['to'])&&is_numeric($arg['to'])) ? $arg['to'] : true;
				$mensaje = (!empty($arg['texto'])) ? substr($arg['texto'], 0, 160) : false;
				$sql = (!empty($arg['type'])&&strtolower(trim($arg['type']))=='imbox') ? "INSERT INTO imbox (user,para,mensaje,referencia) VALUES ('".$from."','".$para."','".$mensaje."','imbox_id_".$id."')" : false;
				$sql = (!empty($arg['type'])&&strtolower(trim($arg['type']))=='comentario') ? "INSERT INTO comentarios (post,user,comentario) VALUES ('".$id."','".$from."','".$mensaje."')" : $sql;
				$con=connection();
				if (!empty($sql)) {
					if ($res=$con->query($sql)) {
						$response['status'] = 'success';
						$response['code'] = 200;
						$response['data'] = array(
							"id"=>$con->insert_id,
							"post"=>$id,
							"texto"=>$mensaje,
							"user"=>userInfo($from),
							"fecha"=>strtotime("now"),
						);
					}
				}
				else{
					$response['code'] = 500;
					$response['response'] = $sql;
				}
				$con->close();
			}
			else{
				$response['code'] = 402;
			}
		}
		else{
			$response['code'] = 400;
		}
	}
	return (!empty($arg['encode'])) ? json_encode($response, JSON_PRETTY_PRINT) : $response;
}




function linkit($value, $protocols = array('http', 'mail'), $attributes = array()){
	// Link attributes
	$attr = '';
	foreach ($attributes as $key => $val) {
		$attr = ' ' . $key . '="' . htmlentities($val) . '"';
	}
	$links = array();
	// Extract existing links and tags
	$value = preg_replace_callback('~(<a .*?>.*?</a>|<.*?>)~i', function ($match) use (&$links) { return '<' . array_push($links, $match[1]) . '>'; }, $value);
	// Extract text links for each protocol
	foreach ((array)$protocols as $protocol) {
		switch ($protocol) {
			case 'http':
			case 'https':   $value = preg_replace_callback('~(?:(https?)://([^\s<]+)|(www\.[^\s<]+?\.[^\s<]+))(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { if ($match[1]) $protocol = $match[1]; $link = $match[2] ?: $match[3]; return '<' . array_push($links, "<a $attr href=\"$protocol://$link\">$link</a>") . '>'; }, $value); break;
			case 'mail':    $value = preg_replace_callback('~([^\s<]+?@[^\s<]+?\.[^\s<]+)(?<![\.,:])~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"mailto:{$match[1]}\">{$match[1]}</a>") . '>'; }, $value); break;
			case 'twitter': $value = preg_replace_callback('~(?<!\w)[@#](\w++)~', function ($match) use (&$links, $attr) { return '<' . array_push($links, "<a $attr href=\"https://twitter.com/" . ($match[0][0] == '@' ? '' : 'search/%23') . $match[1]  . "\">{$match[0]}</a>") . '>'; }, $value); break;
			default:        $value = preg_replace_callback('~' . preg_quote($protocol, '~') . '://([^\s<]+?)(?<![\.,:])~i', function ($match) use ($protocol, &$links, $attr) { return '<' . array_push($links, "<a $attr href=\"$protocol://{$match[1]}\">{$match[1]}</a>") . '>'; }, $value); break;
		}
	}
	// Insert all link
	return preg_replace_callback('/<(\d+)>/', function ($match) use (&$links) { return $links[$match[1] - 1]; }, $value);
}

function removeDir($dir) {
	foreach(scandir($dir) as $file) {
		if ('.' === $file || '..' === $file) {continue;}
		if (is_dir($dir."/".$file)){ removeDir($dir."/".$file);}
		else {unlink($dir."/".$file);}
	}
	return rmdir($dir);
}
function createDir($path=false,$delete_if_exist=false) {
	if (is_dir($path)) {return (substr($path, -1)!='/') ? $path.'/' : $path;}
	$prev_path = substr($path, 0, strrpos($path, '/', -2) + 1 );
	$return = createDir($prev_path);
	$exe = ($return && is_writable($prev_path)) ? mkdir($path) : false;
	if (!empty($exe)) {
		return (substr($path, -1)!='/') ? $path.'/' : $path;
	}
}


function login_required($validate=false){
	$user = is_session();
	if (!empty($user['data']['user']['id'])) {
		$need_show = 'cuenta,ajustes,bitsend,salir';
		setcookie('init_log','1',time()+3600,'/');
		setcookie('user_login',$user['data']['user']['token'],time()+3600,'/');
		$_SESSION['user_login'] = $user['data']['user']['token'];
		return true;
	}
	else if (!empty($validate)) {
		return false;
	}
	else{
		header('Location: /close?next='.urlencode("login?next=profile"));
		exit();
	}
}


function uploadImagen($imagen=false,$path=false,$nombre=false){
	$path = (empty($path)) ? host("root").'upload/' : createDir($path);
	$type = 'desconocido';
	$type = (!empty($imagen['tmp_name']))	?	"file"	:	$type;
	$type = (is_string($imagen)&&strstr($imagen, 'base64')) ? "base64" : $type;
	$type = (is_string($imagen)&&strstr($imagen, 'http')) ? "url" : $type;
	$name = (empty($nombre)) ? $path.rand().rand().rand().rand().'.jpg' : $path.$nombre.'.jpg';
	switch (trim(strtolower($type))) {
		case 'file':
				return (move_uploaded_file($imagen['tmp_name'], $name)) ? $name : false;
			break;
		case 'base64':
				$imagen = explode(',', $imagen);
				$type = explode('/', explode(';', $imagen[0])[0])[1];
				$name = explode('.', $name);
				$i = 1;
				$n = '';
				foreach ($name as $key => $value) {
					if ($i<count($name)) {
						$n .= (empty($value)) ? '.' : $value;
					}
					$i++;
				}
				$name = $n.'.'.$type;
				$imagen = base64_decode($imagen[1]);
				$fn = fopen($name, "a");
				if (fputs($fn,$imagen)) {
					$imagen = str_replace('//', '/', $name);
				}
				else{
					$imagen = false;
				}
				fclose($fn);
				return $imagen;
			break;
		case 'url':
				$imagen = getURL($imagen);
				$fn = fopen($name, "a");
				if (fputs($fn,$imagen)) {
					$imagen = $name;
				}
				else{
					$imagen = false;
				}
				fclose($fn);
				return $imagen;
			break;
		default:
			if (is_file($imagen)) {
				$nombre = explode("/", $imagen);
				$nombre = end($nombre);
				$carpeta = createDir($path);
				$blob = file_get_contents($imagen);
				$fn = fopen($carpeta.$nombre, "a");
				return (fputs($fn,$blob)&&fclose($fn)) ? $carpeta.$nombre : false;
			}
		break;
	}
	return false;
}



function ticket($arg=array(),$encode=false){
	$response = array(
		"status"=>"error",
		"timestamp"=>strtotime("now"),
		"data"=>array(),
	);
	$params = array();
	$params['encode'] = ((is_array($arg)&&(!empty($arg['encode'])))||(!is_array($arg)&&!empty($encode))) ? true : $encode;
	$params['id'] = (is_array($arg)&&!empty($arg['id'])) ? $arg['id'] : $arg;
	$params['id'] = (!is_array($arg)&&is_numeric($arg)) ? $arg : $params['id'];
	$params['id'] = (!empty($params['id'])&&strstr($params['id'], '=')) ? base64_decode($params['id']) : $params['id'];
	$is_md5 = (!is_numeric($params['id'])&&!is_bool($params['id']));
	$selector = (!empty($is_md5)) ? " MD5(orden_de_compras.id) = '".$params['id']."' " : " orden_de_compras.id = '".$params['id']."' ";
	$me = is_session();
	if (!empty($me['data']['user']['id'])) {
		$selector = (strtolower(trim($params['id']))=='all') ? "(orden_de_compras.user = '".$me['data']['user']['id']."' OR items_to_sell.user = '".$me['data']['user']['id']."')" : $selector;
		$sql = "SELECT
			orden_de_compras.*,
			users.id AS seller
			FROM
			orden_de_compras,
			users,
			items_to_sell
			WHERE
			".$selector."
			AND items_to_sell.id = orden_de_compras.id_producto
			AND users.id = items_to_sell.user
			AND (users.id = '".$me['data']['user']['id']."' OR orden_de_compras.user = '".$me['data']['user']['id']."')";
		$sql = preg_replace('/\s+/', ' ', $sql);
		$con=connection();
		if ($res=$con->query($sql)) {
			$response['status'] = 'success';
			if ($res->num_rows>0) {
				while ($ticket = $res->fetch_array(MYSQLI_ASSOC)) {
					$ticket['seller'] = userInfo($ticket['seller'])['data']['user'];
					$ticket['buyer'] = userInfo($ticket['user'])['data']['user'];
					$ticket['item'] = itemInfo($ticket['id_producto'])['item'];
					unset($ticket['item']['user']);
					$response['data'][] = $ticket;
				}
			}
		}
		$con->close();
	}
	return (!empty($params['encode'])) ? json_encode($response, JSON_PRETTY_PRINT) : $response;
}




$pages_links = array(
		"inicio"=>array(
			"img"=>host('url')."/img/logo/icon_original.png",
			"titulo"=>"Inicio",
			"href"=>"/",
			"target"=>false,
			"start"=>true,
			"on_session"=>"show"
		),
		"cuenta"=>array(
			"icon"=>"far fa-user",
			"titulo"=>"Mi Cuenta",
			"href"=>"/profile",
			"target"=>false,
			"start"=>false,
			"on_session"=>"show"
		),
		"webmail"=>array(
			"icon"=>"fa fa-at",
			"titulo"=>"Correo Empresa",
			"href"=>"/webmail",
			"target"=>true,
			"start"=>true,
			"on_session"=>"show"
		),
		"bitsend"=>array(
			"img"=>"./img/icons/send_blue_1.png",
			"titulo"=>'Mensajes',
			"added"=>'<span class="tag is-danger imbox-counts-no-read" style="top: -15px; position: relative;display:none;"></span>',
			"href"=>"/profile?page=imbox",
			"target"=>false,
			"start"=>true,
			"on_session"=>"show"
		),
		"comentarios"=>array(
			"icon"=>"fa fa-comments",
			"titulo"=>'Comentarios',
			"added"=>'<span class="tag is-danger comentarios-counts-no-read" style="top: -15px; position: relative;display:none;"></span>',
			"href"=>"/profile?page=comentarios",
			"target"=>false,
			"start"=>true,
			"on_session"=>"show"
		),
		"ingresar"=>array(
			"icon"=>"fa fa-power-off",
			"titulo"=>"Ingresar",
			"href"=>"/login?next=".urlencode(substr($_SERVER['REQUEST_URI'], 1)),
			"target"=>false,
			"start"=>false,
			"on_session"=>"show"
		),
		"salir"=>array(
			"icon"=>"fa fa-sign-out-alt",
			"titulo"=>"Salir",
			"href"=>"/close?next=".urlencode(substr($_SERVER['REQUEST_URI'], 1)),
			"target"=>false,
			"start"=>false,
			"on_session"=>"show"
		),
		"twitter"=>array(
			"icon"=>"fab fa-twitter",
			"titulo"=>"@Bitcommersecash en Twitter",
			"href"=>"https://www.twitter.com/bitcommersecash",
			"target"=>"blank_",
			"start"=>false,
			"on_session"=>"show"
		),
		"instagram"=>array(
			"icon"=>"fab fa-instagram",
			"titulo"=>"@Bitcommersecash en instagram",
			"href"=>"https://www.instagram.com/bitcommersecash",
			"target"=>"blank_",
			"start"=>false,
			"on_session"=>"show"
		),
		"facebook"=>array(
			"icon"=>"fab fa-facebook",
			"titulo"=>"@Bitcommersecash en facebook",
			"href"=>"https://www.facebook.com/bitcommercash",
			"target"=>"blank_",
			"start"=>false,
			"on_session"=>"show"
		),
		"historial"=>array(
			"icon"=>"fa fa-calendar-alt",
			"titulo"=>"Historial",
			"href"=>"/profile?page=history",
			"start"=>false,
			"on_session"=>"show"
		),
		"ajustes"=>array(
			"icon"=>"fa fa-cog",
			"titulo"=>"Ajustes",
			"href"=>"/profile?page=settings",
			"start"=>false,
			"on_session"=>"show"
		),
		"bts"=>array(
			"icon"=>" fa fa-share-square ",
			"titulo"=>"BitSend",
			"href"=>"/bts",
			"start"=>false,
			"on_session"=>"show"
		),
		"bts_trades"=>array(
			"icon"=>"fa fa-history",
			"titulo"=>"BitChain",
			"href"=>"/bts_trades",
			"start"=>false,
			"on_session"=>"show"
		),
);
?>