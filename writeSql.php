<?php
include 'connect.php';
$title = $_POST["标题"];
$origin = $_POST["来源"];
$focus = $_POST["重点"];
$content = $_POST["内容"];
$bk = $_POST["书目"];
$prsn = $_POST["人物"];
$ccpt = $_POST["概念-词汇"];
$dfnt = $_POST["概念-定义"];
$xmp = $_POST["概念-例子"];
if(isset($concept)){
    unset($concept);
}
$concept = [];
for($i = 0; $i < count($ccpt); $i ++){
    $temarr = [];
    $one = $ccpt[$i];
    $two = $dfnt[$i];
    $three = $xmp[$i];
    array_push($temarr, $one);
    array_push($temarr, $two);
    array_push($temarr, $three);
    array_push($concept, $temarr);
}
$book = [];
$book = explode("，", $bk);
$person = [];
$person = explode("，", $prsn);
$mainquery = "insert into note (title,origin,focus) value(\"".$title."\",\"".$origin."\",\"".$focus."\")";
mysqli_query($link, $mainquery);
$newId = (int) mysqli_insert_id($link);
$contentquery = "insert into content (note_id,contence) value(".$newId.",\"".$content."\")";
$a = mysqli_query($link, $contentquery);
for($i = 0; $i < count($concept); $i ++){
    $tem = $concept[$i];
    $conceptquery = "insert into concept (note_id,concept,definition,example) value(".$newId.",\"".$tem[0]."\",\"".$tem[1]."\",\"".$tem[2]."\")";
    mysqli_query($link, $conceptquery);
}
for($i = 0; $i < count($book); $i ++){
    $abk = $book[$i];
    $bkstep1 = "select * from book where title = \"".$abk."\"";
    $result1 = mysqli_query($link, $bkstep1);
    if(mysqli_num_rows($result1) == 0){
        $bkstep2 = "insert into book (title) value (\"".$abk."\")";
        mysqli_query($link, $bkstep2);
        $nbId = (int) mysqli_insert_id($link);
        $bkstep3 = "insert into notetobook value(".$newId.",".$nbId.")";
        mysqli_query($link, $bkstep3);
    }else{
        $bkId = (int) mysqli_fetch_assoc($result1)["book_id"];
        $bkstep2 = "insert into notetobook value(".$newId.",".$bkId.")";
        mysqli_query($link, $bkstep2);
    }
    
}
for($i = 0; $i < count($person); $i ++){
    $aps = $person[$i];
    $psstep1 = "select * from person where name = \"".$aps."\"";
    $result1 = mysqli_query($link, $psstep1);
    if(mysqli_num_rows($result1) == 0){
        $psstep2 = "insert into person (name) value (\"".$aps."\")";
        mysqli_query($link, $psstep2);
        $npId = (int) mysqli_insert_id($link);
        $psstep3 = "insert into notetoperson value(".$newId.",".$npId.")";
        mysqli_query($link, $psstep3);
    }else{
        $psId = (int) mysqli_fetch_assoc($result1)["person_id"];
        $psstep2 = "insert into notetoperson value(".$newId.",".$psId.")";
        mysqli_query($link, $psstep2);
    }
}
$hidden_id = $newId;
include 'disconnect.php';