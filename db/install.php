<?php

function xmldb_auth_elcentra_install() {
    global $CFG, $DB;
    
    //Facebook
    set_config("facebook_base_url", "https://www.facebook.com/dialog/oauth?", 'auth/elcentra');
    set_config("facebook_token_access_url", "https://graph.facebook.com/oauth/access_token?", 'auth/elcentra');
    set_config("facebook_retrieval_url", "https://graph.facebook.com/me?", 'auth/elcentra');
    set_config("facebook_scope", "email", 'auth/elcentra');
    set_config("facebookclientid", "", 'auth/elcentra');
    set_config("facebookclientsecret", "", 'auth/elcentra');
    
    //Twitter
    set_config("twitter_authorize_url", "https://api.twitter.com/oauth/authenticate", 'auth/elcentra');
    set_config("twitter_token_access_url", "https://api.twitter.com/oauth/access_token", 'auth/elcentra');
    set_config("twitter_token_request_url", "https://api.twitter.com/oauth/request_token", 'auth/elcentra');
    set_config("twitterclientid", "", 'auth/elcentra');
    set_config("twitterclientsecret", "", 'auth/elcentra');
    
    //Linkedin
    set_config("linkedin_base_url", "https://www.linkedin.com/uas/oauth2/authorization?", 'auth/elcentra');
    set_config("linkedin_token_access_url", "https://www.linkedin.com/uas/oauth2/accessToken?", 'auth/elcentra');
    set_config("linkedin_retrieval_url", "https://api.linkedin.com/v1/people/~:(id,first-name,last-name,location:(country:(code)),email-address)?", 'auth/elcentra');
    set_config("linkedin_scope", "r_basicprofile%20r_emailaddress", 'auth/elcentra');
    set_config("linkedinclientid", "", 'auth/elcentra');
    set_config("linkedinclientsecret", "", 'auth/elcentra');
    
    //Google
    set_config("google_base_url", "https://accounts.google.com/o/oauth2/auth?", 'auth/elcentra');
    set_config("google_token_access_url", "https://accounts.google.com/o/oauth2/token", 'auth/elcentra');
    set_config("google_retrieval_url", "https://www.googleapis.com/oauth2/v1/userinfo?", 'auth/elcentra');
    set_config("google_scope", "https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.email+https%3A%2F%2Fwww.googleapis.com%2Fauth%2Fuserinfo.profile", 'auth/elcentra');
    set_config("googleclientid", "", 'auth/elcentra');
    set_config("googleclientsecret", "", 'auth/elcentra');
    
}
