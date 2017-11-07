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
		$horseid = filter_input(INPUT_POST, 'horseid', FILTER_VALIDATE_INT);
		$name = filter_input(INPUT_POST, 'name', FILTER_SANITIZE_FULL_SPECIAL_CHARS);
		$speed = filter_input(INPUT_POST, 'speed', FILTER_VALIDATE_INT);
		$reliability = filter_input(INPUT_POST, 'variation', FILTER_VALIDATE_INT);
		$variation = filter_input(INPUT_POST, 'variation', FILTER_VALIDATE_INT);

		// server side validation PARTY!!!
		$errorMessage = "";
		// make sure there is a horse name and it is at least 4 characters long
		if(!isset($name) || strlen($name) < 4)
		{
			$errorMessage .= "Invalid name.<br/>";
		}
		// make sure there is an speed value and that it is numeric
		if(!isset($speed) || !is_numeric($speed))
		{
			$errorMessage .= "Invalid speed value.<br/>";
		}
		else if($speed < 50 || $speed > 100)
		{
			$errorMessage .= "Speed must be between 50-100.<br/>";
		}

		if(!isset($reliability) || !is_numeric($reliability))
		{
			$errorMessage .= "Invalid reliability value.<br/>";
		}
		else if($reliability < 50 || $reliability > 100)
		{
			$errorMessage .= "Reliability must be between 50-100.<br/>";
		}

		if(!isset($variation) || !is_numeric($variation))
		{
			$errorMessage .= "Invalid variation value.<br/>";
		}
		else if($variation < 50 || $variation > 100)
		{
			$errorMessage .= "Variation must be between 50-100.<br/>";
		}

		if($errorMessage == "")
		{
			// check to make sure the username doesn't aleady exist in the database
			$query = "	SELECT *
						FROM horses 
						WHERE name = :name";
			$statement = $db->prepare($query);
			$statement->bindValue(':name', $name, PDO::PARAM_STR);
			$statement->execute();

			$horse = $statement->fetch(PDO::FETCH_ASSOC);

			$nameError = false;
			if($horse != null)
			{
				if($horse["horseid"] != $horseid)
				{
					$errorMessage .= "Horse name already exists in database.";
					$usernameError = true;
				}
			}

			if(!$nameError)
			{
				$query = " INSERT INTO horses (name, speed, reliability, variation) VALUES (:name, :speed, :reliability, :variation)";
				$statement = $db->prepare($query);
				$statement->bindValue(":name", $name);
				$statement->bindValue(":speed", $speed);
				$statement->bindValue(":reliability", $reliability);
				$statement->bindValue(":variation", $variation);

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


	if($formHasErrors)
	{
		$row = $_POST;
	}
	else
	{
		$row['name'] = "";
		$row['speed'] = "";
		$row['reliability'] = "";
		$row['variation'] = "";
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
		
		<script src="../js/jquery.numeric.js"></script>
		<script src="../js/adminCreateHorse.js"></script>

		<link rel="stylesheet" type="text/css" href="../css/adminEditUser.css"/>

	</head>
	<body>
		<div class="container-fluid">
			<?php require "adminHeader.php" ?>
			<?php if($formHasErrors): ?>
				<div class="row">
					<div class="col-sm-6 col-sm-offset-1 col-xs-6 col-xs-offset-1">
						<strong>Submission Error</strong>
						<p>The following errors were encountered with your submission</p>
						<p><?= $errorMessage ?></p>
					</div>
				</div>
			<?php endif ?>

			<form  id="createHorseForm" method="post">
				<div class="row">
					<div class="form-group col-sm-6 col-sm-offset-1 col-xs-6 col-xs-offset-1">
						<label class="inputlabel" for="name">Name:</label>
						<input type="text" class="form-control" id="name" name="name" value="<?= $row['name'] ?>"/>
						<div class="alert alert-warning" id="nameError">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6 col-sm-offset-1 col-xs-6 col-xs-offset-1">
						<label class="inputlabel" for="speed">Speed:</label>
						<input type="text" class="form-control" id="speed" name="speed" value="<?= $row['speed'] ?>"/>
						<div class="alert alert-warning" id="speedError">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6 col-sm-offset-1 col-xs-6 col-xs-offset-1">
						<label class="inputlabel" for="reliability">Reliability:</label>
						<input type="text" class="form-control" id="reliability" name="reliability" value="<?= $row['reliability'] ?>"/>
						<div class="alert alert-warning" id="reliabilityError">
						</div>
					</div>
				</div>
				<div class="row">
					<div class="form-group col-sm-6 col-sm-offset-1 col-xs-6 col-xs-offset-1">
						<label class="inputlabel" for="variation">Variation:</label>
						<input type="text" class="form-control" id="variation" name="variation" value="<?= $row['variation'] ?>"/>
						<div class="alert alert-warning" id="variationError">
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