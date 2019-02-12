<html>
    <head>
        <meta charset="UTF-8">
        <title>My Note Viewer</title>
        <link href="head.css" rel="stylesheet" type="text/css"/>
        <link href="viewer-layout.css" rel="stylesheet" type="text/css"/>
    </head>
    <body>
    <?php
    $title = "title";
    $origin = "origin";
    $focus = "This is the focus text.";
    $content = "This is the content of the sample note.";
    $concept = array( array("word1","Word1 is the first word.",  "I like word1."),
        array("word2","Word2 is the second word.", "I hate word2."));
    if(isset($_POST["id_back"])){
        $_GET["id"] = $_POST["id_back"];
        if(isset($_POST["cancel"])){
            include_once 'readSql.php';
        }elseif(isset($_POST["提交"])){
            include_once 'updateSql.php';
        }  
    }else{
        if(isset($_GET["id"])){
            include_once 'readSql.php';
        }elseif(isset($_POST["提交"])){
            include_once 'writeSql.php';
        }
    }
    
              

    $type = "Viewer";
    include_once 'head.php';
    ?>
        <main>
            <div id="leading">
                <h1><?php echo $title; ?></h1>
                <h3><?php echo $origin; ?></h3>
            </div>
            <hr/>
            <br/>
            <div id="focus">
                <span>重点摘要：</span>
                <pre>
        <?php echo $focus; ?>
                </pre>
            </div>
            <br/>
            <p id="content">
                <?php echo $content; ?>
            </p>
            <br/>
            <?php
            if(count($concept) > 0){
                echo "<ul>";
                for($i = 0; $i < count($concept); $i ++){
                    echo "<li>";
                    echo $concept[$i][0];
                    echo "<p>".$concept[$i][1]."</p>";
                    echo "<p>".$concept[$i][2]."</p>";
                    echo "</li>";
                    echo "<br/>";
                }
                echo "</ul>";
            }
            ?>
        </main>
        <form method="POST" action="editor.php">
            <input type="hidden" name="hiden_id" value="<?php echo $hidden_id; ?>" />
            <button type="submit" name="edit" value="编辑">编辑</button>
            <button><a href="main.php">返回</a></button>
        </form>  
        <script src="viewersearch.js"></script>
    </body>
</html>