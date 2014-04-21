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
require_once 'eblib/vk.php';
require_once 'eblib/misc.php';

$conf = get_config("auth/elcentra");
$vkConfig = array(
		"app_id"=>$conf->vkclientid,
		"app_secret"=>$conf->vkclientsecret,
		"base_url"=>$conf->vk_base_url,
		"token_access_url"=>$conf->vk_token_access_url,
		"retrieval_url"=>$conf->vk_retrieval_url,
		"scope"=>$conf->vk_scope
		);


if($vkConfig['app_id']=="" || $vkConfig['app_secret']=="") {
	throw new moodle_exception("VK login is not configured. Contact admin");
}

$fbObject = new EbuildersVk();
$fbObject->setConfig($vkConfig);
$fbObject->sendAccessRequest();