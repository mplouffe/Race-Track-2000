<?php
	
	$registrationError = false;

	if(isset($_POST['register']))
	{
		// get the sanitized version of the user input
		$username = filter_input(INPUT_POST, 'username', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$password = filter_input(INPUT_POST, 'password', FILTER_SANITIZE_FULL_SPECIAL_CHARS);

		// check for input errors
		if($_POST['password'] != $_POST['passwordConfirm'] )
		{
			$registrationError = true;
			$errorMessage = "Passwords do not match.";
		}
		else if($username != $_POST['username'])
		{
			$registrationError = true;
			$errorMessage = "Invalid characters used in userame.";
		}
		else if($password != $_POST['password'])
		{
			$registrationError = true;
			$errorMessage = "Invalid chracters used in password.";
		}
		else if(strlen($username) < 4)
		{
			$registrationError = true;
			$errorMessage = "Username must be at least 4 characters long.";
		}
		else if(strlen($password) < 4)
		{
			$registrationError = true;
			$errorMessage = "Password must be at least 4 characters long.";
		}

		if(!$registrationError)
		{
			require 'data/connect.php';

			// check to make sure the username doesn't aleady exist in the database
			$query = "	SELECT *
						FROM users 
						WHERE username = :username";
			$statement = $db->prepare($query);
			$statement->bindValue(':username', $username, PDO::PARAM_STR);
			$statement->execute();

			$user = $statement->fetch(PDO::FETCH_ASSOC);

			if($user != null)
			{
				$registrationError = true;
				$errorMessage = "Username already exists in database.";
			}
			else
			{
				// set up the values to create a new user in the database
				$hashedPassword = password_hash($password, PASSWORD_DEFAULT);
				// set up the query
				$query = "	INSERT INTO users (Username, Password, account) VALUES (:username, :hashedPassword, :account)";
				$statement = $db->prepare($query);
				$statement->bindValue(':username', $username);
				$statement->bindValue(':hashedPassword', $hashedPassword);
				$statement->bindValue(':account', 3000);
				// execute the insert
				$statement->execute();
				// redirect the user back to the main page
				header('Location: index.php');
				die();
			}
		}
	}

?>

<!doctype html>
<html lang="en">
	<head>
		<title>Race Track 2000</title>
		<!-- Bootstrap -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-widt, initial-scale=1">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>
		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>
	</head>
	<body>
		<div class="container-fluid">
			<header>
				<h1>Race Track 2000</h1>
			</header>
			<nav>
				<a href="index.php">Main</a>
			</nav>
			<article>
				<form method="post">
					<label for="username">User Name:</label>
					<input id="username" name="username" type="text" />
					<label for="password">Password:</label>
					<input id="password" name="password" type="password" />
					<label for="passwordConfirm">Re-Enter Password:</label>
					<input id="passwordConfirm" name="passwordConfirm" type="password" />
					<input name="register" type="submit" value="register" />
				</form>
				<?php if($registrationError): ?>
					<p><?= $errorMessage ?></p>
				<?php endif ?>
			</article>
		</div>
	</body>
</html>