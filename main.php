<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>My Note Main</title>
        <link href="head.css" rel="stylesheet" type="text/css"/>
        <link href="main_display.css" rel="stylesheet" type="text/css"/>
        <style>
        </style>
    </head>
    <body>
        <?php
        $type = "Main";
        header("Content-type:text/html;charset=utf-8"); //设定网页字符集
        include_once 'head.php';
        ?>
        <main>
            <button id="adding" onclick="addNote()">添加新的笔记</button>
            <table>
                <thead>
                    <td class="title">标题</td>
                    <td class="origin">来源</td>
                </thead>
                <tbody id="tbody">

                </tbody>
            </table>
            <div id="testdiv">
                
            </div>
            <div id="testdiv1">
                
            </div>
            <div id="buton-group">
                <button onclick="goForward()"><</button>
                <select id="selectPage">
                    
                </select>
                <button onclick="jumpPage()">跳转</button>
                <button onclick="goBackward()">></button>
            </div>
        </main>
        <div id="hidden">
            
        </div>
        <script src="for_main.js"></script>
        <script>
            <?php
            if(!isset( $_GET["key"])){
                echo "clickSearch();";
            }
            if(isset( $_GET["type"])){
                echo "document.getElementById(\"input_search\").value = \"".$_GET["key"]."\";";
                echo "document.getElementById(\"input_type\").value = \"".$_GET["scope"]."\";";
                echo "clickSearch();";
            }
            ?>
            function addNote(){
                window.open("./editor.php");
            }
        </script>
    </body>
</html>
