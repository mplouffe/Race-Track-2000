<?php
	
	require 'authenticateAdmin.php';

	$query = "SELECT * FROM users";
	$statement = $db->prepare($query);
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
		<script src="../js/adminUsers.js"></script>
	</head>
	<body>
		<div class="container-fluid">
			<?php require 'adminHeader.php'; ?>

			<div class="row">
				<div class="col-xs-12">
					<table id="userTable" class="table">
						<tbody>
						<tr>
							<th id="userid" class="col-xs-2"><a href="#">User ID</a></th>
							<th id="username" class="col-xs-4"><a href="#">Username</a></th>
							<th id="useraccount" class="col-xs-4"><a href="#">Account</a></th>
							<th id="useradmin" class="col-xs-2"><a href="#">Admin</a></th>
						</tr>
						<?php foreach($results as $user): ?>
							<tr>
								<td><?= $user["userid"] ?></td>
								<td><a href="adminUser.php?userid=<?= $user["userid"] ?>"><?= $user["username"] ?></a></td>
								<td><?= $user["account"] ?></td>
								<td>
									<?php if($user["admin"] == 'unlock'): ?>true<?php endif ?>
								</td>
							</tr>
						<?php endforeach ?>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</body>
</html>