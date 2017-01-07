<?php
	/*
	* This is the admin controller. It sets the admin_mode flag in  
	* order to allow access to the administration view (page 4).
	* This controller is designed in this way in order to facilitate
	* the integration of a 'login.php' page in the future.
	* 
	*/
include("Models/AdminPerson.php");
if (session_status() == PHP_SESSION_NONE) {
    session_start();
}

	$administrator = new AdminPerson;
	$administrator->setAdmin_mode(true);
	$_SESSION['administrator']= serialize($administrator);
	
	header("Location:index.php"); 
	exit; 
	
?>
		