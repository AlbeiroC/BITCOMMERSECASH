<?php
session_start();
$_SERVER['PATH_ROOT'] = './../';


function connection($act='open'){
	$con = false;
	$_SERVER['mysql_datas'] = array(
		"local"=>array(
			"host"=>"localhost",
			"user"=>"root",
			"password"=>"",
			"database"=>"bitcomme_principal"
		),
		"remote"=>array(
			"host"=>"localhost",
			"user"=>"bitcomme_arcaela",
			"password"=>"arcaelas123",
			"database"=>"bitcomme_principal"
		),
	);
	if (empty($con)) {
		$_SERVER['mysql_datas'] = (strtolower($_SERVER['HTTP_HOST'])=='bitcommersecash.local') ? $_SERVER['mysql_datas']['local'] : $_SERVER['mysql_datas']['remote'];
		$con = mysqli_connect($_SERVER['mysql_datas']['host'],$_SERVER['mysql_datas']['user'],$_SERVER['mysql_datas']['password'],$_SERVER['mysql_datas']['database']);
		date_default_timezone_set('America/Caracas');
	}
	return $con;
}
$con = connection();


$pages_links = array(
		"inicio"=>array(
			"img"=>http().$_SERVER['HTTP_HOST']."/img/logo/icon_original.png",
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
			"titulo"=>'BitSend',
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
);


function http($check=false){
	return https($check);

}
function https($check=false){
	if (empty($check)) {
		return (!empty($_SERVER['HTTPS'])) ? 'https://' : 'http://';
	}
	else{
		return (!empty($_SERVER['HTTPS'])) ? true : false;
	}
}


function setDate($fecha=false,$format='default',$lang='es'){
	if (empty($fecha)) {
		$fecha = date('Y-m-d H:i:s');
	}
	$meses_ingles = array("january", "february", "march", "april", "may", "june", "july", "august", "september", "october", "november", "december", "jan", "feb", "mar", "apr", "may", "jun", "jul", "aug", "sep", "oct", "nov", "dec");
	$meses_espanol = array('enero', 'febrero', 'marzo', 'abril', 'mayo', 'junio', 'julio', 'agosto', 'septiembre', 'octubre', 'noviembre', 'diciembre', 'ene', 'feb', 'mar', 'abr', 'may', 'jun', 'jul', 'ago', 'sep', 'oct', 'nov', 'dic');
	$dias_espanol = array('lunes', 'martes', 'miercoles', 'jueves', 'viernes', 'sabado', 'domingo', 'lun', 'mar', 'mie', 'jue', 'vie', 'sab', 'dom');
	$dias_ingles = array('monday', 'tuesday', 'wednesday', 'thursday', 'friday', 'saturday', 'sunday', 'mon', 'tue', 'wed', 'thu', 'fri', 'sat', 'sun');
	$work = strtotime($fecha);
	$now = strtotime(date('Y-m-d H:i:s'));
	$is_coming = ($work>$now);
	$up = function ($time){
		if (is_numeric($time)) {
			if ($time!=1) {
				return 's';
			}
		}
		return false;
	};
	if (!$is_coming) {
		$str = ($now-$work);
		$segundos = $str;
		$minutos = floor($str/60);
		$horas = floor($minutos/60);
		$dias = floor($horas/24);
		$semanas = floor($dias/7);
		$clock = gmdate('h:i a',$work);
		if ($format!='default') {
			return gmdate($format, $work);
		}
		else if ($segundos<60) {
			return "Hace ".$segundos." segundo".$up($segundos);
		}
		else if ($minutos<=59) {
			return "Hace ".$minutos." minuto".$up($minutos);
		}
		else if ($horas<=23) {
			return "Hace ".$horas." hora".$up($horas);
		}
		else if ($dias<=5) {
			if ($dias==1) {
				return "Ayer a las ".$clock;
			}
			return "Hace ".$dias." dia".$up($dias);
		}
		else if ($semanas>1&&$semanas<3) {
			return "Hace ".$semanas." dia".$up($semanas);
		}
		else{
			$fecha = gmdate('d \d\e l Y \a \l\a\s H:i',$work);
		}
	}
	else{
		$str = ($work-$now);
		$segundos = $str;
		$minutos = floor($str/60);
		$horas = floor($minutos/60);
		$dias = floor($horas/24);
		$semanas = floor($dias/7);
		$clock = gmdate('H:i a',$work);
 		if ($minutos<=59) {
			return "Dentro de ".$minutos." minuto".$up($minutos);
		}
		else if ($horas<=23) {
			return "Dentro de ".$horas." hora".$up($horas);
		}
		else if ($dias<=5) {
			if ($dias==1) {
				return "Mañana a las ".$clock;
			}
			return "Dentro de ".$dias." dia".$up($dias);
		}
		else if ($semanas>1&&$semanas<3) {
			return "Dentro de ".$semanas." dia".$up($semanas);
		}
		else{
			$fecha = gmdate('l d \d\e F, H:i a',$work);
		}
	}
	$fecha = ucwords(str_replace($meses_ingles, $meses_espanol, str_replace($dias_ingles, $dias_espanol, strtolower($fecha))));
	return $fecha;
}


function notification($user=false,$title=true,$text=false,$status=false){
	if (!empty($user)&&!empty($title)&&!empty($text)) {
		$_SERVER['mysql_datas'] = array("local"=>array("host"=>"localhost", "user"=>"root", "password"=>"","database"=>"bitcomme_principal"), "remote"=>array("host"=>"localhost", "user"=>"bitcomme_arcaela", "password"=>"arcaelas123","database"=>"bitcomme_principal"), );
		if (empty($con)) {$_SERVER['mysql_datas'] = (strtolower($_SERVER['HTTP_HOST'])=='bitcommersecash.local') ? $_SERVER['mysql_datas']['local'] : $_SERVER['mysql_datas']['remote']; $con = mysqli_connect($_SERVER['mysql_datas']['host'],$_SERVER['mysql_datas']['user'],$_SERVER['mysql_datas']['password'],$_SERVER['mysql_datas']['database']); date_default_timezone_set('America/Caracas'); }
		if ($user=is_session(false,$user)) {
			$sql = "INSERT INTO history (user,title,texto,status,fecha) VALUES ('".$user['user_id']."','".$title."','".$text."','".$status."',NULL)";
			if ($con->query($sql)) {
				return true;
			}
		}
	}
	return false;
}


function error_success($type='success',$response=false){
	$default = array(
		"type"=>"success",
		"response"=>"Proceso exitoso",
		"url"=>false,
		"encode"=>false
	);
	$arg = (is_array($type)) ? array_merge($default,$type) : $default;
	$arg['response'] = ($arg['type']=='success') ? 'Proceso exitoso' : $arg['response'];
	$arg['response'] = ($arg['type']=='error') ? 'Oops! Tuvimos un problema.' : $arg['type'];
	if (empty($arg['encode'])&&!empty($arg['url'])) {
		header('Location: '.$arg['url']);
		return true;
	}
	return (!empty($arg['encode'])) ? json_encode($arg, JSON_PRETTY_PRINT) : $arg;
}



function preTables(){
	$tablas =array(
		'nombre',
		'email',
		'imagen',
		'about',
		'username',
		'password',
		"facebook",
		"twitter",
		"instagram",
		"paypal",
		"wallet",
	);
	return $tablas;
}



//Convertir cadena de separadores en array recursivos
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



function BitcoinPrice($json=false){
	$price = 0;
	$name_ck = 'btc_price';
	$url = 'https://chain.so/api/v2/get_info/BTC';
	// $_SESSION['btc_price'] = false;
	$json = (!empty($_SESSION['btc_price'])) ? $_SESSION['btc_price'] : json_decode(getURL($url), true);
	$s = (((strtotime("now"))-($json['data']['price_update_time']))>=900);
	$_SESSION['btc_price'] = (!empty($s)) ? false : $json;
	$r = (!empty($_SESSION['btc_price'])) ? $_SESSION['btc_price'] : BitcoinPrice();
	return $r;
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


/*Funcion is_session() sirve para validar la existencia de una session, ya sea con un default o enviando el token a verificar*/
function is_session($destroy=true,$user=false,$token=false,$json=false){
	$con = connection();
	$tablas = preTables();
	if (!empty($token)) {$token = $token;}
	else if (!empty($_COOKIE['user_login'])) {$token = $_COOKIE['user_login'];}
	else if (!empty($_SESSION['user_login'])) {$token = $_SESSION['user_login'];}
	else if(empty($user)){return false;}
	$ingresos = $egresos = 0;
	$selector = (!empty($user)) ? $user : "(SELECT user FROM tokens WHERE token = '".$token."' AND type = 'sesion' LIMIT 1)";
	$sql = "SELECT	
	users.id						 AS	user_id,
	users.status				 	AS	user_status,
	users.grants				 	AS	user_grants,
	Lower(users.admin)			 	AS	user_admin,
	users.webmail				 	AS	user_webmail,
	users.plan					 	AS	user_plan,
	users.username				 	AS	user_username,
	users.password				 	AS	user_password,
	users.btc_price				 	AS	btc_price,
    IFNULL((SELECT facebook FROM empresa_facebook WHERE user = ".$selector." AND status = 'active' ORDER BY fecha DESC LIMIT 1),users.facebook)                 AS user_facebook, 
    IFNULL((SELECT instagram FROM empresa_instagram WHERE user = ".$selector." AND status = 'active' ORDER BY fecha DESC LIMIT 1),users.instagram)                 AS user_instagram, 
    IFNULL((SELECT twitter FROM empresa_twitter WHERE user = ".$selector." AND status = 'active' ORDER BY fecha DESC LIMIT 1),users.twitter)                 AS user_twitter, 
    IFNULL((SELECT nombre FROM empresa_nombre WHERE user = ".$selector." AND status = 'active' ORDER BY fecha DESC LIMIT 1),users.nombre)                 AS user_nombre, 
    IFNULL((SELECT email FROM empresa_email WHERE user = ".$selector." AND status = 'active' ORDER BY fecha DESC LIMIT 1),users.email)                 AS user_email, 
    IFNULL((SELECT about FROM empresa_about WHERE user = ".$selector." AND status = 'active' ORDER BY fecha DESC LIMIT 1),users.about)                 AS user_about, 
    IFNULL((SELECT imagen FROM empresa_imagen WHERE user = ".$selector." AND status = 'active' ORDER BY fecha DESC LIMIT 1),users.imagen)                 AS user_imagen, 
    IFNULL((SELECT paypal FROM empresa_paypal WHERE user = ".$selector." AND status = 'active' ORDER BY fecha DESC LIMIT 1),users.paypal)                 AS user_paypal, 
    IFNULL((SELECT wallet FROM empresa_wallet WHERE user = ".$selector." AND status = 'active' ORDER BY fecha DESC LIMIT 1),users.wallet)                 AS user_wallet, 
	Lower(paises.pais)			 	AS	pais_nombre,
	Lower(paises.iso2)			 	AS	pais_code,
	Lower(paises.moneda)		 	AS	pais_moneda,
	Lower(paises.simbolo_moneda) 	AS	pais_simbolo,
	Lower(paises.bandera)		 	AS	pais_bandera,
	IFNULL((SELECT COUNT(id) FROM items_to_sell WHERE user = ".$selector."),	0)	AS	user_publicaciones,
	IFNULL((SELECT COUNT(orden_de_compras.id) AS cantidad_de_ventas FROM items_to_sell,orden_de_compras WHERE orden_de_compras.id_producto = items_to_sell.id AND items_to_sell.user = ".$selector."),	0)	AS	user_vendidos,
	IFNULL((SELECT SUM(ingresos.monto) FROM ingresos WHERE user = ".$selector."),	0)	AS	ingresos,
	IFNULL((SELECT SUM(egresos.monto) FROM egresos WHERE user = ".$selector."),	0)	AS	egresos
	FROM
	users,
	paises
	WHERE
		users.id	=	".$selector."
		AND	paises.iso2	=	users.pais
	LIMIT 1";

	if ($res=$con->query($sql)) {
		if ($res->num_rows>0) {
			$data = $res->fetch_array(MYSQLI_ASSOC);
			$ingresos = $data['ingresos'];
			$egresos = $data['egresos'];
			$disponible = (($data['ingresos']-$egresos)>=0) ? ($data['ingresos']-$egresos) : 0;
			$data['balance'] = array(
				"disponible"=>($ingresos-$egresos<0) ? 0 : ($ingresos-$egresos),
				"ingresos"=>$ingresos,
				"egresos"=>$egresos
			);
			$data['token'] = $token;
			$data['grants'] = toArray($data['user_grants']);
			

			$data['imbox']['count'] = 0;
			$sql = "SELECT count(id) AS count FROM imbox WHERE imbox.referencia LIKE 'imbox_id_%' AND para = ".$data['user_id']." AND status = 1 GROUP BY imbox.referencia ORDER BY fecha DESC";
			if ($res=$con->query($sql)) {
				$data['imbox']['count'] = ($res->num_rows>0) ? $res->fetch_array(MYSQLI_ASSOC)['count'] : 0;
			}


			$sql = "SELECT COUNT(id) AS count FROM comentarios WHERE user != '".$data['user_id']."' AND post IN (SELECT id FROM items_to_sell WHERE user = '".$data['user_id']."') AND LOWER(TRIM(status)) = '1'";
			if ($res=$con->query($sql)) {
				$data['comentarios']['count'] = ($res->num_rows>0) ? $res->fetch_array(MYSQLI_ASSOC)['count'] : 0;
			}
			else{
				$data['comentarios']['count'] = 0;
			}
			
			$sql = "SELECT COUNT(id) AS count FROM items_to_sell WHERE user = '".$data['user_id']."' AND trash = 'false'";
			if ($res=$con->query($sql)) {
				$data['productos']['count'] = ($res->num_rows>0) ? $res->fetch_array(MYSQLI_ASSOC)['count'] : 0;
			}
			else{
				$data['productos']['count'] = 0;
			}
			$sql = "SELECT COUNT(items_to_sell.id) count FROM items_to_sell WHERE items_to_sell.id IN (SELECT favoritos.item FROM favoritos WHERE favoritos.user = '".$data['user_id']."') AND items_to_sell.trash = 'false'";
			if ($res=$con->query($sql)) {
				$data['favoritos']['count'] = ($res->num_rows>0) ? $res->fetch_array(MYSQLI_ASSOC)['count'] : 0;
			}
			else{
				$data['favoritos']['count'] = 0;
			}

			$data['btc'] = array(
				"price" => (is_numeric($data['btc_price'])&&$data['btc_price']>0) ? intval($data['btc_price']) : intval(BitcoinPrice()['data']['price']),
				"fee"	=> 0.0002
			);
			unset($data['btc_price']) ;
			$data =  (empty($data['user_id'])) ? false : $data;
			$data['user_about'] = (!empty($data['user_about'])) ? strtoupper(substr($data['user_about'], 0,1)).substr($data['user_about'], 1) : false;
			$data = utf8ize($data);
			$data = (!empty($json)) ? json_encode($data, JSON_PRETTY_PRINT) : $data;
			$con->close();
			return $data;
		}
	}
	if (!empty($destroy)) {
		$_SESSION['user_login'] = false;
		$_COOKIE['user_login'] = false;
		setcookie('user_login','635k6n34n67356g346g4',time()-846000);
		setcookie('init_log','635k6n34n67356g346g4',time()-846000);
	}
	$con->close();
	return false;
}
/* Fin de is_session();*/




/*userInfo() es una funcion que nos permite obtener los datos del usuario*/
function userInfo($id=false,$token=false,$encode=false){
	$field = (empty($token)) ? "user" : "token";
	$indicator = (empty($token)) ? $id : $token;
	$u = (empty($token)) ? is_session(false,$id,false,false) : is_session(false,false,$id,false);
	if (empty($u)) {
		return false;
	}
	if (empty($token)) {
		unset($u['balance']);
		unset($u['ingresos']);
		unset($u['egresos']);
		unset($u['user_paypal']);
		unset($u['user_wallet']);
		unset($u['user_webmail']);
		unset($u['user_grants']);
		unset($u['user_status']);
		unset($u['user_admin']);
		unset($u['user_favoritos']);
		unset($u['user_btc']);
		unset($u['token']);
	}
	unset($u['user_password']);
	unset($u['user_grants']);
	return (!empty($encode)) ? json_encode(utf8ize($u), JSON_PRETTY_PRINT) : utf8ize($u);
}
/*Fin de userInfo();*/


/*Verificar la existencia de un permiso*/
function is_grant($grant=false,$list=array()){
	return (!empty(!is_array($grant))&&!empty(is_array($list))) ? in_array($grant,$list) : false;
}
/*Fin de Verificar la existencia de un permiso*/


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

//$url indica la direccion que estamos llamando.
function getURL($url,$type="get",$params=""){
	if (!empty($url)) {
		switch (trim(strtolower($type))) {
			case 'post':
				$handler = curl_init();
				curl_setopt($handler, CURLOPT_URL, $url);
				curl_setopt($handler, CURLOPT_POST,true);
				curl_setopt($handler, CURLOPT_POSTFIELDS, $params);
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
			break;
			case 'get':
					$curl = curl_init();
					curl_setopt($curl, CURLOPT_URL, $url);
					curl_setopt($curl, CURLOPT_RETURNTRANSFER, 1);
					curl_setopt($curl, CURLOPT_FAILONERROR, true);
					curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
					curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
					curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);		
					curl_setopt($curl, CURLOPT_TIMEOUT, 10);
					$data = curl_exec($curl);
					if ($data===false) {
					  	$data = curl_error($curl);
					}
					curl_close($curl);
					return $data;				
				break;
		}
	}

	return false;
}
// Verificamos si una variable es Json o Array o String
function isJson($string) {
	if (json_decode($string)) {
		return (json_last_error() == JSON_ERROR_NONE);
	}
	return false;
}

// Listar los productos aleatorios o por categorias
function listarItems($array=array()){
	$_SERVER['mysql_datas'] = array("local"=>array("host"=>"localhost", "user"=>"root", "password"=>"","database"=>"bitcomme_principal"), "remote"=>array("host"=>"localhost", "user"=>"bitcomme_arcaela", "password"=>"arcaelas123","database"=>"bitcomme_principal"), );
	if (empty($con)) {$_SERVER['mysql_datas'] = (strtolower($_SERVER['HTTP_HOST'])=='bitcommersecash.local') ? $_SERVER['mysql_datas']['local'] : $_SERVER['mysql_datas']['remote']; $con = mysqli_connect($_SERVER['mysql_datas']['host'],$_SERVER['mysql_datas']['user'],$_SERVER['mysql_datas']['password'],$_SERVER['mysql_datas']['database']); date_default_timezone_set('America/Caracas'); }
	if ($user=is_session()) {}
	$params = array_merge(array(
		"json"=>true,
		"limit"=>6,
		"list"=>true,
		"payment"=>'bank,bitcoin,paypal',
	),$array);
	$response = array(
		"status"=>"success",
		"query"=>(!empty($params['query'])) ? $params['query'] :  false,
		"pais"=>(!empty($params['pais'])) ? $params['pais'] :  false,
		"items"=>array(),
		"unix_time_stamp"=>strtotime("now"),
	);
	$encode = (!empty($params['json'])&&$params['json']=='false'&&($params['json']!='true'&&$params['json']!=1)) ? false : true;
	/*Trabajamos el selector*/
	$query = (!empty($params['query'])&&strtolower(trim($params['query']))!='false'&&is_string($params['query'])) ? strtolower(trim($params['query'])) : 'rand';
	$query = ((strtolower($query)=='rand'||strtolower($query)=='my_items')&&empty($user['user_id'])) ? false : $query;
	$response['query'] = ($query == false) ? false : $query;
	//Si se insertó una palabra
	$selector = "LOWER(TRIM(nombre)) LIKE ('%".$query."%')";
	// Aleatorios
	$selector = (empty($query)||strtolower(trim($query))=='rand') ? ' id != 0 ' : $selector;
	// Mis productos
	$selector = (!empty($query)&&strtolower(trim($query))=='my_items'&&!empty($user['user_id'])) ? ' user =  "'.$user['user_id'].'"' : $selector;
	// Mis Favoritos
	$selector = (!empty($query)&&strtolower(trim($query))=='favoritos'&&!empty($user['user_id'])) ? ' id IN (SELECT item FROM favoritos WHERE user =  "'.$user['user_id'].'")' : $selector;
	/*Fin de Trabajamos el selector*/
	
	/*Buscamos por pais o moneda*/
	if (!empty($params['pais'])) {
		$s = explode(',', $params['pais']);
		$list_country = '';
		foreach ($s as $key) {
			$key = trim($key);
			if (!empty($key)) {
				$list_country .= (empty($list_country)) ? "'".$key."'" : ",'".$key."'";
			}
		}
	}
	$selector_country = (!empty($params['pais'])&&strtolower(trim($params['pais']))!='false') ? " AND LOWER(TRIM(currency)) IN (SELECT LOWER(TRIM(moneda)) FROM paises WHERE LOWER(TRIM(pais)) IN (".$list_country.") OR LOWER(TRIM(moneda)) IN (".$list_country.") ) " : false;
	/*Fin de Buscamos por pais o moneda*/
	
	// Buscamos por metodo de pago
	$s = explode(',', $params['payment']);
	$e = array();
	$payment_query = '';
	foreach ($s as $key) {
		$key = trim($key);
		if (empty($key)) {
			unset($s[$key]);
		}
		else{
			$e[] = '"'.$key.'"';
			$payment_query .= (empty($payment_query)) ? ' payment LIKE ("%'.$key.'%") ' : ' OR payment LIKE ("%'.$key.'%") ';
		}
	}
	$params['payment'] = implode(',', $e);
	$payment_metod = ' AND ('.$payment_query.')';
	// Fin de Buscamos por metodo de pago

	/*Trabajamos el order*/
	$seter_order = (!empty($params['set_by'])&&strtolower(trim($params['set_by']))!='false') ? $params['set_by'] : 'id';
	if (strstr(urldecode($seter_order), ',')) {
		$seter_order = explode(',', urldecode($seter_order));
		$params['order'] = $seter_order[1];
		$seter_order = $params['set_by'] = $seter_order[0];
	}
	$order = (empty($params['order'])||(strtolower(trim($params['order']))!='asc'&&strtolower(trim($params['order']))!='desc')) ? " ORDER BY RAND() " : " ORDER BY ".$seter_order." ".strtoupper(trim($params['order']))." ";
	/*Fin de Trabajamos el order*/

	// Indicamos el rango
	$up_than_field = (empty($params['up_than_field'])||!is_string($params['up_than_field'])) ? 'id' : $params['up_than_field'];
	$up_than_value = (empty($params['up_than_value'])||!is_numeric($params['up_than_value'])) ? 0 : $params['up_than_value'];
	$down_than_field = (empty($params['down_than_field'])||!is_string($params['down_than_field'])) ? "id" : $params['down_than_field'];
	$down_than_value = (empty($params['down_than_value'])||!is_numeric($params['down_than_value'])) ? "99999999999999999" : $params['down_than_value'];
	// Fin de Indicamos el rango


	/*Trabajamos el index*/
	$index = ' AND '.$up_than_field.' > '.$up_than_value.' AND '.$up_than_field.' < '.$down_than_value.' ';
	/*Fin de Trabajamos el index*/
	
	// Calculamos la cantidad de resultados a buscar
	$params['limit'] = (!empty($params['limit'])&&$params['limit']>=25) ? 24 : $params['limit'];
	$limit = (empty($params['limit'])||!is_numeric($params['limit'])) ? " LIMIT 6 " : " LIMIT ".$params['limit'];
	// Fin de Calculamos la cantidad de resultados a buscar

	$selector_list = explode(',', $params['list']);
	$p = array('1');
	foreach ($selector_list as $key) {
		if (!empty($key)&&is_numeric($key)) {
			$p[] = "'".$key."'";
		}
	}
	$selector_list = ' AND id NOT IN ('.implode(',',$p).') ';
	

	$sql = "SELECT id FROM items_to_sell WHERE ".$selector." AND trash = 'false' ".$selector_country.$selector_list.$index.$payment_metod.$order.$limit;
	// return $sql;

	if ($res=$con->query($sql)) {
		if ($res->num_rows>0) {
			while ($id_item=$res->fetch_array(MYSQLI_ASSOC)) {
				$item = itemInfo($id_item['id'],false);
				$response['items'][] = $item;
			}
		}
	}
	else{
		$response['status'] = "error";
		$response['response'] = $con->error;
	}
	$sql_optional = "SELECT id FROM items_to_sell WHERE id != '' ".$selector_list." ORDER BY RAND() LIMIT 6";
	$response['optionals'] = array(
		"status"=>"success",
		"items"=>array(),
		"timestamp"=>strtotime("now"),
	);
	if (strtolower(trim($response['query']))!='favoritos'&&strtolower(trim($response['query']))!='my_items') {
		if ($res=$con->query($sql_optional)) {
			while ($id_item=$res->fetch_array(MYSQLI_ASSOC)) {
				$item = itemInfo($id_item['id'],false);
				$response['optionals']['items'][] = $item;
			}
		}
		else{
			$response['optionals']['status'] = 'error';
			$response['optionals']['error'] = $con->error;
		}
	}
	return (!empty($encode)) ? json_encode($response, JSON_PRETTY_PRINT) : $response;
}



// Eliminamos el producto solicitado
function deleteItem($id=false,$token=false){
	$response = array(
		"status"=>"error",
		"code"=>"400",
		"id_producto"=>$id,
	);
	if (is_numeric($id)) {
		if (!empty($user=is_session())) {
			$_SERVER['mysql_datas'] = array("local"=>array("host"=>"localhost", "user"=>"root", "password"=>"","database"=>"bitcomme_principal"), "remote"=>array("host"=>"localhost", "user"=>"bitcomme_arcaela", "password"=>"arcaelas123","database"=>"bitcomme_principal"), );
			if (empty($con)) {$_SERVER['mysql_datas'] = (strtolower($_SERVER['HTTP_HOST'])=='bitcommersecash.local') ? $_SERVER['mysql_datas']['local'] : $_SERVER['mysql_datas']['remote']; $con = mysqli_connect($_SERVER['mysql_datas']['host'],$_SERVER['mysql_datas']['user'],$_SERVER['mysql_datas']['password'],$_SERVER['mysql_datas']['database']); date_default_timezone_set('America/Caracas'); }
			$sql = "SELECT * FROM items_to_sell WHERE id = '".$id."' AND trash = 'false' LIMIT 1";
			if ($res=$con->query($sql)) {
				if ($res->num_rows>0) {
					$user_item = $res->fetch_array(MYSQLI_ASSOC)['user'];
					if ($user['user_id']==$user_item) {
						if (!empty($token)&&strtolower(trim($user['user_password']))==strtolower(trim($token))) {
							$sql = "SELECT id FROM orden_de_compras WHERE id_producto = '".$id."' AND status = 'false' LIMIT 1";
							if ($res=$con->query($sql)) {
								if ($res->num_rows<=0) {
									$sql = "UPDATE items_to_sell SET trash = 'true' WHERE id = '".$id."' AND user = '".$user['user_id']."' AND trash = 'false'";
									if ($con->query($sql)) {
										$response['code'] = 1;
										$response['status'] = "success";									
										$response['response'] = "success";									
									}
									else{
										$response['code'] = 500;
										$response['response'] = $con->error;									
									}
								}
								else{
									$response['code'] = 400;
									$response['response'] = "Have pending request";
								}
							}
							else{
								$response['code'] = 500;
								$response['response'] = $con->error;							
							}
						}
						else{
							$response['code'] = 400;
							$response['response'] = "token";
						}
					}
					else{
						$response['code'] = 400;
						$response['response'] = "permission";
					}
				}
				else{
					$response['code'] = 404;
					$response['response'] = "Item not found";
				}
			}
			else{
				$response['code'] = 500;
				$response['response'] = $con->error;
			}
		}
	}

	return json_encode($response, JSON_PRETTY_PRINT);
}
// Fin de Eliminamos el producto solicitado


// Esta funcion nos da los datos de los productos por su ID
function itemInfo($id=false,$encode=true){
	$_SERVER['mysql_datas'] = array("local"=>array("host"=>"localhost", "user"=>"root", "password"=>"","database"=>"bitcomme_principal"), "remote"=>array("host"=>"localhost", "user"=>"bitcomme_arcaela", "password"=>"arcaelas123","database"=>"bitcomme_principal"), );
	if (empty($con)) {$_SERVER['mysql_datas'] = (strtolower($_SERVER['HTTP_HOST'])=='bitcommersecash.local') ? $_SERVER['mysql_datas']['local'] : $_SERVER['mysql_datas']['remote']; $con = mysqli_connect($_SERVER['mysql_datas']['host'],$_SERVER['mysql_datas']['user'],$_SERVER['mysql_datas']['password'],$_SERVER['mysql_datas']['database']); date_default_timezone_set('America/Caracas'); }
	$user = is_session();
	$info = array();
	if (!empty($id)&&is_numeric($id)) {

$sql = "SELECT
		paises.nombre_moneda          AS nombre_divisa, 
       'fa circle-o'                  AS icon, 
       paises.bandera                 AS bandera, 
       paises.pais                    AS pais, 
       users.id                       AS id_user, 
       users.pais                     AS iso_user, 
       users.username                 AS user, 
       users.nombre                   AS company, 
       items_to_sell.id               AS id_producto, 
       items_to_sell.nombre           AS producto, 
       items_to_sell.descripcion      AS descripcion, 
       items_to_sell.precio_usd       AS precio_usd,
       items_to_sell.precio_btc       AS precio_btc, 
       items_to_sell.destination      AS destination, 
       items_to_sell.currency         AS divisa, 
       items_to_sell.stock            AS existencias, 
       items_to_sell.imagenes         AS imagen, 
       'tecnologia'                   AS categoria, 
       items_to_sell.payment          AS payments, 
       items_to_sell.fecha            AS fecha 
FROM   users, 
       items_to_sell, 
       paises 
WHERE  items_to_sell.trash = 'false' 
AND    users.id = items_to_sell.USER 
AND    items_to_sell.id = '".$id."' 
AND    Lower(Trim(paises.iso2)) = Lower(Trim(users.pais)) limit 1";

		if ($res=$con->query($sql)) {
			if ($res->num_rows>0) {
				$info = $res->fetch_array(MYSQLI_ASSOC);
				$info['imagen'] = explode('[EXPLODE_IMAGES]', $info['imagen']);
				$img_list = array();
				foreach ($info['imagen'] as $key => $value) {
					$k = explode('/', $value);
					$k = end($k);
					$k = explode('.', $k);
					$k = $k[0];
					$img_list[$key] = $value;
				}
				$info['imagen'] = $img_list;
				$info['payments'] = explode(',', $info['payments']);
				$categorias = explode(',', $info['categoria']);
				$sql = array();
				foreach ($categorias as $word) {
					$sql[] = "categorias LIKE '%".$word."%'";
				}
				$sql = "SELECT categorias,icon,COUNT(id) AS o FROM categorias WHERE ".implode(' OR ', $sql)." GROUP BY categorias ORDER BY COUNT(id) DESC LIMIT 1";
				if ($res=$con->query($sql)) {
					if ($res->num_rows>0) {
						$res = $res->fetch_array(MYSQLI_ASSOC);
						$info['icon'] = $res['icon'];
					}
				}
				$sql = "SELECT paises.nombre_moneda FROM paises WHERE LOWER(moneda) = LOWER('".$info['divisa']."') LIMIT 1";
				if ($res=$con->query($sql)) {
					if ($res->num_rows>0) {
						$res = $res->fetch_array(MYSQLI_ASSOC);
						$info['nombre_divisa'] = $res['nombre_moneda'];
					}
				}
				$info['trades'] = array(
					"success"=>0,
					"pending"=>0,
					"reject"=>0,
					"total"=>0,
				);
				$sql = "SELECT * FROM orden_de_compras WHERE id_producto = '".$info['id_producto']."'";
				if ($res=$con->query($sql)) {
					while ($s=$res->fetch_array(MYSQLI_ASSOC)) {
						$info['trades']['success'] = (strtolower(trim($s['status']))=='success') ? (($info['trades']['success']*1)+($s['cantidad']*1)) : $info['trades']['success'];
						$info['trades']['pending'] = (strtolower(trim($s['status']))=='pending') ? (($info['trades']['pending']*1)+($s['cantidad']*1)) : $info['trades']['pending'];
						$info['trades']['reject'] = (strtolower(trim($s['status']))=='reject') ? (($info['trades']['reject']*1)+($s['cantidad']*1)) : $info['trades']['reject'];
						$info['trades']['total'] = (($info['trades']['total']*1)+($s['cantidad']*1));
					}
				}
				$info['existencias'] = (($info['existencias']*1)-($info['trades']['total']*1));
				$info['is_my'] = (!empty($user['user_id'])&&$user['user_id']==$info['id_user']) ? true : false;
				$info['is_fav'] = "unavaible";
				if (is_array($user)&&!empty($user['user_id'])) {
					$info['is_fav'] = favItem($info['id_producto'],true);
				}
				$info['user_json'] = userInfo($info['id_user']);
				$info['precio_btc'] = (!is_numeric($info['precio_btc'])) ? floatval(number_format((intval($info['precio_usd'])/intval($info['user_json']['btc']['price'])),8,'.','')) : $info['precio_btc'];
			}
		}
		else{
			return array(
				"status"=>"error",
				"response"=>"500",
				"m"=>$sql,
			);			
		}
	}
	else{
		return array(
			"status"=>"error",
			"response"=>"500"
		);
	}
	return (!empty($encode)) ? json_encode($info, JSON_PRETTY_PRINT) : $info;
}



function listComments($params=array()){
	header('Content-Type: text/json');
	$_SERVER['mysql_datas'] = array("local"=>array("host"=>"localhost", "user"=>"root", "password"=>"","database"=>"bitcomme_principal"), "remote"=>array("host"=>"localhost", "user"=>"bitcomme_arcaela", "password"=>"arcaelas123","database"=>"bitcomme_principal"), );
	if (empty($con)) {$_SERVER['mysql_datas'] = (strtolower($_SERVER['HTTP_HOST'])=='bitcommersecash.local') ? $_SERVER['mysql_datas']['local'] : $_SERVER['mysql_datas']['remote']; $con = mysqli_connect($_SERVER['mysql_datas']['host'],$_SERVER['mysql_datas']['user'],$_SERVER['mysql_datas']['password'],$_SERVER['mysql_datas']['database']); date_default_timezone_set('America/Caracas'); }
	$default = array(
		"comments"=>"all",
		"index"=>false,
		"rows"=>6,
		"up_than"=>0,
		"down_than"=>"999999999999999999999",
		"encode"=>true,
		"list"=>"0",
	);
	$params = array_merge($default,$params);

	$strOrNumber = (!empty($params['comments'])&&(!is_numeric($params['comments']))) ? ' all ' : $params['comments'];
	$selector = (is_numeric($strOrNumber)) ? $params['comments'] : ' items_to_sell.id ';

	$user = is_session();
	if (empty($user['user_id'])&&!is_numeric($strOrNumber)) {
		return error_success(array(
			"type"=>"error",
			"response"=>"No hemos recibido un parametro de busqueda",
			"optional"=>$params,
			"encode"=>true,
		));
	}

	$f_tables = (!empty($user['user_id'])) ? ' items_to_sell,' : false;
	$w_tables = (!empty($user['user_id'])&&!is_numeric($params['comments'])) ? " AND items_to_sell.user = ".$user['user_id'] : false;
	$o_tables = (!empty($user['user_id'])&&!is_numeric($strOrNumber)) ? " ,comentarios.status DESC" : false;

	$up_than = ' AND '.(!empty($params['up_than'])&&is_numeric($params['up_than'])) ? " AND comentarios.id > ".$params['up_than'] : " AND comentarios.id > 0 ";
	$down_than = ' AND '.(!empty($params['down_than'])&&is_numeric($params['down_than'])) ? " AND comentarios.id < ".$params['down_than'] : " AND comentarios.id < '999999999999999999999999999' ";
	$index = $up_than.$down_than;
	$no_readed = (!empty($params['comments'])&&strtolower(trim($strOrNumber))=='all') ? " AND comentarios.status = '1' " : false;

	$is_my = (!is_numeric($strOrNumber)) ? ' AND comentarios.user != "'.$user['user_id'].'" ' : false;
	
	$sql = "SELECT
comentarios.id 		AS id,
comentarios.post 	AS post,
comentarios.comentario 	AS comentario,
comentarios.user 	AS user,
comentarios.status 	AS status,
comentarios.fecha 	AS fecha,
comentarios.visto 	AS visto

FROM
".$f_tables."
comentarios

WHERE
comentarios.post = ".$selector."
".$w_tables."
".$index."
".$no_readed."
AND comentarios.id NOT IN (".$params['list'].")
".$is_my."
GROUP BY comentarios.id

ORDER BY
comentarios.id DESC
".$o_tables."

LIMIT ".$params['rows'];

	if ($res=$con->query($sql)) {
		$comments = array(
			"type"=>"success",
			"data"=>false
		);
		$i = 0;
		while ($comment=$res->fetch_array(MYSQLI_ASSOC)) {
			$comments['data'][$i] = $comment;
			$comments['data'][$i]['item'] = itemInfo($comment['post'],false);
			$comments['data'][$i]['user'] = userInfo($comment['user'],false);
			$comments['data'][$i]['user']['is_my'] = (!empty($user['user_id'])&&$user['user_id']==$comment['user']) ? true : false;
			$i++;
		}
		return (!empty($params['encode'])) ? json_encode($comments, JSON_PRETTY_PRINT) : $comments;
	}
	return error_success(array(
		"type"=>"error",
		"response"=>$con->error,
		"encode"=>true,
	));
}





function favItem($id=false,$check=false,$encode=false){
	$_SERVER['mysql_datas'] = array("local"=>array("host"=>"localhost", "user"=>"root", "password"=>"","database"=>"bitcomme_principal"), "remote"=>array("host"=>"localhost", "user"=>"bitcomme_arcaela", "password"=>"arcaelas123","database"=>"bitcomme_principal"), );
	if (empty($con)) {$_SERVER['mysql_datas'] = (strtolower($_SERVER['HTTP_HOST'])=='bitcommersecash.local') ? $_SERVER['mysql_datas']['local'] : $_SERVER['mysql_datas']['remote']; $con = mysqli_connect($_SERVER['mysql_datas']['host'],$_SERVER['mysql_datas']['user'],$_SERVER['mysql_datas']['password'],$_SERVER['mysql_datas']['database']); date_default_timezone_set('America/Caracas'); }
	$r = array(
		"type"=>"error",
		"response"=>false,
		"code"=>false,
	);
	if (is_session()&&$user=is_session()) {
		if (!empty($id)) {
			$sql = "SELECT * FROM favoritos WHERE item = '".$id."' AND user = '".$user['user_id']."' LIMIT 1";
			$sqlInsert = "INSERT INTO favoritos (user,item,fecha) VALUES ('".$user['user_id']."','".$id."',NULL)";
			$sqlDelete = "DELETE FROM favoritos WHERE item = '".$id."' AND user = '".$user['user_id']."'";
			if ($res=$con->query($sql)) {
				if (!empty($check)&&$res->num_rows>0) {
					$r = array("type"=>"success","response"=>"is_fav","code"=>true);
				}
				else if (!empty($check)&&$res->num_rows<1) {
					$r = array("type"=>"success","response"=>"is_fav","code"=>false);
				}
				else if(empty($check)&&$res->num_rows>0){
					if ($res=$con->query($sqlDelete)) {
						$r = array("type"=>"success","response"=>"add_fav","code"=>false);
					}
				}
				else if(empty($check)&&$res->num_rows<1){
					if ($res=$con->query($sqlInsert)) {
						$r = array("type"=>"success","response"=>"add_fav","code"=>true);
					}
				}
			}
		}
	}
	if(!empty($encode)) header('Content-type: text/json');
	return (!empty($encode)) ? json_encode($r) : $r;
}




function sendImbox($to=false,$mensaje=false,$from=false,$referencia) {
	if (!empty($mensaje)) {
		if ($recibe = userInfo($to)) {
			$_SERVER['mysql_datas'] = array("local"=>array("host"=>"localhost", "user"=>"root", "password"=>"","database"=>"bitcomme_principal"), "remote"=>array("host"=>"localhost", "user"=>"bitcomme_arcaela", "password"=>"arcaelas123","database"=>"bitcomme_principal"), );
			if (empty($con)) {$_SERVER['mysql_datas'] = (strtolower($_SERVER['HTTP_HOST'])=='bitcommersecash.local') ? $_SERVER['mysql_datas']['local'] : $_SERVER['mysql_datas']['remote']; $con = mysqli_connect($_SERVER['mysql_datas']['host'],$_SERVER['mysql_datas']['user'],$_SERVER['mysql_datas']['password'],$_SERVER['mysql_datas']['database']); date_default_timezone_set('America/Caracas'); }
			$user = is_session();
			$to = $recibe['user_id'];
			$mensaje = (!empty($specialcharts)) ? htmlspecialchars($mensaje, ENT_QUOTES) : $mensaje;
			$referencia = empty($referencia) ? 'mensaje_para_'.$to : $referencia;
			$from = (!empty($from)&&(is_numeric($from))) ? $from : $user['user_id'];
			$sql = "INSERT INTO imbox (user,para,mensaje,referencia,fecha) VALUES ('".$from."','".$to."','".$mensaje."','".$referencia."',NULL)";
			if ($con->query($sql)) {
				$id_imbox = $con->insert_id;
				notification($recibe['user_id'],'Mensaje Recibido','Has recibido un mensaje de @'.$user['user_username'].' diciendo: '.$mensaje);
				$user = userInfo($user['user_id'],false,false);
				$user['is_my'] = true;
				return error_success(array(
					"id"=>$id_imbox,
					"user"=>$user,
					"comentario"=>$mensaje,
					"fecha"=>"now",
					"type"=>"success"
				));
			}
		}
	}
	return error_success(array(
		"type"=>"error",
	));
}



function responseComment($id_comment=false,$comentario=false){
	if (!empty($comentario)&&!empty(is_numeric($id_comment))) {
		$_SERVER['mysql_datas'] = array("local"=>array("host"=>"localhost", "user"=>"root", "password"=>"","database"=>"bitcomme_principal"), "remote"=>array("host"=>"localhost", "user"=>"bitcomme_arcaela", "password"=>"arcaelas123","database"=>"bitcomme_principal"), );
		if (empty($con)) {$_SERVER['mysql_datas'] = (strtolower($_SERVER['HTTP_HOST'])=='bitcommersecash.local') ? $_SERVER['mysql_datas']['local'] : $_SERVER['mysql_datas']['remote']; $con = mysqli_connect($_SERVER['mysql_datas']['host'],$_SERVER['mysql_datas']['user'],$_SERVER['mysql_datas']['password'],$_SERVER['mysql_datas']['database']); date_default_timezone_set('America/Caracas'); }
		$user = is_session();
		$sql = "UPDATE comentarios SET status = '0' WHERE id = '".$id_comment."' AND post IN (SELECT id FROM items_to_sell WHERE user = '".$user['user_id']."')";
		if ($con->query($sql)) {
			$sql = "SELECT * FROM comentarios WHERE id = '".$id_comment."' AND post IN (SELECT id FROM items_to_sell WHERE user = '".$user['user_id']."')";
			if ($res=$con->query($sql)) {
				if ($res->num_rows>0) {
					$d = $res->fetch_array(MYSQLI_ASSOC);
					$send = sendImbox($d['user'],htmlspecialchars($comentario, ENT_QUOTES));
					if ($send['type']=='success') {
						return error_success(array(
							"type"=>"success",
							"response"=>1,
							"text"=>"Tu mensaje se envió correctamente",
							"encode"=>true,
						));
					}
					else{
						return error_success(array(
							"type"=>"error",
							"response"=>500,
							"text"=>"unknown",
							"encode"=>true,
						));
					}
				}
				else{
					return error_success(array(
						"type"=>"error",
						"response"=>500,
						"encode"=>true,
						"text"=>$con->error,
					));
				}				
			}
			else{
				return error_success(array(
					"type"=>"error",
					"response"=>500,
					"text"=>$con->error,
					"encode"=>true,
				));
			}
		}
		else{
			return error_success(array(
				"type"=>"error",
				"response"=>500,
				"text"=>$con->error,
				"encode"=>true,
			));
		}
	}
}




// Enviar un comentario de algun producto
function send($id=false,$texto=false,$referencia=false,$redirect=false){
	$_SERVER['mysql_datas'] = array("local"=>array("host"=>"localhost", "user"=>"root", "password"=>"","database"=>"bitcomme_principal"), "remote"=>array("host"=>"localhost", "user"=>"bitcomme_arcaela", "password"=>"arcaelas123","database"=>"bitcomme_principal"), );
	if (empty($con)) {$_SERVER['mysql_datas'] = (strtolower($_SERVER['HTTP_HOST'])=='bitcommersecash.local') ? $_SERVER['mysql_datas']['local'] : $_SERVER['mysql_datas']['remote']; $con = mysqli_connect($_SERVER['mysql_datas']['host'],$_SERVER['mysql_datas']['user'],$_SERVER['mysql_datas']['password'],$_SERVER['mysql_datas']['database']); date_default_timezone_set('America/Caracas'); }
	if (!empty($id)&&(is_numeric($id))&&!empty($texto)) {
		$texto = substr($texto, 0,160);
		$texto = htmlspecialchars($texto, ENT_QUOTES);
		if ($user=is_session()) {
			$sql = "INSERT INTO comentarios (user,post,comentario,fecha) VALUES ('".$user['user_id']."','".$id."','".$texto."',NULL)";
			if ($con->query($sql)) {
				$user['coment_id'] = $con->insert_id;
				$user['is_my'] = true;
				return error_success(array(
					"type"=>"success",
					"response"=>"undefined",
					"send_by"=>$user,
					"encode"=>true,
				));
			}
		}
	}
	return error_success(array(
		"type"=>"error",
		"response"=>"undefined",
		"encode"=>true,
	));
}
// Fin de Enviar un comentario de algun producto





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




// uploadImagen(imagen,ruta,encode,download)
function uploadImagen($imagen=false,$path=false,$nombre=false){
	$path = (empty($path)) ? $_SERVER['PATH_ROOT'].'upload/' : createDir($path);
	$type = 'desconocido';
	if (!empty($imagen['tmp_name'])) {
		$type = 'file';
	}
	else if(strstr($imagen, 'base64')){
		$type = "base64";
	}
	else if(strstr($imagen, 'http')){
		$type = 'url';
	}
	$name = (empty($nombre)) ? $path.rand().rand().rand().rand().'.jpg' : $path.$nombre.'.jpg';
	switch (trim(strtolower($type))) {
		case 'file':
				// En caso de que se suba por un input file
				return (move_uploaded_file($imagen['tmp_name'], $name)) ? $name : false;
				// Fin de En caso de que se suba por un input file
			break;
		case 'base64':
				// En caso de que se cargue por un Base64
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
				// Fin de En caso de que se cargue por un Base64
			break;
		case 'url':
				// En caso de que haya que descargarla desde una url
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
				// Fin de En caso de que haya que descargarla desde una url
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




// Comprobar si ya existe un registro en una tabla determinada
function existReg($reg=false,$campo=false,$tabla=false){
	if (!empty($reg)&&!empty($campo)&&!empty($tabla)) {
		$_SERVER['mysql_datas'] = array("local"=>array("host"=>"localhost", "user"=>"root", "password"=>"","database"=>"bitcomme_principal"), "remote"=>array("host"=>"localhost", "user"=>"bitcomme_arcaela", "password"=>"arcaelas123","database"=>"bitcomme_principal"), );
		if (empty($con)) {$_SERVER['mysql_datas'] = (strtolower($_SERVER['HTTP_HOST'])=='bitcommersecash.local') ? $_SERVER['mysql_datas']['local'] : $_SERVER['mysql_datas']['remote']; $con = mysqli_connect($_SERVER['mysql_datas']['host'],$_SERVER['mysql_datas']['user'],$_SERVER['mysql_datas']['password'],$_SERVER['mysql_datas']['database']); date_default_timezone_set('America/Caracas'); }
		$sql = "SELECT id FROM ".$tabla." WHERE LOWER(".$campo.") = LOWER('".$reg."') LIMIT 1";
		if ($res=$con->query($sql)) {
			if ($res->num_rows<=0) {
				return false;
			}
			unset($res);
		}
		unset($con);
	}
	return true;
}



//Ordenar los arrays por su llave
function sksort($array, $subkey="id", $sort_ascending=false) {
    if (count($array))
        $temp_array[key($array)] = array_shift($array);
    foreach($array as $key => $val){
        $offset = 0;
        $found = false;
        foreach($temp_array as $tmp_key => $tmp_val){
            if(!$found and strtolower($val[$subkey]) > strtolower($tmp_val[$subkey])){
                $temp_array = array_merge((array)array_slice($temp_array,0,$offset),
                                            array($key => $val),
                                            array_slice($temp_array,$offset)
                                          );
                $found = true;
            }
            $offset++;
        }
        if(!$found) $temp_array = array_merge($temp_array, array($key => $val));
    }
    if ($sort_ascending) $array = array_reverse($temp_array);
    else $array = $temp_array;
}






function ticketDetails($ticket=false,$encode=true){
	$id = (!is_array($ticket)) ? $ticket : false;
	$id = (is_array($ticket)&&!empty($ticket['id'])) ? $ticket['id'] : $id;
	$info = error_success(array(
		"type"=>"error",
		"encode"=>false,
	));
	if (!empty($id)) {
		$_SERVER['mysql_datas'] = array("local"=>array("host"=>"localhost", "user"=>"root", "password"=>"","database"=>"bitcomme_principal"), "remote"=>array("host"=>"localhost", "user"=>"bitcomme_arcaela", "password"=>"arcaelas123","database"=>"bitcomme_principal"), );
		if (empty($con)) {$_SERVER['mysql_datas'] = (strtolower($_SERVER['HTTP_HOST'])=='bitcommersecash.local') ? $_SERVER['mysql_datas']['local'] : $_SERVER['mysql_datas']['remote']; $con = mysqli_connect($_SERVER['mysql_datas']['host'],$_SERVER['mysql_datas']['user'],$_SERVER['mysql_datas']['password'],$_SERVER['mysql_datas']['database']); date_default_timezone_set('America/Caracas'); }
		$sql = "SELECT * FROM orden_de_compras WHERE id = '".$id."' LIMIT 1";
		if ($res=$con->query($sql)) {
			if ($res->num_rows>0) {
				$ticket = $res->fetch_array(MYSQLI_ASSOC);
				$item = itemInfo($ticket['id_producto'],false);
				$seller = userInfo($item['id_user'],false,false);
				$buyer = userInfo($ticket['user'],false,false);
				$info = error_success(array(
					"type"=>"success",
					"id"=>$ticket['id'],
					"ticket"=>$ticket,
					"item"=>$item,
					"seller"=>$seller,
					"buyer"	=>$buyer,
					"timestamp"=>strtotime("now"),
				));
			}
			else{
				$info['respuesta'] = "No hemos podido conseguir esa factura.";
			}
		}
		else{
			$info['respuesta'] = $con->error;
		}
	}
	return (is_array($info)&&!empty($encode)) ? json_encode($info, JSON_PRETTY_PRINT) : $info;
}


function getTicketImbox($ticket=false){
	$id = (!is_array($ticket)) ? $ticket : false;
	$id = (is_array($ticket)&&!empty($ticket['id'])) ? $ticket['id'] : $id;
	$user = is_session();
	$imbox = error_success(array(
		"type"=>"error",
		"encode"=>true,
	));
	if (!empty($ticket)&&!empty($user['user_id'])) {
		$con = connection();
		$defaults = array(
			"id"=>$id,
			"up_than"=>0,
			"down_than"=>"999999999999999999999999999",
			"list"=>"0",
			"rows"=>"10",
		);
		$params = (is_array($ticket)) ? $ticket : array('id'=>$ticket);
		$params = array_merge($defaults,$params);
		$encode = (!empty($params['encode'])) ? true : false;
		$params['list'] = explode(',', $params['list']);
		foreach ($params['list'] as $value) {
			if (!empty($value)||($value==0)) {
				$list = (empty($list)) ? "'".$value."'" : ",'".$value."'";
			}
		}
		$sql = "SELECT id_producto FROM orden_de_compras WHERE id = '".$params['id']."' LIMIT 1";
		if ($res=$con->query($sql)) {
			if ($res->num_rows>0) {
				$item = $res->fetch_array(MYSQLI_ASSOC);
			}
			else{
				$error = true;
			}
		}
		else{
			$error = true;
		}

		$update = "UPDATE imbox SET status = 0 WHERE para = '".$user['user_id']."' AND referencia = 'imbox_id_".$params['id']."' AND id > '".$params['up_than']."' AND id < '".$params['down_than']."' AND id NOT IN (".$list.") ORDER BY id DESC LIMIT ".$params['rows'];
 		$sql = "SELECT * FROM imbox WHERE referencia = 'imbox_id_".$params['id']."' AND id > '".$params['up_than']."' AND id < '".$params['down_than']."' AND id NOT IN (".$list.") ORDER BY id DESC LIMIT ".$params['rows'];
		if (empty($error)&&$res=$con->query($sql)) {
			if($f=$con->query($update)){};
			if ($res->num_rows>0) {
				$imbox = array(
					"type"=>"success",
					"data"=>array(),
				);
				$i = 0;
				while ($mensaje=$res->fetch_array(MYSQLI_ASSOC)) {
					$imbox['data'][$i] = $mensaje;
					$imbox['data'][$i]['post'] = intval(str_replace('imbox_id_', '', $imbox['data'][$i]['referencia']));
					unset($imbox['data'][$i]['referencia']);
					$imbox['data'][$i]['comentario'] = $imbox['data'][$i]['mensaje'];
					unset($imbox['data'][$i]['mensaje']);
					$imbox['data'][$i]['user'] = userInfo($mensaje['user'], false);
					$imbox['data'][$i]['item'] = itemInfo($item['id_producto'], false);
					$imbox['data'][$i]['received_by'] = userInfo($mensaje['para'], false);
					$imbox['data'][$i]['user']['is_my'] = ($imbox['data'][$i]['user']['user_id']==$user['user_id']);
					$i++;
				}
			}
			else{
				$imbox = array(
					"type"=>"success",
					"data"=>array(),
				);
			}
		}
		else{
			$imbox = array();
			$imbox['code'] = $con->error;
		}		
	}
	$con->close();
	return (!empty($encode)) ? json_encode($imbox, JSON_PRETTY_PRINT) : $imbox;
}




function listTickets($user=false,$up_than=0,$down_than="99999999999999999",$encode=true){
	$imbox = array(
		"status"=>"error",
		"list"=>array(),
		"start"=>"0",
		"end"=>"99999999999999999",
	);
	if (!empty($user)) {
		$selector = $user;
		$con = connection();
		$margen = " AND id > ".$up_than." AND id < ".$down_than." ";
		$sql = "SELECT imbox.id AS id_imbox, (imbox.user*1) AS send_by, SUBSTR(imbox.referencia,10) AS id_ticket, SUBSTRING(imbox.mensaje,1,30) AS mensaje, imbox.status AS status, imbox.fecha AS sended FROM imbox WHERE imbox.referencia LIKE 'imbox_id_%'AND para = ".$selector." ".$margen." GROUP BY imbox.referencia ORDER BY fecha DESC";
		if ($res=$con->query($sql)) {
			if ($res->num_rows>0) {
				$imbox['status']="success";
				while ($i=$res->fetch_array(MYSQLI_ASSOC)) {
					$imbox['start'] = ($imbox['start']==0) ? $i['id_imbox'] : $imbox['start'];
					$imbox['end'] = $i['id_imbox'];
					$i['link'] = http().$_SERVER['HTTP_HOST'].'/contact/'.base64_encode(md5($i['id_ticket']));
					$i['user'] = userInfo($i['send_by']);
					$imbox['list'][] = $i;
				}
			}
		}
		$con->close();
	}
	return (!empty($encode)) ? json_encode($imbox, JSON_PRETTY_PRINT) : $imbox;
}



?>