<?php

	require '..\admin\authenticateAdmin.php';

	if(!isset($_POST) || !isset($_POST["category"]))
	{
		die();
	}

	$_POST["category"] = filter_input(INPUT_POST, "category", FILTER_SANITIZE_FULL_SPECIAL_CHARS);


	if($_POST['category'] != "")
	{
		switch($_POST['category'])
		{
			case "horseid":
				if($_POST["ascending"] == "true")
					$query = "SELECT horseid, name, speed, variation, reliability FROM horses ORDER BY horseid";
				else
					$query = "SELECT horseid, name, speed, variation, reliability FROM horses ORDER BY horseid DESC";
				break;
			case "name":
				if($_POST["ascending"] == "true")
					$query = "SELECT horseid, name, speed, variation, reliability FROM horses ORDER BY name";
				else
					$query = "SELECT horseid, name, speed, variation, reliability FROM horses ORDER BY name DESC";
				break;
			case "speed":
				if($_POST["ascending"] == "true")
					$query = "SELECT horseid, name, speed, variation, reliability FROM horses ORDER BY speed";
				else
					$query = "SELECT horseid, name, speed, variation, reliability FROM horses ORDER BY speed DESC";
				break;
			case "variation":
				if($_POST["ascending"] == "true")
					$query = "SELECT horseid, name, speed, variation, reliability FROM horses ORDER BY variation";
				else
					$query = "SELECT horseid, name, speed, variation, reliability FROM horses ORDER BY variation DESC";
				break;
			case "reliability":
				if($_POST["ascending"] == "true")
					$query = "SELECT horseid, name, speed, variation, reliability FROM horses ORDER BY reliability";
				else
					$query = "SELECT horseid, name, speed, variation, reliability FROM horses ORDER BY reliability DESC";
				break;
		}

		$statement = $db->prepare($query);
		$statement->bindValue(":category", $_POST["category"]);
		$statement->execute();

		$i = 0;
		while($rows = $statement->fetch())
		{
			$results[$i]["horseid"] = $rows["horseid"];
			$results[$i]["name"] = $rows["name"];
		if($rows["speed"] >= 94)
			$results[$i]["speed"] = "A";
		elseif($rows["speed"] >=88)
			$results[$i]["speed"] = "B";
		elseif($rows["speed"] >= 82)
			$results[$i]["speed"] = "C";
		elseif($rows["speed"] >= 76)
			$results[$i]["speed"] = "D";
		else
			$results[$i]["speed"] = "F";

		if($rows["reliability"] >= 25)
			$results[$i]["reliability"] = "A";
		elseif($rows["reliability"] >= 20)
			$results[$i]["reliability"] = "B";
		elseif($rows["reliability"] >= 15)
			$results[$i]["reliability"] = "C";
		elseif($rows["reliability"] >= 10)
			$results[$i]["reliability"] = "D";
		else
			$results[$i]["reliability"] = "F";

		if($rows["variation"] >= 0.8)
			$results[$i]["variation"] = "A";
		elseif($rows["variation"] >= 0.6)
			$results[$i]["variation"] = "B";
		elseif($rows["variation"] >= 0.4)
			$results[$i]["variation"] = "C";
		elseif($rows["variation"] >= 0.2)
			$results[$i]["variation"] = "D";
		else
			$results[$i]["variation"] = "F";
			$i++;
		}

		echo json_encode($results);
	}
?>