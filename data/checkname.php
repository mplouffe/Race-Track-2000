<?php

	if(!isset($_POST) || $_POST["table"] == [])
	{
		die();
	}

	$name = filter_input(INPUT_POST, "name", FILTER_SANITIZE_FULL_SPECIAL_CHARS);
	$table = filter_input(INPUT_POST, "table", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	if($name == "" || $table == "")
	{
		die();
	}

	require 'connect.php';

	if($table == "users")
	{
		$query = "	SELECT *
					FROM Users 
					WHERE username = :name";
		$statement = $db->prepare($query);
		$statement->bindValue(':name', $name, PDO::PARAM_STR);
	}
	else if($table == "horses")
	{
		$query = "	SELECT *
					FROM horses
					WHERE name = :name";
		$statement = $db->prepare($query);
		$statement->bindValue(':name', $name, PDO::PARAM_STR);
	}

	$statement->execute();
	$result = $statement->fetch(PDO::FETCH_ASSOC);

	if($result == null)
	{
		$return = ["response" => "true"];
	}
	else
	{
		$return = ["response" => "false"];
	}

	echo json_encode($return);

?>