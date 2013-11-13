<?php
require('../../config.php');
require_once 'eblib/twitter.php';
require_once 'eblib/misc.php';
error_reporting(E_ALL);

$conf = get_config("auth/elcentra");

$twitterConfig = array(
		"consumer_key"=>$conf->twitterclientid,
		"consumer_secret"=>$conf->twitterclientsecret,
		"authorize_url"=>$conf->twitter_authorize_url,
		"token_access_url"=>$conf->twitter_token_access_url,
		"token_request_url"=>$conf->twitter_token_request_url,
);

if($twitterConfig['consumer_key']=="" || $twitterConfig['consumer_secret']=="") {
	throw new moodle_exception("Twitter login is not configured. Contact admin");
}

$twitterObject = new EbuildersTwitter();
$twitterObject->setConfig($twitterConfig);
$twitterObject->sendAccessRequest();