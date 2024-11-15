<?php

// List the currently used names on our BlueSky domain

require('../config.php') ;
require('auth.php') ;

$db = new SQLite3('did-map.sqlite3', SQLITE3_OPEN_READONLY) ;

$users = $db->query('SELECT user FROM usermap ORDER BY user') ;

?>
<html>

<head>
	<title>Currently registered users for <?php echo BSKY_DOMAIN ; ?></title>
</head>

<body>
	<h1>The follow users are currently registered for <?php echo BSKY_DOMAIN ; ?></h1>
	<p><b>You cannot use one of the names that has already been registered.</b> Click on a name
		to see the profile on BlueSky.</p>
	<?php
		while ($record = $users->fetchArray()) {
			echo '<p><a target="_blank" href="https://bsky.app/profile/' . $record['user'] . '">' . $record['user'] . ' </p>' ;
		} ?>
	<p><a href="register.php">Create a user</a> - <a href="index.php">Home</a></p>
</body>
<?php

$db->close() ;
