<?php
	session_start();
	
	if(!isset($_SESSION['userid']))
	{
		// if there isn't session data, send back to index
		header('location: ../index.php');
		die();
	}
	else
	{
		require '../data/connect.php';
		$query = "SELECT username, admin FROM users WHERE userid = :userid";
		$statement = $db->prepare($query);
		$statement->bindValue(":userid", $_SESSION["userid"]);
		$statement->execute();

		$user = $statement->fetch();

		if($user['admin'] != 'unlock')
		{
			unset($_SESSION);
			header('location: ../index.php');
			die();
		}
	}
?>