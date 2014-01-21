<?php
// This file is part of Moodle - http://moodle.org/
//
// Moodle is free software: you can redistribute it and/or modify
// it under the terms of the GNU General Public License as published by
// the Free Software Foundation, either version 3 of the License, or
// (at your option) any later version.
//
// Moodle is distributed in the hope that it will be useful,
// but WITHOUT ANY WARRANTY; without even the implied warranty of
// MERCHANTABILITY or FITNESS FOR A PARTICULAR PURPOSE.  See the
// GNU General Public License for more details.
//
// You should have received a copy of the GNU General Public License
// along with Moodle.  If not, see <http://www.gnu.org/licenses/>.

/**
 * Strings for component 'auth_elcentra', language 'en'.
 *
 * @package   auth_elcentra
 * @copyright 2013 onwards Elcentra
 * @license   http://www.gnu.org/copyleft/gpl.html GNU GPL v3 or later
 */

require_once('../../config.php');
require_once '../../lib/pluginlib.php';
require_once 'eblib/twitter.php';
require_once 'eblib/misc.php';

$error = optional_param("denied", false, PARAM_RAW);

if($error!==false) {
	loginDenied("twitter");
}

$oauthVerifier = required_param('oauth_verifier', PARAM_RAW);
$oauthToken = required_param("oauth_token", PARAM_RAW);

global $PAGE;

$PAGE->set_url("/auth/elcentra/twitter_response.php", array("oauth_verifier"=>$oauthVerifier, "oauth_token"=>$oauthToken));

$pluginManager = plugin_manager::instance();

if(!$pluginManager->get_plugin_info("auth_elcentra", true)->is_enabled()) {
	throw new moodle_exception("Enable elcentra plugin");
}

if(isset($_SESSION['twitter_login']['oauth_token']) && ($_SESSION['twitter_login']['oauth_token']==$oauthToken)) {
	$twitter = new EbuildersTwitter();
	
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
	
	$twitter->setConfig($twitterConfig);
	$twitterReturn = $twitter->receiveResponse($oauthVerifier, $oauthToken);
// 	var_dump($twitterReturn);exit;

	$prefix = "elcentra_twitter_";
	
	$timezone = "";
	if($twitterReturn->utc_offset!=null) {
		$timezone = $twitterReturn->utc_offset/3600; 
	}

	$accountDetails = array(
			"$prefix".$twitterReturn->id, //Username
			"", //Email
			"", //First Name
			$twitterReturn->name,
			"", //Country
			"", //City
			$timezone, //Timezone
			true, //Verified
	);

	require 'auth.php';
	$elcentraPlugin = new auth_plugin_elcentra();
	$elcentraPlugin->elcentraProcessResponse($accountDetails);
}