<?php


function rank_index( $per )
{ 
    


$period = $per; //$_GET['period'];


//Start connection and definitions
//include('rank_connection.php');
//include('rank_definitions.php');



//Fetch last period
$qperiod = mysql_query("
SELECT MAX( period ) period 
FROM rank"
)  or die ("Error in qperiod: $qperiod. " .mysql_error());

$rperiod = mysql_fetch_object($qperiod);

//case period was not set in parameter, set the last period of the list.
if ( empty($period)) {
    $period = $rperiod->period;
    $limit  = 'LIMIT 10';
}


$o = '<h3>Rank '.$period.' </h3>
	';
$o = $o . '
        <table border="0">
            <thead>
                <tr>
                    <th>'.$det_pos.'</th>
                    <th align="left">'.$det_user.'</th>
                    <th>'.$det_increase.'</th>

                </tr>
            </thead>
            <tbody>';

                
                
//Fetch table
$result = mysql_query("
SELECT * 
FROM rank
WHERE (period = '$period')
ORDER BY -pos_now DESC 
".$limit )  or die ("Error in query: $result. " .mysql_error());

$prev_rank = 0;
while($row = mysql_fetch_object($result))   
 {
    //set position.
    if ($prev_rank <> $row->pos_now) $pos =  $row->pos_now.'&#176;';
    
    $o = $o . '
                <tr>
                    <td><center>'.$pos.'</center></td>
                    <td><a href="http://glufke.net/oracle/memberlist.php?mode=viewprofile&u='.  $row->user_id.'">'.$row->username.'</a></td>
                    <td><center>';
    
                if     ( $row->increase >0 ) {  $img = 'images/rank_increase.png';  $num = $row->increase;  }
                elseif ( $row->increase <0 ) {  $img = 'images/rank_decrease.png';  $num = abs($row->increase);  }
                else                         {  $img = 'images/rank_steady.png';    $num = '&nbsp;&nbsp;';  }
                
                $o = $o. '<img src="'.$img.'">'.$num.'
                    </center></td>
                </tr>';
                    
                $prev_rank = $row->pos_now;
                 }
               
                $o = $o . ' 
            </tbody>
        </table>';

  return $o;       
}




function rank_output( $user, $lang )
{ 
 
    
    
$user_id = $user;// $_GET['user_id'];


//Start definitions
include('rank_definitions.php');

//if english, overvrite. (please, do something better here)
if ($lang =='en')
{
    $det_period     ='&nbsp; Year &nbsp;';	
    $det_qtd        ='&nbsp; Qty.Msg &nbsp;';
    $det_pos	='&nbsp; Rank &nbsp;';
    $det_increase   ='&nbsp; Increase &nbsp;';
}
$o = ' <table border="0">
            <thead>
                <tr>
                    <th>'.$det_period.'</th>
                    <th>'.$det_qtd.'</th>
                    <th>'.$det_pos.'</th>
                    <th>'.$det_increase.'</th>

                </tr>
            </thead>
            <tbody>';

                
                

                //Fetch table
                $result = mysql_query("
                SELECT *
                FROM rank a
                LEFT JOIN (SELECT MIN(y.period) AS min_period FROM rank y WHERE y.user_id = '$user_id') b
                ON a.period = min_period
                WHERE a.user_id = '$user_id'
                ORDER BY a.period DESC
                " )  or die ("Error in query: $result. " .mysql_error());

                
                while($row = mysql_fetch_object($result))   
                 {
                $o = $o .
                 
'                <tr>
                    <td><center>'.$row->period.'</center></td>
                    <td><center>'.$row->qtd_now.'</center></td>
                    <td><center>'.$row->pos_now.'&#176;</center></td>
                    <td><center>';
                
                
                if     ( $row->increase >0 ) {  $img = 'images/rank_increase.png';  $num = $row->increase;  }
                elseif ( $row->increase <0 ) {  $img = 'images/rank_decrease.png';  $num = abs($row->increase);  }
                else                         {  $img = 'images/rank_steady.png';    $num = '&nbsp;&nbsp;';  }
                
                //Dont show the first period increase.
                if (!$row->min_period==$row->period ) 
                {
                $o = $o. '<img src="'.$img.'">'.$num.'
                    </td>
                </tr>';
                }
                 } 
              $o = $o . '
                
            </tbody>
        </table>';

              
              
//echo $o;              
return $o;

}





?>