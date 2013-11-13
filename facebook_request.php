<?php
require('../../config.php');
require_once 'eblib/facebook.php';
require_once 'eblib/misc.php';

$conf = get_config("auth/elcentra");

$facebookConfig = array(
		"app_id"=>$conf->facebookclientid,
		"app_secret"=>$conf->facebookclientsecret,
		"base_url"=>$conf->facebook_base_url,
		"token_access_url"=>$conf->facebook_token_access_url,
		"retrieval_url"=>$conf->facebook_retrieval_url,
		"scope"=>$conf->facebook_scope
		);

if($facebookConfig['app_id']=="" || $facebookConfig['app_secret']=="") {
	throw new moodle_exception("Facebook login is not configured. Contact admin");
}

$fbObject = new EbuildersFacebook();
$fbObject->setConfig($facebookConfig);
$fbObject->sendAccessRequest();