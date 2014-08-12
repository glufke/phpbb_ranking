<?php

//Only modify the following variables
$rank_host     = 'localhost';
$rank_user     = 'nameOfTheUser';
$rank_password = 'yourPassword';
$rank_dbname   = 'databaseName';


//Connect the user
$rank_connection = mysql_connect( $rank_host, $rank_user , $rank_password ) 
or die ("Unable toconnect! Contact $def_contact");

//select the database
mysql_select_db($rank_dbname) 
 or die ("Unable to select database! Contact $def_contact");

?>
