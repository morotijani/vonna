<?php 

    require_once ("../db_connection/conn.php");

    unset($_SESSION['VNAdmin']);

    redirect(PROOT . 'adminvonna/login');

?>