<?php

?>

<html lang="en">
	<head>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

			<script src="../js/race.js"></script>
			<!-- Bootstrap -->
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-widt, initial-scale=1">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

			<!-- FOR GETTING THE POST INTO MY JAVASCRIPT -->
			<script type="text/javascript"> var $_POST = <?php echo !empty($_POST)?json_encode($_POST): 'null'; ?>;</script>

			<link rel="stylesheet" type="text/css" href="../css/custom.css">
	</head>
	<body>
		<div class="container-fluid">
			<?php require 'userHeader.php' ?>
			<div class="row">
				<div id="jumbotron">
					<canvas></canvas>
				</div>
			</div>

			<div id="raceResults" class="modal fade" role="dialog">
				<div class="modal-dialog">
					<div class="modal-content">
						<div class="modal-header">
							<h2 class="modal-title">Results</h2>
						</div>
						<div class="modal-body">
							<table id="resultsTable" class="table">
								<tr>
									<td>Winner</td>
									<td id="first"></td>
								</tr>
								<tr>
									<td>2nd</td>
									<td id="second"></td>
								</tr>
								<tr>
									<td>3rd</td>
									<td id="third"></td>
								</tr>
								<tr>
									<td>4th</td>
									<td id="fourth"></td>
								</tr>
								<tr>
									<td>5th</td>
									<td id="fifth"></td>
								</tr>
							</table>
							<div id="resultText">
							</div>
						</div>
						<div class="modal-footer">
							<div class="col-xs-12">
								<button id="goHome" type="submit" class="btn btn-default col-xs-4 col-xs-offset-4">Return to User Window</button>
							</div>
						</div>
					</div>
				</div>
			</div>
		</div>
	</body>
</html>