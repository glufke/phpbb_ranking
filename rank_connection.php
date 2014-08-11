<?php

//Only modify the following variables
$host     = 'localhost';
$user     = 'nameOfTheUser';
$password = 'yourPassword';
$dbname   = 'databaseName';


//Connect the user
$connection = mysql_connect( $host, $user , $password ) 
or die ("Unable toconnect! Contact $def_contact");

//select the database
mysql_select_db($dbname) 
 or die ("Unable to select database! Contact $def_contact");

?>
