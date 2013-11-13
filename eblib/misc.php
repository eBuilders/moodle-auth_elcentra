<?php 

function randomString($length=10) {
	$characters = '0123456789abcdefghijklmnopqrstuvwxyzABCDEFGHIJKLMNOPQRSTUVWXYZ';
	$randstring = '';
	for($i = 0; $i < $length; $i ++) {
		$randstring.=$characters [rand ( 0, strlen ( $characters )-1 )];
	}
	return $randstring;
}

function loginDenied($loginType) {
	global $CFG; 
	
	if(isset($_SESSION[$loginType."_login"]['state'])) {
		unset($_SESSION[$loginType."_login"]['state']);
	}
	
	header("Location: ".$CFG->wwwroot."/login/index.php");
	exit;
}

?>