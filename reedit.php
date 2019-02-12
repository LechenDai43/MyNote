<?php
include 'connect.php';
$id = (int)$_POST["hiden_id"];
$firstQuery = "select * from note where note_id = ".$id;
$mainResultSet = mysqli_query($link, $firstQuery);
$row1 = mysqli_fetch_assoc($mainResultSet);
$title = $row1["title"];
$origin = $row1["origin"];
$focus = $row1["focus"];
$focus = trim(preg_replace('/\s\s+/', ' ', $focus));
$secondQuery = "select * from content where note_id = ".$id;
$contentResultSet = mysqli_query($link, $secondQuery);
$row2 = mysqli_fetch_assoc($contentResultSet);
$content = $row2["contence"];
$content = trim(preg_replace('/\s\s+/', ' ', $content));
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
$book = [];
$bookIdQuery = "select book_id from notetobook where note_id = ".$id;
$bkidrs = mysqli_query($link, $bookIdQuery);
for($i = 0; $i < mysqli_num_rows($bkidrs); $i ++){
    $bkid = (int) mysqli_fetch_assoc($bkidrs)["book_id"];    
    $forquery = "select title from book where book_id = ".$bkid;
    $forrs = mysqli_query($link, $forquery);
    array_push($book, mysqli_fetch_assoc($forrs)["title"]);
}
$books = implode("，", $book);

$person = [];
$personIdQuery = "select person_id from notetoperson where note_id = ".$id;
$psidrs = mysqli_query($link, $personIdQuery);
for($i = 0; $i < mysqli_num_rows($psidrs); $i ++){
    $psid = (int) mysqli_fetch_assoc($psidrs)["person_id"];
    $forquery = "select name from person where person_id = ".$psid;
    $forrs = mysqli_query($link, $forquery);
    array_push($person, mysqli_fetch_assoc($forrs)["name"]);
}
$persons = implode("，", $person);
include 'disconnect.php';
echo <<< END
<script type="application/javascript">
document.getElementById("t-title").value = "$title";
document.getElementById("t-source").value = "$origin";
document.getElementById("t-content").value = "$content";
document.getElementById("t-importance").value = "$focus";
document.getElementById("t-person").value = "$persons";
document.getElementById("t-book").value = "$books";
END;
$len = count($concept);
for($i = 1; $i < $len; $i ++){
    echo "addOneTerm();";
}
echo <<< END
var termarr = document.getElementsByClassName("t-v-term");
var defiarr = document.getElementsByClassName("t-v-defenition");
var examarr = document.getElementsByClassName("t-v-example");
END;
for($i = 0; $i < $len; $i ++){
    echo "termarr[".$i."].value = \"".$concept[$i][0]."\";";
    echo "defiarr[".$i."].value = \"".$concept[$i][1]."\";";
    echo "examarr[".$i."].value = \"".$concept[$i][2]."\";";
}
echo "</script>";
