<?php
    include 'config.php';

    if (isset($_GET['id'])) {
        runQuery("DELETE FROM admin WHERE userid=".$_GET["id"]);
        header("Location: admin-staff?delete");
    }
?>