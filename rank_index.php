<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$period = $_GET['period'];


//Start connection and definitions
include('rank_definitions.php');



//Fetch all periods
$qperiod = mysql_query("
SELECT DISTINCT period 
FROM rank
ORDER BY 1"
)  or die ("Error in qperiod: $qperiod. " .mysql_error());




?>
<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <title>TODO supply a title</title>
        <meta charset="UTF-8">
        <meta name="viewport" content="width=device-width">
    </head>
    <body>
        <form name="formrank" action="rank_index.php" method="GET">
            Period
            <select name="period">
                <?php
                  while( $rperiod = mysql_fetch_object($qperiod))
                  {
                    echo "<option";
                    if ($rperiod->period == $period ) echo " selected";
                    echo ">$rperiod->period</option>";
                  }
                ?>
                
            </select>
            
            <input type="submit" value="Send" name="send" />
            
        </form>
        <br>
        <table border="0">
            <thead>
                <tr>
                    <th>Rank</th>
                    <th>User</th>
                    <th>Increase</th>

                </tr>
            </thead>
            <tbody>

                <?php 
                
                //case period was not set in parameter, set the last period of the list.
                if ( empty($period)) {
                    $period = $rperiod->period;
                }

                //Fetch table
                $result = mysql_query("
                SELECT * 
                FROM rank
                WHERE (period = '$period')
                ORDER BY -pos_now DESC 
                " )  or die ("Error in query: $result. " .mysql_error());

                
                while($row = mysql_fetch_object($result))   
                 {
                ?>

 
                <tr>
                    <td><?php echo $row->pos_now;       ?></td>
                    <td><a href="http://glufke.net/oracle/memberlist.php?mode=viewprofile&u=<?php echo $row->user_id.'">'.$row->username.'</a>';      ?></td>
                    <td><?php if     ( $row->increase >0 ) {  $img = $imgpath.'rank_increase.png';  $num = $row->increase;  }
                              elseif ( $row->increase <0 ) {  $img = $imgpath.'rank_decrease.png';  $num = abs($row->increase);  }
                              else                         {  $img = $imgpath.'rank_steady.png';    $num = '';  }
                              
                              echo '<img src="'.$img.'">'.$num;
                                 
                        ?>
                    </td>

                </tr>
                
                <?php
                 } 
                ?>
                
            </tbody>
        </table>
    </body>
</html>



