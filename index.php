<?php

// This is just a simple redirect, to send people to our main website.
// Maybe later, we'll have a directory of all our social feeds here

require('admin/config.php') ;

header('Location: ' . REDIRECT_TO) ;
