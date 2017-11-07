<?php
	
	require 'authenticateAdmin.php';

	// make sure the user is logged in and is an admin
	if(!isset($user['admin']) || $user['admin'] != 'unlock')
	{
		// if there isn't session data, send back to index
		header('location: ../index.php');
		die();
	}

	$formHasErrors = false;
	
	if(isset($_POST) && $_POST != [])
	{
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$account = filter_input(INPUT_POST, 'account', FILTER_VALIDATE_INT);
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$passwordConfirm = filter_input(INPUT_POST, 'passwordConfirm', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		if(isset($_POST['admin']))
		{
			$admin = filter_input(INPUT_POST, 'admin');
		}
		else
		{
			$admin = "false";
		}

		// server side validation PARTY!!!
		$errorMessage = "";
		// make sure there is a username and it is at least 4 characters long
		if(!isset($username) || strlen($username) < 4)
		{
			$errorMessage .= "Invalid username.<br/>";
		}
		// make sure there is an account value and that it is numeric
		if(!isset($account) || !is_numeric($account))
		{
			$errorMessage .= "Invalid account value.<br/>";
		}
		// check the passwords if a call to reset them has been sent
		if(!isset($password) || $password != $passwordConfirm || strlen($password) < 4)
		{
			$errorMessage .= "Invalid password entry.<br/>";
		}

		if($errorMessage == "")
		{
			// check to make sure the username doesn't aleady exist in the database
			$query = "	SELECT *
						FROM Users 
						WHERE username = :username";
			$statement = $db->prepare($query);
			$statement->bindValue(':username', $username, PDO::PARAM_STR);
			$statement->execute();

			$user = $statement->fetch(PDO::FETCH_ASSOC);

			$usernameError = false;
			if($user != null)
			{
				$errorMessage .= "Username already exists in database.";
				$usernameError = true;
			}

			if(!$usernameError)
			{
				if($admin == "true")
				{
					$admin = "unlock";
				}
				else
				{
					$admin = "";
				}

				$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
				$query = "INSERT INTO users (username, password, admin, account) VALUES (:username, :password, :admin, :account)";
				$statement = $db->prepare($query);
				$statement->bindValue(":username", $username);
				$statement->bindValue(":account", $account, PDO::PARAM_INT);
				$statement->bindValue(":password", $hashedPassword);
				$statement->bindValue(":admin", $admin);

				$statement->execute();
				header('Location: admin.php');
				die();			
			}
		}
	}

?>
<!doctype html>
<html lang="en">
	<head>
		<title>Race Track 2000</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<!-- Bootstrap -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-widt, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<script src="../js/adminCreateUser.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/adminEditUser.css"/>
	</head>
	<body>
		<div class="container-fluid">
			<?php require 'adminHeader.php' ?>
			<?php if($formHasErrors): ?>
				<div class="row">
					<div class="col-sm-8 col-sm-offset-1 col-xs-6 col-xs-offset-1">
						<strong>Submission Error</strong>
						<p>The following errors were encountered with your submission</p>
						<p><?= $errorMessage ?></p>
					</div>
				</div>
			<?php endif ?>

			<form id="createUserForm" method="post">
				<div class="row">
					<div class="form-group col-sm-6 col-sm-offset-1 col-xs-6 col-xs-offset-1">
							<label class="inputlabel" for="username">Username:</label>
							<input type="text" class="form-control" id="username" name="username" />
							<div class="alert" id="usernameError" error="">
							</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6 col-sm-offset-1 col-xs-6 col-xs-offset-1">
						<div id="adminCheck" class="checkbox">
							<label><input id="adminCheckBox" type="checkbox" name="admin" value="unlock" /><strong>Make Admin</strong></label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6 col-sm-offset-1 col-xs-6 col-xs-offset-1">
						<label class="inputlabel" for="password">Password:</label>
						<input type="password" class="form-control" id="password" name="password" />
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6 col-sm-offset-1 col-xs-6 col-xs-offset-1">
						<label class="inputlabel" for="passwordConfirm">Confirm Password:</label>
						<input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" />
					</div>
					<div class="alert alert-warning col-sm-6 col-sm-offset-1 col-xs-6 col-xs-offset-1" id="passwordError"></div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6 col-sm-offset-1 col-xs-6 col-xs-offset-1">
						<label class="inputlabel" for="accountFunds">Bank Account:</label>
						<input type="text" class="form-control" id="account" name="account" />
						<div class="alert alert-warning" id="accountError">
						</div>
					</div>
				</div>

				<div class="row">
					<div class="form-group col-sm-4 col-sm-offset-1 col-xs-4 col-xs-offset-1">
						<button type="button" id="submitForm" class="btn btn-default">Submit New User</button>
					</div>
					<div class="form-group col-sm-4 col-sm-offset-1 col-xs-4">
						<button type="button" id="cancel" class="btn btn-default">Cancel</button>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>