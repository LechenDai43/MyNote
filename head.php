<?php

?>
<header>
    <h1 id="h-in-h">My Note -- <?php echo $type ?></h1>
    <?php 
    if(strcmp($type, "Editor") == 1){
        include 'search_component.php';
    }
    ?>
</header>
<hr/>