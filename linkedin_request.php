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