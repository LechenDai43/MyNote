<?php
include 'connect.php';
$id = (int)$_GET["id"];

$title = $_POST["标题"];
$titleQuery = "select title from note where note_id = ".$id;
$ttlrs = mysqli_query($link, $titleQuery);
$title_in_database = mysqli_fetch_assoc($ttlrs)["title"];
if(strcmp($title,$title_in_database) != 0){
    $titleUpdate = "update note set title = \"".$title."\" where note_id = ".$id;
    mysqli_query($link, $titleUpdate);
}
unset($ttlrs);
unset($title_in_database);
unset($titleQuery);

$origin = $_POST["来源"];
$originQuery = "select origin from note where note_id = ".$id;
$rgnrs = mysqli_query($link, $originQuery);
$origin_in_database = mysqli_fetch_assoc($rgnrs)["origin"];
if(strcmp($origin,$origin_in_database) != 0){
    $originUpdate = "update note set origin = \"".$origin."\" where note_id = ".$id;
    mysqli_query($link, $originUpdate);
}
unset($originQuery);
unset($rgnrs);
unset($origin_in_database);

$focus = $_POST["重点"];
$focusQuery = "select focus from note where note_id = ".$id;
$fcsrs = mysqli_query($link, $focusQuery);
$focus_in_database = mysqli_fetch_assoc($fcsrs)["focus"];
if(strcmp($focus,$focus_in_database) != 0){
    $focusUpdate = "update note set focus = \"".$focus."\" where note_id = ".$id;
    $test = mysqli_query($link, $focusUpdate);
}
unset($focusQuery);
unset($fcsrs);
unset($focus_in_database);

$content = $_POST["内容"];
$contentQuery = "select contence from content where note_id = ".$id;
$cttrs = mysqli_query($link, $contentQuery);
if(mysqli_num_rows($cttrs) == 0){
    $insert = "insert into content (note_id,contence) value (".$id.",\"".$content."\")";
    mysqli_query($link, $insert);
}else{
    $content_in_database = mysqli_fetch_assoc($cttrs)["contence"];
    if(strcmp($content,$content_in_database) != 0){
        $contentUpdate = "update content set contence = \"".$content."\" where note_id = ".$id;
        $test = mysqli_query($link, $contentUpdate);
    }
}
unset($contentQuery);
unset($cttrs);

$bk = $_POST["书目"];
$book = explode("，", $bk);
for($i = 0; $i < count($book); $i ++){
    $book_idQuery = "select book_id from book where title = \"".$book[$i]."\"";
    $bkdrs = mysqli_query($link, $book_idQuery);
    $num = mysqli_num_rows($bkdrs);
    if($num == 0){
        $bookInsertion = "insert into book (title) value (\"".$book[$i]."\")";
        mysqli_query($link, $bookInsertion);
        $nbkId = (int)mysqli_insert_id($link);
        $note2bookInsertion = "insert into notetobook (note_id,book_id) value (".$id.",".$nbkId.")";
        mysqli_query($link, $note2bookInsertion);
    }else{
        $obkId = (int)mysqli_fetch_assoc($bkdrs)["book_id"];
        $getNoteIdQuery = "select note_id from notetobook where book_id = ".$obkId;
        $noteIdRS = mysqli_query($link, $getNoteIdQuery);
        $number = mysqli_num_rows($noteIdRS);
        $needle = "no";
        for($j = 0; $j < $number; $j ++){
            $temId = (int) mysqli_fetch_assoc($noteIdRS)["note_id"];
            if($temId == $id){
                $needle = "yes";
                break;
            }
        }
        if(strcmp($needle, "yes") != 0){
            $insertionNote2Book = "insert into notetobook (note_id, book_id) value (".$id.",".$obkId.")";
            mysqli_query($link, $insertionNote2Book);
        }
    }
}
$lookingForBookId = "select book_id from notetobook where note_id = ".$id;
$bookIdRS = mysqli_query($link, $lookingForBookId);
$numBK = mysqli_num_rows($bookIdRS);
for($i = 0; $i < $numBK; $i ++){
    $tembookid = (int)mysqli_fetch_assoc($bookIdRS)["book_id"];
    $findBookTitleQuery = "select title from book where book_id = ".$tembookid;
    $temrs = mysqli_query($link, $findBookTitleQuery);
    $something = mysqli_fetch_assoc($temrs);
    $tembooktitle = $something["title"];
    if(in_array($tembooktitle, $book) == FALSE){
        $deleteNote2Book = "delete from notetobook where note_id = ".$id." and book_id = ".$tembookid;
        mysqli_query($link, $deleteNote2Book);
    }
}
unset($bk);
unset($numBK);
unset($bookIdRS);
unset($lookingForBookId);
unset($book);

$ps = $_POST["人物"];
$person = explode("，", $ps);
for($i = 0; $i < count($person); $i ++){
    $person_idQuery = "select person_id from person where name = \"".$person[$i]."\"";
    $bkdrs = mysqli_query($link, $person_idQuery);
    $num = mysqli_num_rows($bkdrs);
    if($num == 0){
        $personInsertion = "insert into person (name) value (\"".$person[$i]."\")";
        mysqli_query($link, $personInsertion);
        $nbkId = (int)mysqli_insert_id($link);
        $note2personInsertion = "insert into notetoperson (note_id,person_id) value (".$id.",".$nbkId.")";
        mysqli_query($link, $note2personInsertion);
    }else{
        $obkId = (int)mysqli_fetch_assoc($bkdrs)["person_id"];
        $getNoteIdQuery = "select note_id from notetoperson where person_id = ".$obkId;
        $noteIdRS = mysqli_query($link, $getNoteIdQuery);
        $number = mysqli_num_rows($noteIdRS);
        $needle = "no";
        for($j = 0; $j < $number; $j ++){
            $temId = (int) mysqli_fetch_assoc($noteIdRS)["note_id"];
            if($temId == $id){
                $needle = "yes";
                break;
            }
        }
        if(strcmp($needle, "yes") != 0){
            $insertionNote2person = "insert into notetoperson (note_id, person_id) value (".$id.",".$obkId.")";
            mysqli_query($link, $insertionNote2person);
        }
    }
}
$lookingForPersonId = "select person_id from notetoperson where note_id = ".$id;
$personIdRS = mysqli_query($link, $lookingForPersonId);
$numBK = mysqli_num_rows($personIdRS);
for($i = 0; $i < $numBK; $i ++){
    $tempersonid = (int)mysqli_fetch_assoc($personIdRS)["person_id"];
    $findPersonTitleQuery = "select name from person where person_id = ".$tempersonid;
    $temrs = mysqli_query($link, $findPersonTitleQuery);
    $tempersontitle = mysqli_fetch_assoc($temrs)["name"];
    if(in_array($tempersontitle, $person) == FALSE){
        $deleteNote2person = "delete from notetoperson where note_id = ".$id." and person_id = ".$tempersonid;
        mysqli_query($link, $deleteNote2person);
    }
}
unset($ps);
unset($numBK);
unset($personIdRS);
unset($lookingForPersonId);
unset($person);

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
for($i = 0; $i < count($concept); $i ++){
    $temTerm = $concept[$i][0];
    $termSelecting = "select * from concept where note_id = ".$id." and concept = \"".$temTerm."\"";
    $termrs = mysqli_query($link, $termSelecting);
    $num = mysqli_num_rows($termrs);
    if($num == 0){
        $insertConcept = "insert into concept (note_id,concept,definition,example) value (".$id.",\"".$temTerm."\",\"".$concept[$i][1]."\",\"".$concept[$i][2]."\")";
        mysqli_query($link, $insertConcept);
    }else{
        $line = mysqli_fetch_assoc($termrs);
        $definition_in_database = $line["definition"];
        if(strcmp($definition_in_database,$concept[$i][1]) != 0){
            $updateDefinition = "update concept set definition = \"".$concept[$i][1]."\" where note_id = ".$id." and concept = \"".$temTerm."\"";
            mysqli_query($link, $updateDefinition);
        }
        $example_in_database = $line["example"];
        if(strcmp($example_in_database,$concept[$i][2]) != 0){
            $updateExample = "update concept set example = \"".$concept[$i][2]."\" where note_id = ".$id." and concept = \"".$temTerm."\"";
            mysqli_query($link, $updateExample);
        }
    }
}
$termSelecting = "select * from concept where note_id = ".$id;
$conceptRS = mysqli_query($link, $termSelecting);
$num = mysqli_num_rows($conceptRS);
for($i = 0; $i < $num; $i ++){
    $line = mysqli_fetch_assoc($conceptRS);
    $oneTerm = $line["concept"];
    if(in_array($oneTerm, $ccpt) == FALSE){
        $deleteConcept = "delete from concept where note_id = ".$id." and concept = \"".$oneTerm."\"";
        mysqli_query($link, $deleteConcept);
    }
}
unset($ccpt);
unset($dfnt);
unset($xmp);
unset($termSelecting);
unset($conceptRS);
unset($num);

$hidden_id = $id;


include "disconnect.php";

