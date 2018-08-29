<?php
	include('./cm/functions.php');
	if ($log = is_session()) {
		$sql = "DELETE FROM tokens WHERE user = '".$log['user_id']."' AND token = '".$log['token']."'";
		if ($con->query($sql)) {}
	}
	setcookie('user_login','635k6n34n67356g346g4',time()-846000);
	setcookie('init_log','635k6n34n67356g346g4',time()-846000);
	$url = (empty($_GET['next'])) ? http().$_SERVER['HTTP_HOST'] : http().$_SERVER['HTTP_HOST'].'/'.urldecode($_GET['next']);
	header('Location: '.$url);
?>