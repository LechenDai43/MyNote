<?php
include 'connect.php';
$id = (int)$_GET["id"];
$hidden_id = $id;
$firstQuery = "select * from note where note_id = ".$id;
$mainResultSet = mysqli_query($link, $firstQuery);
$row1 = mysqli_fetch_assoc($mainResultSet);
$title = $row1["title"];
$origin = $row1["origin"];
$focus = $row1["focus"];
$secondQuery = "select * from content where note_id = ".$id;
$contentResultSet = mysqli_query($link, $secondQuery);
$row2 = mysqli_fetch_assoc($contentResultSet);
$content = $row2["contence"];
$thirdQuery = "select * from concept where note_id = ".$id;
$conceptResultSet = mysqli_query($link, $thirdQuery);
$num = (int) mysqli_num_rows($conceptResultSet);
if(isset($concept)){
    unset($concept);
}
$concept = [];
for($i = 0; $i < $num; $i ++){
    $arow = mysqli_fetch_assoc($conceptResultSet);
    $tem = [];
    $one = $arow["concept"];
    $two = $arow["definition"];
    $three = $arow["example"];
    array_push($tem, $one);
    array_push($tem, $two);
    array_push($tem, $three);
    array_push($concept, $tem);
}

/* 
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */

include 'disconnect.php';