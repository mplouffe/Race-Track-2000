<?php
	
	require 'authenticateAdmin.php';

	$query = "SELECT * FROM horses";
	$statement = $db->prepare($query);
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
		<script src="../js/adminHorses.js"></script>
	</head>
	<body>
		<div class="container-fluid">
			<?php require 'adminHeader.php'; ?>

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
								<td><a href="adminHorse.php?horseid=<?= $horse["horseid"] ?>"><?= $horse["name"] ?></a></td>
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