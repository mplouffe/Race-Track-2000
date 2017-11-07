<?php
	require 'authenticateUser.php';

	if(isset($_POST['logout']))
	{
		$_SESSION = [];
		header('Location: ../index.php');
		die();
	}

	$currentAccount = '$' . number_format($user['account'], 2, '.', ',');

	$query = "SELECT * FROM bets WHERE userid = :userid ORDER BY betid DESC LIMIT 10";
	$statement = $db->prepare($query);
	$statement->bindValue(":userid", $_SESSION["userid"]);
	$statement->execute();

	$i = 0;
	while($row = $statement->fetch())
	{
		$betHistory[$i] = $row;
		$betHistory[$i]['picks'] = $row["horse1"];
		if($row["horse2"]  != NULL)
		{
			$betHistory[$i]['picks'] .= ", " . $row["horse2"];
		}
		if($row["horse3"] != NULL)
		{
			$betHistory[$i]['picks'] .= ", " . $row["horse3"];
		}
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
		<script src="../js/userPage.js"></script>
	</head>
	<body>
		<div class="container-fluid">
			<?php require 'userHeader.php' ?>
			<div class="row">
				<div class="col-sm-8">
					<h2><?= $user['username'] ?>'s Profile</h2>
				</div>
			</div>
			<div class="row">
				<table class="table">
					<tbody>
						<tr>
							<td><strong>Username:</strong></td>
							<td><?= $user['username'] ?></td>
						</tr>
						<tr>
							<td><strong>Account:</strong></td>
							<td><?= $currentAccount ?></td>
						</tr>
					</tbody>
				</table>
			</div>

			<div class="row">
				<div class="col-sm-6">
					<h3>Betting History</h3>
				</div>
				<table class="table">
					<tbody>
						<tr>
							<th>Result</th>
							<th>Bet Type</th>
							<th>Amount</th>
							<th>Picks</th>
						</tr>
						<?php foreach($betHistory as $bet): ?>
							<tr>
								<td><?= $bet['result'] ?></td>
								<td><?= $bet['racetype'] ?></td>
								<td><?= $bet['amount'] ?></td>
								<td><?= $bet['picks'] ?></td>
							</tr>
						<?php endforeach ?>
					</tbody>
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
	</body>
</html>