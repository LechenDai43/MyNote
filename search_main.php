<?php
include 'connect.php';
$resultSet;
$scope = "";
$key = "";
if(isset($_GET["scope"])){
    if(strcmp($_GET["scope"],"") != 0){
        $scope = $_GET["scope"];
    }    
}
if(isset($_GET["key"]) && strcmp($_GET["key"],"") != 0){
    $key = $_GET["key"];
}
if(strcmp($scope,"全局") == 0){
    $resultSet = forGlobal($key, $link);
}elseif (strcmp($scope, "标题") == 0) {
    $resultSet = forTitle($key, $link);
}elseif (strcmp($scope, "来源") == 0) {
    $resultSet = forOrigin($key, $link);
}elseif (strcmp($scope, "概念") == 0) {
    $resultSet = forConcept($key, $link);
}elseif (strcmp($scope, "书目") == 0) {
    $resultSet = forBooks($key, $link);
}elseif (strcmp($scope, "人物") == 0) {
    $resultSet = forPersons($key, $link);
}
if(isset($resultSet)){
    if(count($resultSet) == 0){
        echo "没有找到相应的结果";
    }else{
        for($i = 0; $i < count($resultSet); $i ++){
            echo $resultSet[$i]["note_id"].";".$resultSet[$i]["title"].";".$resultSet[$i]["origin"];
            if($i < count($resultSet) - 1){
                echo "^";
            }
        }
    }
}else{
    echo "没有找到相应的结果";
}


function forTitle($key, $link){
    $query = "";
    if(strcmp($key,"") != 0){
        $query = "select note_id, title, origin from note where title like \"%".$key."%\"";
        $rtst = mysqli_query($link, $query);
        $result = [];
        for($i = 0; $i < mysqli_num_rows($rtst); $i ++){
            array_push($result, mysqli_fetch_assoc($rtst));
        }
        return $result;
    }else{
        return forAll($link);
    }
    
}

function forFocus($key, $link){
    $query = "";
    if(strcmp($key,"") != 0){
        $query = "select note_id, title, origin from note where focus like \"%".$key."%\"";
        $rtst = mysqli_query($link, $query);
        $result = [];
        for($i = 0; $i < mysqli_num_rows($rtst); $i ++){
            array_push($result,mysqli_fetch_assoc($rtst));
        }
        return $result;
    }else{
        return forAll($link);
    }
    
}

function forOrigin($key, $link){
    $query = "";
    if(strcmp($key,"") != 0){
        $query = "select note_id, title, origin from note where origin like \"%".$key."%\"";
        $rtst = mysqli_query($link, $query);
        $result = [];
        for($i = 0; $i < mysqli_num_rows($rtst); $i ++){
            array_push($result,mysqli_fetch_assoc($rtst));
        }
        return $result;
    }else{
        return forAll($link);
    }
    
}

function forConcept($key,$link){
    $query = "";
    if(strcmp($key,"") != 0){
        $query = "select note_id from concept where concept like \"%".$key."%\" or definition like \"%".$key."%\" or example like \"%".$key."%\"";
        $rtst = mysqli_query($link, $query);
        $result = [];
        for($i = 0; $i < mysqli_num_rows($rtst); $i ++){
            $temId = mysqli_fetch_assoc($rtst)["note_id"];
            $numId = (int)$temId;
            $temquery = "select note_id, title, origin from note where note_id = ".$numId;
            $temrs = mysqli_query($link, $temquery);
            array_push($result, mysqli_fetch_assoc($temrs));
        }
        return $result;
    }else{
        return forAll($link);
    }
    
}

function forBooks($key,$link){
    $query = "";
    if(strcmp($key,"") != 0){
        $query = "select book_id from book where title = \"".$key."\"";
        $rtst = mysqli_query($link, $query);
        $keyId = (int)mysqli_fetch_assoc($rtst)["book_id"];
        $query = "select note_id form notetobook where book_id = \"".$keyId."\"";
        $rtst = mysqli_query($link, $query);
        $result = [];
        for($i = 0; $i < mysqli_num_rows($rtst); $i ++){
            $temId = mysqli_fetch_assoc($rtst)["note_id"];
            $numId = (int)$temId;
            $temqury = "select note_id, title, origin from note where note_id = ".$numId;
            $temrs = mysqli_query($link, $temquery);
            array_push($result, mysqli_fetch_assoc($temrs));
        }
        return $result;
    }else{
        return forAll($link);
    }
    
}

function forPersons($key,$link){
    $query = "";
    if(strcmp($key,"") != 0){
        $query = "select person_id from person where name = \"".$key."\"";
        $rtst = mysqli_query($link, $query);
        $keyId = (int)mysqli_fetch_assoc($rtst)["person_id"];
        $query = "select note_id form notetoperson where person_id = \"".$keyId."\"";
        $rtst = mysqli_query($link, $query);
        $result = [];
        for($i = 0; $i < mysqli_num_rows($rtst); $i ++){
            $temId = mysqli_fetch_assoc($rtst)["note_id"];
            $numId = (int)$temId;
            $temqury = "select note_id, title, origin from note where note_id = ".$numId;
            $temrs = mysqli_query($link, $temquery);
            array_push($result, mysqli_fetch_assoc($temrs));
        }
        return $result;
    }else{
        return forAll($link);
    }
}

function forContent($key,$link){
    $query = "";
    if(strcmp($key,"") != 0){
        $query = "select note_id from content where contence like \"%".$key."%\"";
        $rtst = mysqli_query($link, $query);
        $result = [];
        for($i = 0; $i < mysqli_num_rows($rtst); $i ++){
            $temId = mysqli_fetch_assoc($rtst)["note_id"];
            $numId = (int)$temId;
            $temqury = "select note_id, title, origin from note where note_id = ".$numId;
            $temrs = mysqli_query($link, $temquery);
            array_push($result, mysqli_fetch_assoc($temrs));
        }
        return $result;
    }else{
        return forAll($link);
    }
}

function forGlobal($key, $link){
    if(strcmp($key,"") != 0){;
        $result = [];
        array_merge($result, forTitle($key, $link));
        $result = removeDup($result);
        array_merge($result, forFocus($key, $link));
        $result = removeDup($result);
        array_merge($result, forOrigin($key, $link));
        $result = removeDup($result);
        array_merge($result, forConcept($key, $link));
        $result = removeDup($result);
        array_merge($result, forContent($key, $link));
        $result = removeDup($result);
        return $result;
    }else{
        return forAll($link);
    }
}

function removeDup($arr){
    for($i = 0; $i < count($arr); $i ++){
        $temKey = $arr[$i][0];
        for($j = $i + 1; $j < count($arr); $j ++){
            if($arr[$j][0] == $temKey){
                array_splice($arr, $j,1);
                $j --;
            }
        }
    }
    return $arr;
}

function forAll($link){
    $query = "select note_id, title, origin from note";
    $rtst = mysqli_query($link, $query);
    $result = [];
    for($i = 0; $i < mysqli_num_rows($rtst); $i ++){
        array_push($result,mysqli_fetch_assoc($rtst));
    }
    return $result;
}

include 'disconnect.php';