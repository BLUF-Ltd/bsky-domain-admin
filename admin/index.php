<?php
require('config.php') ;
require('auth.php') ;

// make sure the database exists
$db = new SQLite3('did-map.sqlite3', SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE) ;
$db->exec('CREATE TABLE IF NOT EXISTS usermap ( user TEXT, did TEXT )') ;
$db->close() ;
?>
<html>

<head>
	<title>Manage BlueSky users for <?php echo BSKY_DOMAIN ; ?></title>
</head>

<body>
	<h1>What do you want to do?</h1>
	<p>You can create a new user, or view current users, for the domain <?php echo BSKY_DOMAIN ; ?></p>
	<p><a href="list.php">List current users</a></p>
	<p><a href="register.php">Register a new user</a></p>
</body>

</html>
