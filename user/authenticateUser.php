<?php
	
	session_start();

	require '../data/connect.php';

	if(!isset($_SESSION['userid']))
	{
		header("Location: ../index.php");
		die();
	}

	$query = "SELECT * FROM users WHERE userid = :userid";
	$statement = $db->prepare($query);
	$statement->bindValue(":userid", $_SESSION['userid']);
	$statement->execute();

	$row = $statement->fetch();

	if($row == null)
	{
		header("Location: ../index.php");
		die();
	}
	else
	{
		$user['username'] = $row['username'];
		$user['account'] = $row['account'];
		$user['admin'] = $row['admin'] == 'unlock';
	}

?>