<?php

	$formHasErrors = false;
	require 'authenticateAdmin.php';
	
	if(isset($_POST) && $_POST != [])
	{
		$userid = filter_input(INPUT_POST, 'userid', FILTER_VALIDATE_INT);
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$account = filter_input(INPUT_POST, 'account', FILTER_VALIDATE_INT);
		
		$resetPassword = isset($_POST['resetpassword']);

		if(isset($_POST['admin']))
		{
			$admin = filter_input(INPUT_POST, 'admin');
		}
		if($resetPassword)
		{
			$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
			$passwordConfirm = filter_input(INPUT_POST, 'passwordConfirm', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		}


		// server side validation PARTY!!!
		$errorMessage = "";
		// make sure there is a userid
		if(!isset($userid))
		{
			$errorMessage .= "Invalid userid.<br/>";
		}
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
		if(isset($_POST['resetpassword']))
		{
			if(!isset($password) || $password != $passwordConfirm || strlen($password) < 4)
			{
				$errorMessage .= "Invalid password entry.<br/>";
			}
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
				if($user["userid"] != $userid)
				{
					$errorMessage .= "Username already exists in database.";
					$usernameError = true;
				}
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

				if($resetPassword)
				{
					$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
					$query = "	UPDATE users SET username = :username, account = :account, password = :password, admin = :admin WHERE userid = :userid";
					$statement = $db->prepare($query);
					$statement->bindValue(":username", $username);
					$statement->bindValue(":account", $account);
					$statement->bindValue(":password", $hashedPassword);
					$statement->bindValue(":userid", $userid);
					$statement->bindValue(":admin", $admin);
				}
				else
				{
					$query = " UPDATE users SET username = :username, account = :account, admin = :admin WHERE userid = :userid";
					$statement = $db->prepare($query);
					$statement->bindValue(":username", $username);
					$statement->bindValue(":account", $account);
					$statement->bindValue(":userid", $userid);
					$statement->bindValue(":admin", $admin);
				}

				$statement->execute();
				header('Location: admin.php');
				die();
			}
		}

		if($errorMessage != "")
		{
			$formHasErrors = true;
		}
	}


	if(!isset($_GET) && !$formHasErrors)
	{
		header('Location: admin.php');
		die();
	}
	else if($formHasErrors)
	{
		$row = $_POST;
		if(!isset($_POST['admin']))
		{
			$row['admin'] = "";
		}
	}
	else
	{
		$separatorLocation = strpos($_GET["dropDownSelect"], "-");
		$userid = substr($_GET["dropDownSelect"], 0, $separatorLocation);

		$query = "	SELECT 	*
					FROM 	users 
					WHERE 	userid = :id";
		$statement = $db->prepare($query);
		$statement->bindValue(":id", $userid);
		$statement->execute();

		$row = $statement->fetch(PDO::FETCH_ASSOC);
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

		<script src="../js/adminEditUser.js"></script>
		<link rel="stylesheet" type="text/css" href="../css/adminEditUser.css"/>

	</head>
	<body>
		<div class="container-fluid">
			<header>
				<h1>Admin Page</h1>
			</header>

			<?php if($formHasErrors): ?>
				<div class="row">
					<div class="col-sm-6 col-sm-offset-1 col-xs-6 col-xs-offset-1">
						<strong>Submission Error</strong>
						<p>The following errors were encountered with your submission</p>
						<p><?= $errorMessage ?></p>
					</div>
				</div>
			<?php endif ?>

			<form id="editUserForm" method="post">
				<div class="row">
					<div class="form-group col-sm-6 col-sm-offset-1 col-xs-6 col-xs-offset-1">
						<label class="inputlabel" for="userid">User Id:</label>
						<input type="text" class="form-control" id="userid" name="userid" value="<?= $row['userid'] ?>" />
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6 col-sm-offset-1 col-xs-6 col-xs-offset-1">
						<label class="inputlabel" for="username">Username:</label>
						<input type="text" class="form-control" id="username" name="username" value="<?= $row['username'] ?>"/>
						<div class="alert alert-warning" id="usernameError">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6 col-sm-offset-1 col-xs-6 col-xs-offset-1">
						<div id="adminCheck" class="checkbox">
							<label>
								<?php if($row["admin"] == "unlock"): ?>
									<input id="adminCheckbox" type="checkbox" name="admin" value="unlock" checked/>
								<?php else: ?>
									<input id="adminCheckbox" type="checkbox" name="admin" value="unlock" />
								<?php endif ?>
								<strong>Make Admin</strong>
							</label>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6 col-sm-offset-1 col-xs-6 col-xs-offset-1">
						<label class="inputlabel" for="accountFunds">Bank Account:</label>
						<input type="text" class="form-control" id="account" name="account" value="<?= $row['account'] ?>"/>
						<div class="alert alert-warning" id="accountError">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6 col-sm-offset-1 col-xs-6 col-xs-offset-1">
						<label class="btn btn-default">
							<input type="checkbox" name="resetpassword" value="true"  data-toggle="collapse" data-target="#resetPassword" hidden="true" />
							Reset Password
						</label>
					
						<div id="resetPassword" class="collapse">
							<div class="row">
								<div class="form-group col-sm-11 col-sm-offset-1 col-xs-11 col-xs-offset-1">
									<label class="inputlabel" for="password">New Password:</label>
									<input type="password" class="form-control" id="password" name="password" />
								</div>
							</div>
							<div class="row">
								<div class="form-group col-sm-11 col-sm-offset-1 col-xs-11 col-xs-offset-1">
									<label class="inputlabel" for="passwordConfirm">Confirm Password:</label>
									<input type="password" class="form-control" id="passwordConfirm" name="passwordConfirm" />
								</div>
							</div>
							<div class="alert alert-warning" id="passwordError">
							</div>
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-4 col-sm-offset-1 col-xs-4 col-xs-offset-1">
						<button type="button" id="submitForm" class="btn btn-default">Submit Changes</button>
					</div>
					<div class="form-group col-sm-4 col-sm-offset-1 col-xs-4">
						<button type="button" id="cancel" class="btn btn-default">Cancel</button>
					</div>
				</div>
			</form>
		</div>
	</body>
</html>