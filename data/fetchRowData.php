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
		$query = "SELECT * FROM users WHERE userid = :id";
		$statement = $db->prepare($query);
		$statement->bindValue(":id", $id);
		$statement->execute();

		$row = $statement->fetch();

		$result["userid"] = $row["userid"];
		$result["username"] = $row["username"];
		$result["account"] = $row["account"];

		echo json_encode($result);
	}

	if($table == "horses")
	{
		$query = "SELECT * FROM horses WHERE horseid = :id";
		$statement = $db->prepare($query);
		$statement->bindValue(":id", $id);
		$statement->execute();

		$row = $statement->fetch();

		$result["horseid"] = $row["horseid"];
		$result["name"] = $row["name"];
		$result["speed"] = $row["speed"];
		$result["reliability"] = $row["reliability"];
		$result["variation"] = $row["variation"];

		echo json_encode($result);
	}
?>