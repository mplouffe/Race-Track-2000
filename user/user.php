<?php
	require 'authenticateUser.php';

	if(isset($_POST['logout']))
	{
		$_SESSION = [];
		header('Location: ../index.php');
		die();
	}

	$currentAccount = '$' . number_format($user['account'], 2, '.', ',');

	if(!isset($_SESSION["horses"]) || $_SESSION["horses"] == [])
	{

		// get the total number of horses
		$query = "SELECT COUNT(1) AS totalHorses FROM horses";
		$statement = $db->prepare($query);
		$statement->execute();
		$results = $statement->fetch(PDO::FETCH_ASSOC);
		$totalHorses = $results["totalHorses"];

		// get a random set of horse numbers
		$numbers = range(1, $totalHorses);
		shuffle($numbers);
		$picks = array_slice($numbers, 0, 15);

		for($i = 0; $i < 15; $i = $i +5)
		{
			for($j = 0; $j < 5; $j++)
			{
				$query = "	SELECT *
							FROM horses 
							WHERE horseid = :id";
				$statement = $db->prepare($query);
				$statement->bindValue(':id', $picks[$i+$j], PDO::PARAM_STR);
				$statement->execute();
				$horse = $statement->fetch(PDO::FETCH_ASSOC);
				$pickedHorses[$j+$i] = $horse;
			}
		}

		$_SESSION["horses"] = [
			'race01' => [ 
				'identifier' => 01, 
				'horses' => [
					$pickedHorses[0],
					$pickedHorses[1],
					$pickedHorses[2],
					$pickedHorses[3],
					$pickedHorses[4]
				]
			],
			'race02' => [ 
				'identifier' => 02,
				'horses' => [
					$pickedHorses[5],
					$pickedHorses[6],
					$pickedHorses[7],
					$pickedHorses[8],
					$pickedHorses[9]
				]
			],
			'race03'=>[
				'identifier' => 03,
				'horses' => [
					$pickedHorses[10],
					$pickedHorses[11],
					$pickedHorses[12],
					$pickedHorses[13],
					$pickedHorses[14]
				]
			]
		];
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

		<link 	rel="stylesheet"
				href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css"
				integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u"
				crossorigin="anonymous" />
		<link 	rel="stylesheet"
				href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css"
				integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp"
				crossorigin="anonymous" />
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js"
				integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa"
				crossorigin="anonymous">
		</script>

		<link 	rel="stylesheet"
				href="../css/bettingsheet.css"
				type="text/css" />
		<script src="../js/userPage.js">
		</script>
	</head>
	
	<body>
		<div class="container-fluid">
			<div class="row">
				<div class="col-sm-1">
					<?php require '../shared/sideMenuBar.php' ?>
				</div>
				<div class="col-sm-11">				
					<?php require 'userHeader.php' ?>
					<h2><?= $user['username'] ?>'s Current Account: <?= $currentAccount ?></h2>
					<div class="row">
						<table class="table">
							<tr>
								<th>Race 01</th>
								<th>Race 02</th>
								<th>Race 03</th>
							</tr>
							<tr>
								<?php foreach($_SESSION["horses"] as $race): ?>
									<td>
										<table class="table">
											<tr>
												<th>Horse</th>
												<th>Odds</th>
											</tr>
											<?php foreach($race["horses"] as $horse): ?>
												<tr>
													<td><?= $horse['name'] ?></td>
													<td><?= $horse['speed'] ?></td>
												</tr>
											<?php endforeach ?>
											<tr>
												<td colspan="2">
													<input type="button" id="race0<?= $race["identifier"] ?>" class="btn btn-primary" value="Bet On Race <?= $race["identifier"] ?>">
												</td>
											</tr>
										</table>
									</td>
								<?php endforeach ?>
							</tr>
						</table>
					</div>

					<div class="row">
						<div class="col-sm-4">
							<form method="post">
								<input name="logout" type="submit" class="btn btn-default" value="logout" />
							</form>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>