<?php
	session_start();
	include_once 'config_database.php';
	include_once 'users.php';

	$database = new database();
	$db = $database->getConnection();
	$user = new users($db);

	$user->id = $_GET['id'];
	
	// delete user 
	if ($user->delete()) {
		$_SESSION['msg'] = 'ลบข้อมูลแล้ว';
	} else {
		$_SESSION['msg'] = 'ไม่สามารถลบข้อมูลได้';
	}
	header('Location: manage_user.php');
?>