<!DOCTYPE html>
<!--
To change this license header, choose License Headers in Project Properties.
To change this template file, choose Tools | Templates
and open the template in the editor.
-->
<html>
    <head>
        <meta charset="UTF-8">
        <title>My Note Editor</title>
        <link href="editor-table.css" rel="stylesheet" type="text/css"/>
        <link href="head.css" rel="stylesheet" type="text/css"/>
        <style>
            #buttons{
                margin-top: 10px;
            }
        </style>
    </head>
    <body>
        <?php
        $type = "Editor";
        header("Content-type:text/html;charset=utf-8"); //设定网页字符集
        include_once 'head.php';
        ?>
        <main>
            <form method="POST" action="viewer.php">
                <table id="table" border="1">
                    <tr>
                        <td class="left">标题：</td>
                        <td colspan="2">
                            <input type="text" name="标题" id="t-title" value=""/>
                        </td>
                    </tr>
                    <tr>
                        <td class="left">来源：</td>
                        <td colspan="2">
                            <input type="text" name="来源" id="t-source" value=""/>
                        </td>
                    </tr>
                    <tr>
                        <td class="left">内容：</td>
                        <td colspan="2">
                            <textarea name="内容" id="t-content" value=""></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td class="left">重点：</td>
                        <td colspan="2">
                            <textarea name="重点" id="t-importance" value=""></textarea>
                        </td>
                    </tr>
                    <tr>
                        <td rowspan="2" class="left" id="key-cell">概念：</td>
                        <td colspan="2">
                            <input type="text" name="概念-词汇[]" class="t-v-term" value=""/>
                            <button id="add-v" type="button" onclick="addOneTerm()">添加</button>
                        </td>
                    </tr>
                    <tr>
                        <td>
                            <textarea name="概念-定义[]" class="t-v-defenition" value=""></textarea>
                        </td>
                        <td>
                            <textarea name="概念-例子[]" class="t-v-example" value=""></textarea>
                        </td>
                    </tr>
                    <tr id="key-row">
                        <td class="left">人物：</td>
                        <td colspan="2">
                            <input type="text" name="人物" id="t-person" value=""/>
                        </td>
                    </tr>
                    <tr>
                        <td class="left">书目：</td>
                        <td colspan="2">
                            <input type="text" name="书目" id="t-book" value=""/>
                        </td>
                    </tr>
                </table>
                <div id="buttons">
                    <button type="submit" name="提交">提交</button>
                    <?php 
                    if(isset($_POST["hiden_id"])){
                        echo "<button type=\"submit\" name=\"cancel\" value=\"cancel\">取消</button>";
                        echo "<input type=\"hidden\" name=\"id_back\" value=".$_POST["hiden_id"]." />";
                    }else{
                        echo "<button><a href=\"main.php\">取消</a></button>";
                    }
                    ?>
                </div>
            </form>
        </main>
        <script src="add-term.js"></script>
        <?php 
        if(isset($_POST["hiden_id"])){
            include 'reedit.php';
        }
        ?>
    </body>
</html>
