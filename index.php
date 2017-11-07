<?php
	
	$loginError = false;

	if(isset($_POST['login']))
	{
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		if($username != '' && $password != '')
		{
			// connect to the db
			require 'data/connect.php';
			// query the db for the user information
			$query = " 	SELECT *
						FROM users 
						WHERE username = :username";
			$statement = $db->prepare($query);
			$statement->bindValue(':username', $username, PDO::PARAM_STR);
			$statement->execute();

			// check the query for user information
			$user = $statement->fetch(PDO::FETCH_ASSOC);
			
			if($user == null)
			{
				$loginError = true;
				$loginErrorMessage = "Invalid username/password combination.";
			}
			else
			{
				if(password_verify($password, $user['password']))
				{
					session_start();
					$_SESSION['userid'] = $user['userid'];
					
					if($user['admin'] != null)
					{
						header('Location: admin/admin.php');
						die();
					}
					else
					{
						header('Location: user/user.php');
						die();
					}
				}
				else
				{
					$loginError = true;
					$loginErrorMessage = "Invalid username/password combination.";
				}
			}
		}
		else
		{
			$loginEror = true;
			$loginErrorMessage = "Invalid user name/password provided.";
		}
	}

	if(isset($_POST['register']))
	{
		// send the user to the register page
		header('Location: register.php');
		die();
	}

?>

<!doctype html>
<html lang="en">
	<head>
		<title>Race Track 2000</title>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
		<!-- Bootstrap -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-width, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<link rel="stylesheet" type="text/css" href="css/custom.css">
	</head>
	<body>
		<div class="container-fluid">
			<div class="page-header">
				<h1>Race Track 2000</h1>
			</div>
			<div class="row">
				<div id="frontPageSplash" class="jumbotron">
					<canvas></canvas>
				</div>
			</div>
			<form method="post">
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label for="username">User Name:</label>
							<input id="username" class="form-control" name="username" type="text" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<div class="form-group">
							<label for="password">Password:</label>
							<input id="password" class="form-control" name="password" type="password" />
						</div>
					</div>
				</div>
				<div class="row">
					<div class="col-sm-4">
						<input name="login" class="btn btn-primary" type="submit" value="login" />
						<input name="register" class="btn btn-primary" type="submit" value="register" />
					</div>
				</div>
			</form>
			<?php if($loginError): ?>
				<p><?= $loginErrorMessage ?></p>
			<?php endif ?>
		</div>
	</body>
</html>