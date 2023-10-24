<?php
    include 'config.php';

    if (isset($_GET['id'])) {
        runQuery("DELETE FROM `student` WHERE `student`.`matricno` = '".$_GET["id"]."'");
        header("Location: admin-resident?delete");
    }
?>