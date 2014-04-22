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

defined('MOODLE_INTERNAL') || die();

require_once($CFG->libdir.'/authlib.php');

/**
 * Plugin for no authentication.
 * @global moodle_page $PAGE
 * @global bootstrap_renderer $OUTPUT
 */
class auth_plugin_elcentra extends auth_plugin_base {

    /**
     * Constructor.
     */
    function auth_plugin_elcentra() {
        $this->authtype = 'elcentra';
        $this->config = get_config('auth/elcentra');
    }

    /**
     * Returns true if the username and password work or don't exist and false
     * if the user exists and the password is wrong.
     *
     * @param string $username The username
     * @param string $password The password
     * @return bool Authentication success or failure.
     */
    function user_login ($username, $password) {
        global $CFG, $DB, $SESSION;
        if ($user = $DB->get_record('user', array('username'=>$username, 'mnethostid'=>$CFG->mnet_localhost_id))) {
            if($user->auth != "elcentra") 
            	return false;
            
            if(isset($SESSION->elcentra_login_username) && $SESSION->elcentra_login_username==$username) {
            	unset($SESSION->elcentra_login_username);
            	return true;
            } else if(isset($SESSION->elcentra_login_username)) {
            	unset($SESSION->elcentra_login_username);
            }
            return false;
        }
        
        return false;
    }

    /**
     * Updates the user's password.
     *
     * called when the user password is updated.
     *
     * @param  object  $user        User table object
     * @param  string  $newpassword Plaintext password
     * @return boolean result
     *
     */
    /* function user_update_password($user, $newpassword) {
        $user = get_complete_user_data('id', $user->id);
        // This will also update the stored hash to the latest algorithm
        // if the existing hash is using an out-of-date algorithm (or the
        // legacy md5 algorithm).
        return update_internal_user_password($user, $newpassword);
    } */

    function prevent_local_passwords() {
        return false;
    }

    /**
     * Returns true if this authentication plugin is 'internal'.
     *
     * @return bool
     */
    function is_internal() {
        return false;
    }

    /**
     * Returns true if this authentication plugin can change the user's
     * password.
     *
     * @return bool
     */
    function can_change_password() {
        return false;
    }

    /**
     * Returns the URL for changing the user's pw, or empty if the default can
     * be used.
     *
     * @return moodle_url
     */
    function change_password_url() {
        return null;
    }

    /**
     * Returns true if plugin allows resetting of internal password.
     *
     * @return bool
     */
    function can_reset_password() {
        return false;
    }

    /**
     * Prints a form for configuring this authentication plugin.
     *
     * This function is called from admin/auth.php, and outputs a full page with
     * a form for configuring this plugin.
     *
     * @param array $page An object containing all the data for this page.
     */
    function config_form($config, $err, $user_fields) {
    	global $OUTPUT;
    	
    	if (!isset($config->googleclientid)) {
    		$config->googleclientid = '';
    	}
    	if (!isset($config->googleclientsecret)) {
    		$config->googleclientsecret = '';
    	}
    	if (!isset ($config->facebookclientid)) {
    		$config->facebookclientid = '';
    	}
    	if (!isset ($config->facebookclientsecret)) {
    		$config->facebookclientsecret = '';
    	}
    	if (!isset ($config->linkedinclientid)) {
    		$config->linkedinclientid = '';
    	}
    	if (!isset ($config->linkedinclientsecret)) {
    		$config->linkedinclientsecret = '';
    	}
    	if (!isset($config->twitterclientid)) {
    		$config->twitterclientid = '';
    	}
    	if (!isset($config->twitterclientsecret)) {
    		$config->twitterclientsecret = '';
    	}
    	if (!isset($config->vkclientsecret)) {
    		$config->vkclientsecret = '';
    	}
        if (!isset($config->add_code_mode)) {
            $config->add_code_mode = 'auto';
        }

        include "config.php";
    }

    /**
     * Processes and stores configuration data for this authentication plugin.
     */
    function process_config($config) {
    	
    	if (!isset($config->googleclientid)) {
    		$config->googleclientid = '';
    	}
    	if (!isset($config->googleclientsecret)) {
    		$config->googleclientsecret = '';
    	}
    	if (!isset ($config->facebookclientid)) {
    		$config->facebookclientid = '';
    	}
    	if (!isset ($config->facebookclientsecret)) {
    		$config->facebookclientsecret = '';
    	}
    	if (!isset ($config->linkedinclientid)) {
    		$config->linkedinclientid = '';
    	}
    	if (!isset ($config->linkedinclientsecret)) {
    		$config->linkedinclientsecret = '';
    	}
    	if (!isset($config->twitterclientid)) {
    		$config->twitterclientid = '';
    	}
    	if (!isset($config->vkclientid)) {
    		$config->twitterclientid = '';
    	}
        if (!isset($config->add_code_mode)) {
            $config->add_code_mode = 'auto';
        }
    	
    	set_config('googleclientid',    $config->googleclientid,    'auth/elcentra');
    	set_config('googleclientsecret',    $config->googleclientsecret,    'auth/elcentra');
    	set_config('facebookclientid',    $config->facebookclientid,    'auth/elcentra');
    	set_config('facebookclientsecret',    $config->facebookclientsecret,    'auth/elcentra');
    	set_config('linkedinclientid',    $config->linkedinclientid,    'auth/elcentra');
    	set_config('linkedinclientsecret',    $config->linkedinclientsecret,    'auth/elcentra');
    	set_config('twitterclientid',    $config->twitterclientid,    'auth/elcentra');
        set_config('twitterclientsecret',    $config->twitterclientsecret,    'auth/elcentra');
        set_config('vkclientid',    $config->vkclientid,    'auth/elcentra');
        set_config('vkclientsecret',    $config->vkclientsecret,    'auth/elcentra');
        set_config('add_code_mode',    $config->add_code_mode,    'auth/elcentra');
        return true;
    }
    
    /**
     * Hook for overriding behaviour of login page.
     *  */
    function loginpage_hook() {
        global $PAGE, $OUTPUT, $CFG;
        $conf = get_config("auth/elcentra", "add_code_mode");
        if ($conf == "auto") {
            $PAGE->requires->jquery();
            $PAGE->requires->js_init_code("buttonsAddMethod = 'auto';");
            $content = str_replace(array("\n", "\r"), array("\\\n", "\\\r",), $this->get_buttons_string());
            $PAGE->requires->js_init_code("buttonsCode = '$content';");
            $PAGE->requires->js(new moodle_url($CFG->wwwroot . "/auth/elcentra/script.js"));
        }
    }
    
    /**
     * To Process the response from all the social nerworks to login / signup
     */
    function elcentraProcessResponse($details) {
    	global $DB, $CFG, $USER, $SESSION;
    	
    	list($username, $email, $firstName, $lastName, $country, $city, $timezone, $verified) = $details;
    	
    	//throw an error if the email address is not verified
    	if (!$verified) {
    		throw new moodle_exception('emailaddressmustbeverified', 'auth_elcentra');
    	}
    	 
    	// Prohibit login if email belongs to the prohibited domain
    	if ($err = email_is_not_allowed($email)) {
    		throw new moodle_exception($err);
    	}
    	
    	$userDetails = $DB->get_record('user', array('username' => $username,
    			'mnethostid' => $CFG->mnet_localhost_id));
    	
    	if (empty($userDetails)) {
    		$userDetails = new stdClass();
    		$userDetails->username = $username;
    		$userDetails->email = $email;
    		$userDetails->firstname = $firstName;
    		$userDetails->lastname = $lastName;
    		$userDetails->country = $country;
    		$userDetails->city = $city;
    		if($timezone!="")
    			$userDetails->timezone = $timezone;
    		
    		$savedRecord = create_user_record($username, '', "elcentra");
    		$userDetails->id = $savedRecord->id;
    		$DB->update_record("user", $userDetails, FALSE);
    	}
    	
    	$SESSION->elcentra_login_username = $username;
    	complete_user_login(authenticate_user_login($username, ''));

    	if (user_not_fully_set_up($USER)) {
    		$urltogo = $CFG->wwwroot.'/user/edit.php';
    		// We don't delete $SESSION->wantsurl yet, so we get there later
    	} else if (isset($SESSION->wantsurl) and (strpos($SESSION->wantsurl, $CFG->wwwroot) === 0)) {
    		$urltogo = $SESSION->wantsurl;    // Because it's an address in this site
    		unset($SESSION->wantsurl);
    	} else {
    		// No wantsurl stored or external - go to homepage
    		$urltogo = $CFG->wwwroot.'/';
    		unset($SESSION->wantsurl);
    	}
    	redirect($urltogo);
    	
    }

    private function get_buttons_string() {
        global $CFG;
        $content = <<<HTML
 	<!-- Elcentra content starts -->
 	<div class="moreproviderlink">
 	<a href="{$CFG->wwwroot}/auth/elcentra/google_request.php"><img src="{$CFG->wwwroot}/auth/elcentra/img/google.png"></a> <br>
 	<a href="{$CFG->wwwroot}/auth/elcentra/facebook_request.php"><img src="{$CFG->wwwroot}/auth/elcentra/img/facebook.png"></a> <br>
 	<a href="{$CFG->wwwroot}/auth/elcentra/twitter_request.php"><img src="{$CFG->wwwroot}/auth/elcentra/img/twitter.png"></a> <br>
 	<a href="{$CFG->wwwroot}/auth/elcentra/linkedin_request.php"><img src="{$CFG->wwwroot}/auth/elcentra/img/linkedin.png"></a> <br>
 	<a href="{$CFG->wwwroot}/auth/elcentra/vk_request.php"><img src="{$CFG->wwwroot}/auth/elcentra/img/vk.png"></a>
 	</div>
 	<!-- Elcentra content ends -->
HTML;
        return $content;
    }

}


