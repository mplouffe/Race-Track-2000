<?php

	require 'authenticateAdmin.php';

	if(!isset($_GET))
	{
		header("Location: adminUsers.php");
		die();
	}
	else
	{
		$userid = filter_input(INPUT_GET, 'userid', FILTER_VALIDATE_INT);

		if($userid == "")
		{
			header("Location: adminUsers.php");
			die();
		}
		else
		{
			$query = "SELECT * FROM users WHERE userid = :userid";
			$statement = $db->prepare($query);
			$statement->bindValue(":userid", $userid);
			$statement->execute();

			$user = $statement->fetch();
			$userBank =	'$' . number_format($user['account'], 2, '.', ','); 
		}
	}
?>
<!doctype html>

<html lang="en">
	<head>
		<title>Race Track 2000 - <?= $user["name"] ?></title>
		<!-- Bootstrap -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-widt, initial-scale=1">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<link rel="stylesheet" href="../css/horse.css" type="text/css">
		<script src="../js/adminUser.js"></script>
	</head>
	<body>
		<div class="container-fluid">
		<?php require 'adminHeader.php' ?>
			<div class="row">
				<div class="col-lg-4 col-sm-6">
					<table class="table">
						<tr>
							<td><strong>Name:</strong></td>
							<td><?= $user["username"] ?></td>
						</tr>
						<tr>
							<td><strong>Account:</strong></td>
							<td><?= $userBank ?></td>
						</tr>
					</table>
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4 col-sm-6">
					<button id="editUser" type="button" class="btn btn-default" value="<?= $user["userid"] . "-". $user["username"] ?>">Edit User</button>
				</div>
			</div>

		</div>
	</body>
</html>