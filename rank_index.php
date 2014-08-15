<?php

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

$period = $_GET['period'];


//Start connection and definitions
include('rank_connection.php');
include('rank_definitions.php');
include('rank_details.php');

$o = rank_index('');

  echo $o;