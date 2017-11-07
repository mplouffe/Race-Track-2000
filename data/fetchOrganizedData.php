<?php

	require '..\admin\authenticateAdmin.php';

	if(!isset($_POST))
	{
		die();
	}

	if(isset($_POST['table']) && isset($_POST['category']) && $_POST['table'] == 'horses')
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
			$results[$i]["speed"] = $rows["speed"];
			$results[$i]["reliability"] = $rows["reliability"];
			$results[$i]["variation"] = $rows["variation"];
			$i++;
		}

		echo json_encode($results);
	}

	if(isset($_POST['table']) && isset($_POST['category']) && $_POST['table'] == 'users')
	{
		switch($_POST['category'])
		{
			case "userid":
				if($_POST["ascending"] == "true")
					$query = "SELECT userid, username, account, admin FROM users ORDER BY userid";
				else
					$query = "SELECT userid, username, account, admin FROM users ORDER BY userid DESC";
				break;
			case "username":
				if($_POST["ascending"] == "true")
					$query = "SELECT userid, username, account, admin FROM users ORDER BY username";
				else
					$query = "SELECT userid, username, account, admin FROM users ORDER BY username DESC";
				break;
			case "account":
				if($_POST["ascending"] == "true")
					$query = "SELECT userid, username, account, admin FROM users ORDER BY account";
				else
					$query = "SELECT userid, username, account, admin FROM users ORDER BY account DESC";
				break;
			case "admin":
				if($_POST["ascending"] == "true")
					$query = "SELECT userid, username, account, admin FROM users ORDER BY admin";
				else
					$query = "SELECT userid, username, account, admin FROM users ORDER BY admin DESC";
				break;
		}

		$statement = $db->prepare($query);
		$statement->bindValue(":category", $_POST["category"]);
		$statement->execute();

		$i = 0;
		while($rows = $statement->fetch())
		{
			$results[$i]["userid"] = $rows["userid"];
			$results[$i]["username"] = $rows["username"];
			$results[$i]["account"] = $rows["account"];
			$results[$i]["admin"] = $rows["admin"];
			$i++;
		}

		echo json_encode($results);
	}
	


?>