<?php
	require_once './config/session.php';
	require_once('./config/config.php');

	$user_logout = new USER();
	
	if($user_logout->is_loggedin()!="")
	{
		$user_logout->redirect('client.php');
	}

	if(isset($_GET['logout']) && $_GET['logout']=="true")
	{
		$user_logout->doLogout();
		$user_logout->redirect('login.php');
	}
