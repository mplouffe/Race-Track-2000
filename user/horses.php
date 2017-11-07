<?php
	
	require 'authenticateUser.php';

	$query = "SELECT * FROM horses";
	$statement = $db->prepare($query);
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
?>
<!doctype html>

<html lang="en">
	<head>
		<title>Race Track 2000</title>
		<!-- Bootstrap -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-widt, initial-scale=1">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<link rel="stylesheet" href="../css/bettingsheet.css" type="text/css">
		<script src="../js/userHorses.js"></script>
	</head>
	<body>
		<div class="container-fluid">
			<?php require 'userHeader.php'; ?>

			<div class="row">
				<div class="col-xs-12">
					<table id="horseTable" class="table">
						<tbody>
						<tr>
							<th id="horseid" class="col-xs-2"><a href="#">Horse ID</a></th>
							<th id="horsename" class="col-xs-4"><a href="#">Name</a></th>
							<th id="horsespeed" class="col-xs-2"><a href="#">Speed</a></th>
							<th id="horsereliability" class="col-xs-2"><a href="#">Reliability</a></th>
							<th id="horsevariation" class="col-xs-2"><a href="#">Variation</a></th>
						</tr>
						<?php foreach($results as $horse): ?>
							<tr>
								<td><?= $horse["horseid"] ?></td>
								<td><a href="horse.php?horseid=<?= $horse["horseid"] ?>"><?= $horse["name"] ?></a></td>
								<td><?= $horse["speed"] ?></td>
								<td><?= $horse["reliability"] ?></td>
								<td><?= $horse["variation"] ?></td>
							</tr>
						<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>