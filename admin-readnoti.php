<?php
    include 'config.php';

    if (isset($_GET['id'])) {
        $fetchnoti = fetchRow("SELECT * FROM `notification` WHERE `notification`.`id` = ".$_GET["id"]);
        $collegeid = trim(explode('<~>',$fetchnoti['message'])[1]);
        runQuery("UPDATE `notification` SET `status` = '1' WHERE `notification`.`id` = ".$_GET["id"]);
        header("Location: admin-college-applicant?id=".$collegeid);
    }
?>