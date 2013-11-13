<?php
require('../../config.php');
require_once 'eblib/google.php';
require_once 'eblib/misc.php';

$conf = get_config("auth/elcentra");

$googleConfig = array(
		"app_id"=>$conf->googleclientid,
		"app_secret"=>$conf->googleclientsecret,
		"base_url"=>$conf->google_base_url,
		"token_access_url"=>$conf->google_token_access_url,
		"retrieval_url"=>$conf->google_retrieval_url,
		"scope"=>$conf->google_scope,
	);

if($googleConfig['app_id']=="" || $googleConfig['app_secret']=="") {
	throw new moodle_exception("Google login is not configured. Contact admin");
}

$googleObject = new EbuildersGoogle();
$googleObject->setConfig($googleConfig);
$googleObject->sendAccessRequest();