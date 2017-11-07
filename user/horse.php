<?php

	require 'authenticateUser.php';

	if(!isset($_GET))
	{
		header("Location: horses.php");
		die();
	}
	else
	{
		$horseid = filter_input(INPUT_GET, 'horseid', FILTER_VALIDATE_INT);

		if($horseid == "")
		{
			header("Location: horses.php");
			die();
		}
		else
		{
			$query = "SELECT * FROM horses WHERE horseid = :horseid";
			$statement = $db->prepare($query);
			$statement->bindValue(":horseid", $horseid);
			$statement->execute();

			$horse = $statement->fetch();

			if($horse["speed"] >= 94)
				$horse["speed"] = "A";
			elseif($horse["speed"] >=88)
				$horse["speed"] = "B";
			elseif($horse["speed"] >= 82)
				$horse["speed"] = "C";
			elseif($horse["speed"] >= 76)
				$horse["speed"] = "D";
			else
				$horse["speed"] = "F";

			if($horse["reliability"] >= 25)
				$horse["reliability"] = "A";
			elseif($horse["reliability"] >= 20)
				$horse["reliability"] = "B";
			elseif($horse["reliability"] >= 15)
				$horse["reliability"] = "C";
			elseif($horse["reliability"] >= 10)
				$horse["reliability"] = "D";
			else
				$horse["reliability"] = "F";

			if($horse["variation"] >= 0.8)
				$horse["variation"] = "A";
			elseif($horse["variation"] >= 0.6)
				$horse["variation"] = "B";
			elseif($horse["variation"] >= 0.4)
				$horse["variation"] = "C";
			elseif($horse["variation"] >= 0.2)
				$horse["variation"] = "D";
			else
				$horse["variation"] = "F";
		}
	}

?>
<!doctype html>

<html lang="en">
	<head>
		<title>Race Track 2000 - Horse <?= $horse["name"] ?></title>
		<!-- Bootstrap -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-widt, initial-scale=1">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<link rel="stylesheet" href="../css/horse.css" type="text/css">
		<script src="../js/userHorse.js"></script>
	</head>
	<body>
		<div class="container-fluid">
		<?php require 'userHeader.php' ?>
			<div class="row">
				<div class="col-lg-4 col-sm-6">
					<table class="table">
						<tr>
							<td><strong>Name:</strong></td>
							<td><?= $horse["name"] ?></td>
						</tr>
						<tr>
							<td><strong>Speed:</strong></td>
							<td><?= $horse["speed"] ?></td>
						</tr>
						<tr>
							<td><strong>Reliability:</strong></td>
							<td><?= $horse["reliability"] ?></td>
						</tr>
						<tr>
							<td><strong>Variation:</strong></td>
							<td><?= $horse["variation"] ?></td>
						</tr>
					</table>
				</div>
				<div class="col-lg-4 col-lg-offset-1 col-sm-6">
					<img src="../admin/horseProfileImgs/<?= $horse["profileimage"] ?>" alt="Picture of <?= $horse["name"] ?>" />
				</div>
			</div>

		</div>
	</body>
</html>