<?php
	if(!isset($_POST))
	{
		die();
	}

	require 'connect.php';

	$table = filter_input(INPUT_POST, "table", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$id = filter_input(INPUT_POST, "id", FILTER_VALIDATE_INT);

	if($table == "users")
	{

		$query = "DELETE FROM users WHERE userid = :id";
		$statement = $db->prepare($query);
		$statement->bindValue(":id", $id, PDO::PARAM_INT);
		$statement->execute();

		echo ("success");
	}
	else if($table == "horses")
	{
		$query = "DELETE FROM horses WHERE horseid = :id";
		$statement = $db->prepare($query);
		$statement->bindValue(":id", $id, PDO::PARAM_INT);
		$statement->execute();

		echo ("success");
	}
?>