<?php

// this is a simple authentication plugin; use at your own risk
// An alternative would be to use a .htaccess file to protect the
// admin folder, or add some code to link to an existing authentication
// system

require 'config.php' ;

function sorry()
{
	print "<html><head><title>Sorry... invalid credentials</title></head><body>Sorry, we were unable to log you in</body></html>" ;
}

$authenticated = (($_SERVER['PHP_AUTH_PW'] == ADMIN_PASSWORD) && ($_SERVER['PHP_AUTH_USER'] == BSKY_DOMAIN)) ;

if (! $authenticated) {
	header('WWW-Authenticate: Basic realm="' . BSKY_DOMAIN . '"');
	header('HTTP/1.0 401 Unauthorized');
	sorry() ;
	exit ;
}
