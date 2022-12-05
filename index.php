<?php
	session_unset();
	require_once  'controller/usersController.php';
    $controller = new usersController();
    $controller->mvcHandler();
?>