<?php

DEFINE ('DB_USER', 'ssp');
DEFINE ('DB_PASSWORD', 'YOURPASSWORD');
DEFINE ('DB_HOST', 'localhost');
DEFINE ('DB_NAME', 'ssp');

$dbc = @mysqli_connect(DB_HOST, DB_USER, DB_PASSWORD, DB_NAME)
OR die ('Could not connect to MySQL ' .
		 mysqli_connect_error());



?>