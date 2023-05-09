<?php 

	// USER SIGNOUT PAGE

    require_once ("../db_connection/conn.php");

    unset($_SESSION['VNUser']);

	redirect(PROOT . 'auth/signin');

	
?>