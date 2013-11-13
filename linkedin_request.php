<?php
require('../../config.php');
require_once 'eblib/linkedin.php';
require_once 'eblib/misc.php';

$conf = get_config("auth/elcentra");

$linkedinConfig = array(
		"app_id"=>$conf->linkedinclientid,
		"app_secret"=>$conf->linkedinclientsecret,
		"base_url"=>$conf->linkedin_base_url,
		"token_access_url"=>$conf->linkedin_token_access_url,
		"retrieval_url"=>$conf->linkedin_retrieval_url,
		"scope"=>$conf->linkedin_scope
		);

if($linkedinConfig['app_id']=="" || $linkedinConfig['app_secret']=="") {
	throw new moodle_exception("Linkedin login is not configured. Contact admin");
}

$linkedinObject = new EbuildersLinkedin();
$linkedinObject->setConfig($linkedinConfig);
$linkedinObject->sendAccessRequest();