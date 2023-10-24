<?php
    include 'config.php';

    if (isset($_GET['id'])) {
        runQuery("UPDATE `notification` SET `status` = '1' WHERE `notification`.`id` = ".$_GET["id"]);
        header("Location: student-dashboard");
    }
?>