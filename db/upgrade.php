<?php
/**
 * Created by PhpStorm.
 * User: Skandha
 * Date: 4/26/14
 * Time: 10:00 PM
 */

function xmldb_auth_elcentra_upgrade($oldversion) {
    if ($oldversion <= 2014012100){
        set_config("vk_base_url", "https://oauth.vk.com/authorize?", 'auth/elcentra');
        set_config("vk_token_access_url", "https://oauth.vk.com/access_token?", 'auth/elcentra');
        set_config("vk_retrieval_url", "https://api.vk.com/method/getProfiles?fields=country,city,timezone,verified", 'auth/elcentra');
        set_config("vk_scope", "friends", 'auth/elcentra');
        set_config("vkclientid", "", 'auth/elcentra');
        set_config("vkclientsecret", "", 'auth/elcentra');
    }

    return true;
}
