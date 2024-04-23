<?php

define( 'DB_USER', 'testuser' );
define( 'DB_PASSWORD', 'testpass');
define( 'DB_HOST', 'localhost' );
define( 'DB_NAME', 'testuser_citpt227week4');

$dbc = mysqli_connect( DB_HOST, DB_USER, DB_PASSWORD, DB_NAME) or die("Could not connect to MySQL");
// print_r($dbc); // testing to see if it works!

?>