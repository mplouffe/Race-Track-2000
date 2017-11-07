<?php

	require 'data/connect.php';

	$query = "SELECT * FROM horses";
	$statement = $db->prepare($query);
	$statement->execute();

	while($rows = $statement->fetch())
	{
		$update["horseid"] = $rows["horseid"];
		$update["name"] = $rows["name"];

		$update["variation"] = mt_rand(1, 100) / 100;

		$query = "UPDATE horses SET variation = :variation WHERE horseid = :horseid";
		$statement2 = $db->prepare($query);
		$statement2->bindValue(":variation", $update["variation"]);
		$statement2->bindValue(":horseid", $update["horseid"]);
		$statement2->execute();
	}

	echo("success");
?>
