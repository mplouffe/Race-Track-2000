<?php

	if(!isset($_POST))
	{
		die();
	}

	require 'connect.php';

	$table = filter_input(INPUT_POST, "table", FILTER_SANITIZE_FULL_SPECIAL_CHARS);

	if($table == "users")
	{
		$query = "SELECT * FROM users";
		$statement = $db->prepare($query);
		$statement->execute();

		$i = 0;
		while($row = $statement->fetch())
		{
			$results[$i][0] = $row["userid"];
			$results[$i][1] = $row["username"];
			$i++;
		}

		echo json_encode($results);
	}

	if($table == "horses")
	{
		$query = "SELECT * FROM horses";
		$statement = $db->prepare($query);
		$statement->execute();

		$i = 0;
		while($row = $statement->fetch())
		{
			$results[$i][0] = $row["horseid"];
			$results[$i][1] = $row["name"];
			$i++;
		}

		echo json_encode($results);
	}

?>