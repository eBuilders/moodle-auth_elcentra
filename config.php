<!-- No config needed -->
<?php global $CFG; ?>
<title> <?php print_string('title','auth_elcentra');?> </title>
<div style="text-align: center"><?php print_string('pluginname', 'auth_elcentra'); ?></div>

<table cellspacing="0" cellpadding="5" border="0">
<tr>
<td align="" colspan="3">
<div class="box informationbox">
<div class="moreproviderlink">
	<span style="font-weight: bold;"><?php print_string("copytext", "auth_elcentra"); ?></span><br /><br />
	<span style="font-size: 10px">
	<?php $content = <<<HTML
 	<!-- Elcentra content starts -->
 	<center>
 	<div class="moreproviderlink">
 	<a href="<?php echo $CFG->wwwroot ?>/auth/elcentra/google_request.php"><img src="<?php echo $CFG->wwwroot ?>/auth/elcentra/img/google.png"></a> <br>
 	<a href="<?php echo $CFG->wwwroot ?>/auth/elcentra/facebook_request.php"><img src="<?php echo $CFG->wwwroot ?>/auth/elcentra/img/facebook.png"></a> <br> 
 	<a href="<?php echo $CFG->wwwroot ?>/auth/elcentra/twitter_request.php"><img src="<?php echo $CFG->wwwroot ?>/auth/elcentra/img/twitter.png"></a> <br>
 	<a href="<?php echo $CFG->wwwroot ?>/auth/elcentra/linkedin_request.php"><img src="<?php echo $CFG->wwwroot ?>/auth/elcentra/img/linkedin.png"></a>
 	</div>
 	</center>
 	<!-- Elcentra content ends -->
HTML;
	echo nl2br(htmlspecialchars($content)); 
 	?>
 	</span>
</div>
</div>
</td>	
</tr>
<tr>
<td align="" colspan="3">
<div class="box informationbox">
<?php
	echo "<center><b>";
	print_string('googleclient_title','auth_elcentra');
	echo "</b></center><br>";
	print_string('googleclient_redirecturl','auth_elcentra');
	echo $CFG->wwwroot."/auth/elcentra/google_response.php";
	echo "<br>";
	print_string('googleclient_appurl','auth_elcentra');
?>
<a href="https://code.google.com/apis/console/" target="_blank">https://code.google.com/apis/console/</a>
</div>
</td>	
</tr>
<tr>
	<td align="right"><label for="googleclientid"><?php print_string('googleclientid_text', 'auth_elcentra') ?>: </label></td>
    <td>
        <input name="googleclientid" id="googleclientid" type="text" size="30" value="<?php echo $config->googleclientid ?>" />
        <?php

        if (isset($err['googleclientid'])) {
            echo $OUTPUT->error_text($err['googleclientid']);
        }

        ?>
    </td>
    <td>
        <?php

        print_string('googleclientid_description', 'auth_elcentra');

        ?>
    </td>
</tr>

<tr>
	<td align="right"><label for="googleclientsecret"><?php print_string('googleclientsecret_text', 'auth_elcentra') ?>: </label></td>
    <td>
        <input name="googleclientsecret" id="googleclientsecret" type="text" size="30" value="<?php echo $config->googleclientsecret ?>" />
        <?php

        if (isset($err['googleclientsecret'])) {
            echo $OUTPUT->error_text($err['googleclientsecret']);
        }

        ?>
    </td>
    <td>
        <?php

        print_string('googleclientsecret_description', 'auth_elcentra');

        ?>
    </td>
</tr>
<tr>
<td align="" colspan="3">
<div class="box informationbox">
<?php
	echo "<center><b>";
	print_string('facebookclient_title','auth_elcentra');
	echo "</b></center><br>";
	print_string('facebookclient_redirecturl','auth_elcentra');
	echo $CFG->wwwroot."/auth/elcentra/facebook_response.php";
	echo "<br>";
	print_string('facebookclient_appurl','auth_elcentra');
?>
<a href="https://developers.facebook.com/apps" target="_blank">https://developers.facebook.com/apps</a>
</div>
</td>	
</tr>
<tr>
	<td align="right"><label for="facebookclientid"><?php print_string('facebookclientid_text', 'auth_elcentra') ?>: </label></td>
    <td>
        <input name="facebookclientid" id="facebookclientid" type="text" size="30" value="<?php echo $config->facebookclientid ?>" />
        <?php

        if (isset($err['facebookclientid'])) {
            echo $OUTPUT->error_text($err['facebookclientid']);
        }

        ?>
    </td>
    <td>
        <?php

        print_string('facebookclientid_description', 'auth_elcentra');

        ?>
    </td>
</tr>
<tr>
	<td align="right"><label for="facebookclientsecret"><?php print_string('facebookclientsecret_text', 'auth_elcentra') ?>: </label></td>
    <td>
        <input name="facebookclientsecret" id="facebookclientsecret" type="text" size="30" value="<?php echo $config->facebookclientsecret ?>" />
        <?php

        if (isset($err['facebookclientsecret'])) {
            echo $OUTPUT->error_text($err['facebookclientsecret']);
        }

        ?>
    </td>
    <td>
        <?php

        print_string('facebookclientsecret_description', 'auth_elcentra');

        ?>
    </td>
</tr>
<tr>
<td align="" colspan="3">
<div class="box informationbox">
<?php
	echo "<center><b>";
	print_string('linkedinclient_title','auth_elcentra');
	echo "</b></center><br>";
	print_string('linkedinclient_redirecturl','auth_elcentra');
	echo $CFG->wwwroot."/auth/elcentra/linkedin_response.php";
	echo "<br>";
	print_string('linkedinclient_appurl','auth_elcentra');
?>
<a href="https://www.linkedin.com/secure/developer?_mSplash=1">https://www.linkedin.com/secure/developer?_mSplash=1</a>
</div>
</td>	
</tr>
<tr>
	<td align="right"><label for="linkedinclientid"><?php print_string('linkedinclientid_text', 'auth_elcentra') ?>: </label></td>
    <td>
        <input name="linkedinclientid" id="host" type="text" size="30" value="<?php echo $config->linkedinclientid ?>" />
        <?php

        if (isset($err['linkedinclientid'])) {
            echo $OUTPUT->error_text($err['linkedinclientid']);
        }

        ?>
    </td>
    <td>
        <?php

        print_string('linkedinclientid_description', 'auth_elcentra');

        ?>
    </td>
</tr>

<tr>
	<td align="right"><label for="linkedinclientsecret"><?php print_string('linkedinclientsecret_text', 'auth_elcentra') ?>: </label></td>
    <td>
        <input name="linkedinclientsecret" id="linkedinclientsecret" type="text" size="30" value="<?php echo $config->linkedinclientsecret ?>" />
        <?php

        if (isset($err['linkedinclientsecret'])) {
            echo $OUTPUT->error_text($err['linkedinclientsecret']);
        }

        ?>
    </td>
    <td>
        <?php

        print_string('linkedinclientsecret_description', 'auth_elcentra');

        ?>
    </td>
</tr>
<tr>
<td align="" colspan="3">
<div class="box informationbox">
<?php
	echo "<center><b>";
	print_string('twitterclient_title','auth_elcentra');
	echo "</b></center><br>";
	print_string('twitterclient_redirecturl','auth_elcentra');
	echo $CFG->wwwroot."/auth/elcentra/twitter_response.php";
	echo "<br>";
	print_string('twitterclient_appurl','auth_elcentra');
?>
<a href="https://dev.twitter.com/apps/new" target="_blank">https://dev.twitter.com/apps/new</a>
</div>
</td>	
</tr>
<tr>
	<td align="right"><label for="twitterclientid"><?php print_string('twitterclientid_text', 'auth_elcentra') ?>: </label></td>
    <td>
        <input name="twitterclientid" id="twitterclientid" type="text" size="30" value="<?php echo $config->twitterclientid ?>" />
        <?php

        if (isset($err['twitterclientid'])) {
            echo $OUTPUT->error_text($err['twitterclientid']);
        }

        ?>
    </td>
    <td>
        <?php

        print_string('twitterclientid_description', 'auth_elcentra');

        ?>
    </td>
</tr>
<tr>
	<td align="right"><label for="twitterclientsecret"><?php print_string('twitterclientsecret_text', 'auth_elcentra') ?>: </label></td>
    <td>
        <input name="twitterclientsecret" id="twitterclientsecret" type="text" size="30" value="<?php echo $config->twitterclientsecret ?>" />
        <?php

        if (isset($err['twitterclientsecret'])) {
            echo $OUTPUT->error_text($err['twitterclientsecret']);
        }

        ?>
    </td>
    <td>
        <?php

        print_string('twitterclientsecret_description', 'auth_elcentra');

        ?>
    </td>
</tr>
<tr>
    <td align="" colspan="3">
        <div class="box informationbox">
            <?php
            echo "<center><b>";
            print_string('add_code_mode_title','auth_elcentra');
            echo "</b></center><br>";
            print_string('add_code_mode_notes','auth_elcentra');
            ?>
        </div>
    </td>
</tr>
<tr>
    <td align="right"><label><?php print_string('add_code_mode_text', 'auth_elcentra') ?>: </label></td>
    <td>
        <label for="add_code_mode_auto"><?php echo print_string('add_code_mode_auto_text', 'auth_elcentra'); ?></label>: <input name="add_code_mode" id="add_code_mode_auto" type="radio" value="auto" <?php echo ($config->add_code_mode=="auto")?'checked="checked"':''; ?> />
        <label for="add_code_mode_manual"><?php echo print_string('add_code_mode_manual_text', 'auth_elcentra'); ?></label>: <input name="add_code_mode" id="add_code_mode_manual" type="radio" value="manual" <?php echo ($config->add_code_mode=="manual")?'checked="checked"':''; ?> />
        <?php

        if (isset($err['add_code_mode'])) {
            echo $OUTPUT->error_text($err['add_code_mode']);
        }

        ?>
    </td>
    <td>
        <?php

        print_string('add_code_mode_description', 'auth_elcentra');

        ?>
    </td>
</tr>
<?php

print_auth_lock_options($this->authtype, $user_fields, get_string('auth_fieldlocks_help', 'auth'), false, false);

?>
</table>
