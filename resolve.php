<?php

// Nigel Whitfield, November 2024
// DID resolver for the AT protocol
// To allow custom domain names to be used on the BlueSky network
//

$db = new SQLite3('admin/did-map.sqlite3', SQLITE3_OPEN_READONLY) ;

$result = $db->querySingle('SELECT did FROM usermap WHERE user = "' . $_SERVER['SERVER_NAME'] . '"');

if ($result == null) {
	http_response_code(404) ;
} else {
	print $result ;
}

$db->close() ;
