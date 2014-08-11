<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Start connection
include('rank_connection.php');
include('rank_definitions.php');

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');


//Fetch all periods
$qperiod = mysql_query("
SELECT DISTINCT FROM_UNIXTIME( post_time, '$period_format') period 
FROM phpbb_posts
ORDER BY 1"
)  or die ("Error in query2: $qperiod. " .mysql_error());

while( $rperiod = mysql_fetch_object($qperiod))
{
    //Populate the table
    echo 'Populating period '.$rperiod->period.'<br>';
    
    
    
  /*
SET @ANO    =2006;
SET @CURROW1=0;
SET @CURROW2=0;



SELECT
  X4.user_id
, X4.username
, X4.row_number1 AS pos_anterior
, X4.row_number2 AS pos_atual
, row_number1 - row_number2 subiu
, X4.qtd1 AS qtd_anterior
, X4.qtd2 AS qtd_atual
FROM 
	(
	SELECT
	 X3.*
	, @CURROW2 := @CURROW2 + 1 AS row_number2
	FROM
		(
		SELECT
		 X2.*
		FROM
			(
			  
			SELECT
			 X1.*
			, @CURROW1 := @CURROW1 + 1 AS row_number1
			FROM
			(
			SELECT usu.username
			, usu.user_id
			, a.qtd AS qtd1
			, b.qtd AS qtd2
			FROM 
			  (
				SELECT
				  pu.user_id 
				, pu.username
				FROM 
				  phpbb_posts pp
				, phpbb_users pu
				WHERE pp.poster_id = pu.user_id
				  AND ( FROM_UNIXTIME(pp.post_time) LIKE CONCAT( @ANO-1, '%')
						OR
						FROM_UNIXTIME(pp.post_time) LIKE CONCAT( @ANO, '%')    
					  )
				GROUP BY pu.username, pu.user_id
				ORDER BY UPPER(pu.username)
				) usu

				LEFT JOIN


				  (	SELECT
					  pu.username
					, COUNT(pp.post_id) qtd
					FROM 
					  phpbb_posts pp
					, phpbb_users pu
					WHERE pp.poster_id = pu.user_id
					  AND FROM_UNIXTIME(pp.post_time) LIKE CONCAT(@ANO-1, '%')
					GROUP BY pu.username
					ORDER BY COUNT(pp.post_id) DESC
					) a  ON usu.username = a.username

				LEFT JOIN 
				(
					SELECT
					  pu.username
					, COUNT(pp.post_id) qtd
					FROM 
					  phpbb_posts pp
					, phpbb_users pu
					WHERE pp.poster_id = pu.user_id
					  AND FROM_UNIXTIME(pp.post_time) LIKE CONCAT(@ANO, '%')
					GROUP BY pu.username
					ORDER BY COUNT(pp.post_id) DESC
					) b ON usu.username = b.username

				ORDER BY a.qtd DESC, UPPER(b.username)
				) X1
			) X2
			ORDER BY qtd2 DESC, UPPER(username)
		) X3
	) X4   
   */  
    
    
    
    
    
    
}




                 















?>