<?php
    include 'config.php';

    if (isset($_GET['id'])) {
        runQuery("DELETE FROM `college` WHERE `college`.`collegeid` = '".$_GET["id"]."'");
        header("Location: admin-college?delete");
    }
?>