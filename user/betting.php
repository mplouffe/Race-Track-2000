<?php
	
	require 'authenticateUser.php';

	// if the horses session variable isn't set or empty, send them back to the user page
	if(!isset($_SESSION["horses"]) || $_SESSION["horses"] == [] || !isset($_GET))
	{
		header('Location: user.php');
		die();
	}

	// set the race variable to fetch the horses
	if($_GET["race"]=="01")
	{
		$race = "race01";
	}
	else if($_GET["race"]=="02")
	{
		$race = "race02";
	}
	else if($_GET["race"]=="03")
	{
		$race = "race03";
	}

	// get the racers from the horses session variable
	$_SESSION["racers"] = 
	[
		$_SESSION["horses"][$race]["horses"][0],
		$_SESSION["horses"][$race]["horses"][1],
		$_SESSION["horses"][$race]["horses"][2],
		$_SESSION["horses"][$race]["horses"][3],
		$_SESSION["horses"][$race]["horses"][4]
	];
?>

<!doctype html>
<html lang="en">
<head>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

		<script src="../js/bettingForm.js"></script>
		<script src="../js/jquery.numeric.js"></script>
		<!-- Bootstrap -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-widt, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<!-- My own CSS -->
		<link rel="stylesheet" href="../css/bettingsheet.css" type="text/css">
		
		<title>Race Track 2000: Betting Ticket</title>
</head>
<body>
	<div class="container-fluid">
		<?php require 'userHeader.php' ?>
		<div class="col-xs-12 col-sm-6 col-sm-offset-3">
			<table class="table">
				<tbody>
					<tr>
						<th>Horse</th>
						<th>Odds</th>
					</tr>
					<?php foreach($_SESSION["racers"] as $horse): ?>
						<tr>
							<td><?= $horse['name'] ?></td>
							<td><?= $horse['speed'] ?></td>
						</tr>
					<?php endforeach ?>
				</tbody>
			</table>
		</div>
		<div class="row">
			<div class="col-sm-6 col-sm-offset-3">
				<div class="col-sm-5 col-sm-offset-1">
					<button id="single" name="single"   type="button" class="btn btn-primary col-sm-12">Single Horse</button>
				</div>
				<div class="col-sm-5">
					<button id="multi" 	name="multi" 	type="button" class="btn btn-primary col-sm-12">Multi-Horse Bet</button>
				</div>
			</div>
		</div>

		<div class="row">
			<div id="singleType" class="singlePickClass col-sm-6 col-sm-offset-3">
				<div class="col-sm-4">
					<button id="singleShow" type="button" class="btn btn-primary col-sm-12">Show</button>
				</div>
				<div class="col-sm-4">
					<button id="singlePlace" type="button" class="btn btn-primary col-sm-12">Place</button>
				</div>
				<div class="col-sm-4">
					<button id="singleWin" type="button" class="btn btn-primary col-sm-12">Win</button>
				</div>
			</div>

		<div class="row">
			<div id="multiType" class="multiPickClass col-sm-6 col-sm-offset-3">
				<div class="col-sm-4">
					<button id="multiQuin" type="button" class="btn btn-primary col-sm-12" data-toggle="collapse" data-target="#quinella">Quinella</button>
				</div>
				<div class="col-sm-4">
					<button id="multiExac" type="button" class="btn btn-primary col-sm-12" data-toggle="collapse" data-target="#exacta">Exacta</button>
				</div>
				<div class="col-sm-4">
					<button id="multiTri" type="button" class="btn btn-primary  col-sm-12" data-toggle="collapse" data-target="#trifecta">Trifecta</button>
				</div>
			</div>
		</div>

		<div class="row">
			<table id="singlePickForm" class="pickForm col-sm-4 col-sm-offset-4">
				<tr>
					<th id="singlePickHeader" class="pickContents"></th>
				</tr>
				<tr>
					<td id="singlePickChoice" class="pickContents"></td>
				</tr>
			</table>

			<table id="multiPickForm" class="pickForm col-sm-6 col-sm-offset-3">
				<tr>
					<th id="multiPickHeader01" class="pickContents"></th>
					<th id="multiPickHeader02" class="pickContents"></th>
					<th id="multiPickHeader03" class="pickContents pickContentsThree"></th>
				</tr>
				<tr>
					<td id="multiPickChoice01" class="pickContents col-sm-4"></td>
					<td id="multiPickChoice02" class="pickContents col-sm-4"></td>
					<td id="multiPickChoice03" class="pickContents pickContentsThree col-sm-4"></td>				
				</tr>
			</table>
		</div>
		<div class="row">
			<div id="pickButtons" class="col-sm-12">
				<div class="col-sm-2 col-sm-offset-1">
					<button type="button" class="btn btn-primary pickButtons betButtons" id="horseA"><?= $_SESSION["racers"][0]["name"] ?></button>
				</div>
				<div class="col-sm-2">
					<button type="button" class="btn btn-primary pickButtons betButtons" id="horseB"><?= $_SESSION["racers"][1]["name"] ?></button>
				</div>
				<div class="col-sm-2">
					<button type="button" class="btn btn-primary pickButtons betButtons" id="horseC"><?= $_SESSION["racers"][2]["name"] ?></button>
				</div>
				<div class="col-sm-2">
					<button type="button" class="btn btn-primary pickButtons betButtons" id="horseD"><?= $_SESSION["racers"][3]["name"] ?></button>
				</div>
				<div class="col-sm-2">
					<button type="button" class="btn btn-primary pickButtons betButtons" id="horseE"><?= $_SESSION["racers"][4]["name"] ?></button>
				</div>
			</div>
		</div>

		<div id="placeBet">
			<div class="row">
				<div class="col-sm-6 col-sm-offset-3">
					<label for="betInput" class="betSection">Bet Amount</label>
					<input type="text" id="betInput" class="form-control betSection" name="bet"/>
				</div>
			</div>
			<div class="row">
					<button type="button" name="pickFom" class="btn btn-primary col-sm-4 col-sm-offset-4" id="betButton">Place Bet</button>
			</div>

				<div id="betError" class="alert alert-error">
				</div>
			</div>
		</div>


		<div id="betConfirm" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h2 class="modal-title">Confirm Your Bet</h2>
					</div>
					<form class="form-group" id="betForm" action="horseRace.php" method="post">
						<div class="modal-body">
							<table class="table">
								<tbody>
									<tr><td><strong>Race Type: </strong><span id="racetype"></span></td></tr>
									<tr><td><strong>Pick Type: </strong><span id="picktype"></span></td></tr>
									<tr><td><strong>Bet: </strong><span id="bet"></span></td></tr>
								</tbody>
							</table>
						</div>
						<div class="modal-footer">
							<div class="col-xs-6 col-xs-offset-1">
								<button type="submit" class="btn btn-default">Place Bet</button>
							</div>
						</div>
					</form>
				</div>
			</div>
		</div>
	</body>
</html>
