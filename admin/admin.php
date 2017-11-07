<?php

	require 'authenticateAdmin.php';
	
	if(isset($_POST['logout']))
	{
		$_SESSION = [];
		header('Location: /index.php');
		die();
	}
?>

<!doctype html>
<html lang="en">
	<head>
		<title>Race Track 2000</title>
		<!-- Bootstrap -->
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-widt, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<script src="../js/admin.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/admin.css" />

	</head>
	<body>
		<div class="container-fluid">
			<?php require 'adminHeader.php' ?>
			<article>
				<h2>Admin Menu</h2>
				<table class="table">
					<tr>
						<th>Users</th>
						<th>Horses</th>
						<th>Stats</th>
					</tr>
					<tr>
						<td><a class="btn btn-info" href="adminCreateUser.php">Create User</a></td>
						<td><a class="btn btn-info" href="adminCreateHorse.php">Create Horse</a></td>
						<td><a href="stats.php&view=admin">Admin Stats View</a></td>
					</tr>
					<tr>
						<td><button type="button" class="btn btn-info" id="adminEditUser">Edit User</button></td>
						<td><button type="button" class="btn btn-info" id="adminEditHorse">Edit Horse</a></td>
						<td><a href="stats.php&view=user">User Stats View</a></td>
					</tr>
					<tr>
						<td><button type="button" class="btn btn-info" id="adminDeleteUser">Delete User</a></td>
						<td><button type="button" class="btn btn-info" id="adminDeleteHorse">Delete Horse</a></td>
					</tr>
				</table>
				<form method="post">
					<input name="logout" type="submit" class="btn btn-default" value="logout" />
				</form>
			</article>
		</div>

		<div id="crudPopUp" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h2 class="modal-title" id="crudHeader"></h2>
					</div>
					<form class="form-group" id="editForm" action="" method="get">
						<div class="modal-body">
							<label for="userSelect" id="crudDropDownLabel"></label>
							<select class="form-control" id="crudDropDown" name="dropDownSelect">
							</select>
						</div>
						<div class="modal-footer">
							<button id="submitForm" type="submit" class="btn btn-default"></button>
						</div>
					</form>
				</div>
			</div>
		</div>

		<div id="deletePopUp" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h2 class="modal-title" id="deleteHeader"></h2>
					</div>
					<div class="modal-body">
						<div class="row">
							<div class="col-sm-8 col-sm-offset-2">
								<label for="userSelect" id="deleteDropDownLabel"></label>
								<select class="form-control" id="deleteDropDown" name="deleteDropDownSelect">
								</select>
							</div>
						</div>
						<div id="objectOutput">
						</div>
					</div>
					<div id="deleteModalFooter" class="modal-footer">
					</div>
				</div>
			</div>
		</div>

		<div id="deleteConfirmPopUp" class="modal fade" role="dialog">
			<div class="modal-dialog">
				<div class="modal-content">
					<div class="modal-header">
						<button type="button" class="close" data-dismiss="modal">&times;</button>
						<h2 class="modal-title" id="deleteConfirmHeader">Delete Confirm</h2>
					</div>
					<div class="modal-body">
						<div class="row">
							<div id="deleteConfirmTextBox" class="col-sm-8 col-sm-offset-2">
							</div>
						</div>
					</div>
					<div class="modal-footer">
						<button id="deleteConfirmWindowClose" class="btn btn-default">Close</button>
					</div>
				</div>
			</div>
		</div>

	</body>
</html>
