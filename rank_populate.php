<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

//Start connection and definitions
include('rank_definitions.php');
include('rank_connection.php');

mysql_query("SET NAMES 'utf8'");
mysql_query('SET character_set_connection=utf8');
mysql_query('SET character_set_client=utf8');
mysql_query('SET character_set_results=utf8');


//Fetch all periods
$qperiod = mysql_query("
SELECT DISTINCT FROM_UNIXTIME( post_time, '$period_format') period 
FROM phpbb_posts
ORDER BY 1"
)  or die ("Error in qperiod: $qperiod. " .mysql_error());

while( $rperiod = mysql_fetch_object($qperiod))
{
    //Populate the table
    echo 'Populating period '.$rperiod->period.'<br>';

    
    $q1 =mysql_query("SET @ANO    =".$rperiod->period.";")                     or die ("Error in q1: $q1. " .mysql_error());
    $q2 =mysql_query("SET @CURROW1=0;")                                        or die ("Error in q2: $q2. " .mysql_error());
    $q3 =mysql_query("SET @CURROW2=0;")                                        or die ("Error in q3: $q3. " .mysql_error());
    $q4 =mysql_query("DELETE FROM rank WHERE period = ".$rperiod->period.";")  or die ("Error in q4: $q4. " .mysql_error());
    
    $qinsert = mysql_query("
INSERT INTO rank(period, user_id, username, pos_before, pos_now, increase, qtd_before, qtd_now) 
			SELECT
                          @ANO
, usu.user_id                        
, usu.username
			
                        , NULL
                        , NULL
                        , NULL
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

ORDER BY b.qtd DESC, UPPER(b.username)


" )  or die ("Error in qinsert: $qinsert. " .mysql_error());
    
   
    
    $q5 =mysql_query("SET @CURROW1=0;")                                        or die ("Error in q2: $q2. " .mysql_error());
    $q6 =mysql_query("SET @CURROW2=0;")                                        or die ("Error in q2: $q2. " .mysql_error());
    
$u1 =mysql_query("
UPDATE rank y
SET y.pos_now = (
SELECT
r1.rank
FROM (
                
SELECT N1.*
, @CURROW1 := @CURROW1 + 1 AS RANK
FROM (
  SELECT DISTINCT qtd_now as qtd1
  FROM `rank` 
  WHERE period=@ANO
  ORDER BY qtd_now DESC
  ) N1   
 
) r1
where COALESCE(r1.qtd1,999999) = COALESCE(y.qtd_now,999999)
)

,

y.pos_before = (
SELECT
r1.rank
FROM (
                
SELECT N1.*
, @CURROW2 := @CURROW2 + 1 AS RANK
FROM (
  SELECT DISTINCT qtd_before as qtd1
  FROM `rank` 
  WHERE period=@ANO
  ORDER BY qtd_before DESC
  ) N1   
 
) r1
where COALESCE(r1.qtd1,999999) = COALESCE(y.qtd_before,999999)
)



WHERE y.period = @ANO
    
    
    
")                                        or die ("Error in u1: $u1. " .mysql_error());    
    


$u1 =mysql_query("
UPDATE rank y
SET y.increase =  y.pos_before - y.pos_now 
WHERE period = @ANO")
or die ("Error in u1: $u1. " .mysql_error());    


    
}




                 















?>