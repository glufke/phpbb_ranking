<?php


function rank_output( $user )
{ 
/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$user_id = $user;// $_GET['user_id'];


//Start connection and definitions
include('rank_definitions.php');

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
                FROM rank
                WHERE user_id = '$user_id'
                ORDER BY period DESC
                " )  or die ("Error in query: $result. " .mysql_error());

                
                while($row = mysql_fetch_object($result))   
                 {
                $o = $o .
                 
'                <tr>
                    <td><center>'.$row->period.'</center></td>
                    <td><center>'.$row->qtd_now.'</center></td>
                    <td><center>'.$row->pos_now.'</center></td>
                    <td><center>';
                
                
                if     ( $row->increase >0 ) {  $img = 'images/rank_increase.png';  $num = $row->increase;  }
                elseif ( $row->increase <0 ) {  $img = 'images/rank_decrease.png';  $num = abs($row->increase);  }
                else                         {  $img = 'images/rank_steady.png';    $num = '&nbsp;&nbsp;';  }
                              
                $o = $o. '<img src="'.$img.'">'.$num.'
                    </td>

                </tr>';
                 } 
              $o = $o . '
                
            </tbody>
        </table>';

              
              
//echo $o;              
return $o;

}
?>