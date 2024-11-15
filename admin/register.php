<?php

// Create a new user entry in the table, for our custom domain

require('../config.php') ;
require('auth.php') ;

// make sure the database exists
$db = new SQLite3('did-map.sqlite3', SQLITE3_OPEN_READWRITE | SQLITE3_OPEN_CREATE) ;
$db->exec('CREATE TABLE IF NOT EXISTS usermap ( user TEXT, did TEXT )') ;

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
	// form has been submitted
	if (! preg_match('/' . BSKY_DOMAIN . '/', $_REQUEST['handle'])) {
		$db->close() ;
		error_page('You must enter a name ending ' . BSKY_DOMAIN) ;
		exit ;
	}

	$handle = trim(strtolower($_REQUEST['handle'])) ;

	if (substr($handle, 0, 1) == '@') {
		// user entered name with a leading @
		$handle = substr($handle, 1) ;
	}

	$did = trim($_REQUEST['did']) ;

	$register = $db->prepare("INSERT INTO usermap VALUES ( :u, :d )") ;
	$register->bindParam(':u', $handle, SQLITE3_TEXT) ;
	$register->bindParam(':d', $did, SQLITE3_TEXT) ;

	$ok = $register->execute() ;

	$db->close() ;

	if ($ok === false) {
		error_page('Sorry, there was a problem updating the database') ;
		exit ;
	} else {
		?>
<html>

<head>
	<title><?php echo BSKY_DOMAIN ; ?> has been updated</title>
</head>

<body>
	<h1>Success!</h1>
	<p>We have updated the database, so now all you need to do to use your custom domain <?= $handle; ?> is to
		return to the BlueSky window and click the button marked <b>Verify Text File</b>. You should see a green note
		saying Domain verified, and then you just need to click <b>Update to <?= $handle; ?></b></p>
	<img src="bsfinal.png" title="Final stage of the BlueSky username change" alt="Final stage of the BlueSky username change">
	<p>Once that has been done, in a few seconds you will be visible on BlueSky with the new custom domain, and you can close this window.</p>
	</p>
</body>

</html>
<?php
	}
} else {
	// show the form, and the instructions?>
<html>

<head>
	<title>Adding a username to <?php echo BSKY_DOMAIN ; ?></title>
</head>

<body>
	<h1>Adding a username to <?php echo BSKY_DOMAIN ; ?></h1>
	<p>You are about to create a custom <a href="https://bsky.app">BlueSky</a> handle. Remember that this will change your handle on
		BlueSky to use our custom domain <b><?php echo BSKY_DOMAIN ; ?></b>. This will let other people know your account is associated with
		us. You should probably not be doing this for an account that will primarily be used for personal posts!</p>
	<!-- some of you might want to put scary HR language here, or something like that -->
	<h2>How to set up your custom BlueSky handle</h2>
	<p>Follow these instructions carefully. It will help if you have two windows open, one for this site, and one for the BlueSky
		settings. You can open them <a href="https://bsky.app/settings" target="_blank">in a new tab here</a>.</p>
	<p>In the BlueSky settings, scroll down the middle pane, and find the Advanced heading, then click on the text that says
		<b>Change Handle</b>. You will see a pop-up appear, like this:
	</p>
	<img src="bspop1.png" title="BlueSky change handle dialog, step 1" alt="BlueSky change handle dialog, step 1">
	<p>Click on the text that says <b>I have my own domain</b>, and the pop-up will resize, with lots more options. It will now look something
		like this (we've blanked out the id):</p>
	<img src="bspop2.png" title="BlueSky change handle dialog, step 2" alt="BlueSky change handle dialog, step 2">
	<p>Now, click on the section labelled <b>No DNS Panel</b> and the box will change to look like this:</p>
	<img src="bspop3.png" title="BlueSky change handle dialog, step 3" alt="BlueSky change handle dialog, step 3">
	<p>This is where we do the actual work of changing your name so that it ends with <?php echo BSKY_DOMAIN ; ?>. First, in the box at the
		top, enter the domain you want to use, such as <b>sample.<?php echo BSKY_DOMAIN ; ?></b>.</p>
	<form action="register.php" method="post">
		<p>Now, enter the same name in this box: <input type="text" name="handle" width="35"></p>
		<p>Next, click the button labelled <b>Copy File Contents</b> in the box on BlueSky.</p>
		<p>Then paste the information into this box: <input type="text" name="did" with="35"></p>
		<p>Check the information is correct; you won't be able to change this later yourself. When you're sure it's ok, click the <b>Save</b>
			button on this page <em>before</em> clicking anything on BlueSky. Wait until you see the confirmation message appear here,
			and then on BlueSky click <b>Verify Text File</b>. If all is well, your new BlueSky handle will be active.</p>
		<input type="submit" value="Save">
	</form>
</body>

</html>
<?php
}

function error_page($text)
{
	?>
<html>

<head>
	<title>Sorry, there was an error</title>
</head>

<body>
	<h1>Sorry, something went wrong</h1>
	<p>We couldn't complete your request</p>
	<p><?= $text; ?></p>
</body>

</html>
<?php
}
