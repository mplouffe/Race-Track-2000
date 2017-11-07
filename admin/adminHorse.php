<
?php

	require 'authenticateAdmin.php';

	if(!isset($_GET))
	{
		header("Location: adminHorses.php");
		die();
	}
	else
	{
		$horseid = filter_input(INPUT_GET, 'horseid', FILTER_VALIDATE_INT);

		if($horseid == "")
		{
			header("Location: adminHorses.php");
			die();
		}
		else
		{
			$query = "SELECT * FROM horses WHERE horseid = :horseid";
			$statement = $db->prepare($query);
			$statement->bindValue(":horseid", $horseid);
			$statement->execute();

			$horse = $statement->fetch();
		}

		if(isset($_POST["delete"]) && $_POST["delete"] == "remove" && $horse["profileimage"] != "defaultprofile.jpg")
		{
			$fileName = $horse["profileimage"];
			$subFolder = "horseProfileImgs";
			$currentFolder = dirname(__FILE__);
			$pathSegments = [$currentFolder, $subFolder, $fileName];
			$filePath = join(DIRECTORY_SEPARATOR, $pathSegments);
			
			if(is_writeable($filePath))
			{
				unlink($filePath);
			}

			$query = "UPDATE horses SET profileimage = :profileimage WHERE horseid = :horseid";
			$statement = $db->prepare($query);
			$statement->bindValue(":horseid", $horse["horseid"]);
			$statement->bindValue(":profileimage", "defaultprofile.jpg");
			$statement->execute();

			$horse["profileimage"] = "defaultprofile.jpg";
		}
		else if(isset($_POST["submit"]) && $_POST["submit"] == "Upload")
		{

			if(isset($_FILES['uploadImage']) && $_FILES['uploadImage']['error'] === 0)
			{
				// the folder where we're going to store the uploads
				$uploadSubFolder = 'horseProfileImgs';

				// get info about the file to process it
				$fileName = $_FILES['uploadImage']['name'];
				$tempFilePath = $_FILES['uploadImage']['tmp_name'];

				// set up where we're gonna save the file
				$currentFolder = dirname(__FILE__);
				$pathSegments = [$currentFolder, $uploadSubFolder, basename($fileName)];
				$newFilePath = join(DIRECTORY_SEPARATOR, $pathSegments);

				// check the filetype to make sure it satisfies our critera
				if(fileTypeCheck($tempFilePath, $newFilePath))
				{
					// resize the image if necessary
					$maxDimW = 300;
					$maxDimH = 200;
					list($width, $height, $type, $attr) = getimagesize($tempFilePath);
					if($width > $maxDimW || $height > $maxDimH)
					{
						$targetFileName = $tempFilePath;
						$ratio = $width/$height;
						if($ratio > 1)
						{
							$newWidth = $maxDimW;
							$newHeight = $maxDimH/$ratio;
						}
						else
						{
							$newWidth = $maxDimW*$ratio;
							$newHeight = $maxDimH;
						}
						$src = imagecreatefromString(file_get_contents($tempFilePath));
						$dst = imagecreatetruecolor($newWidth, $newHeight);
						imagecopyresampled($dst, $src, 0, 0, 0, 0, $newWidth, $newHeight, $width, $height);
						imagedestroy($src);
						imagejpeg($dst, $targetFileName);
						imagedestroy($dst);
					}
					// move the file
					move_uploaded_file($tempFilePath, $newFilePath);

					// associate the new image with the profile of the horse
					$query = "UPDATE horses SET profileimage = :profileimage WHERE horseid = :horseid";
					$statement = $db->prepare($query);
					$statement->bindValue(":profileimage", $fileName);
					$statement->bindValue(":horseid", $horse["horseid"]);
					$statement->execute();

					$horse["profileimage"] = $fileName;
				}
			}
		}
	}

	// checks our file to make sure it is one of the valid types we've outlined
	function fileTypeCheck($temporaryPath, $newPath)
	{
		// set up arrays of allowable types
		$allowedMimeTypes = ['image/gif', 'image/jpeg', 'image/png'];
		$allowedFileExtensions = ['gif', 'jpg', 'jpeg', 'png'];
		
		// get the file extension
		$actualFileExtension = strtolower(pathinfo($newPath, PATHINFO_EXTENSION));
		// check for validity
		$fileExtensionIsValid = in_array($actualFileExtension, $allowedFileExtensions);

		// set up our return variable
		$mimeTypeIsValid = false;

		// make sure the extenion is valid
		if($fileExtensionIsValid)
		{
			$actualMimeType = getimagesize($temporaryPath)['mime'];
			// make sure the mime type is in or valid array
			$mimeTypeIsValid = in_array($actualMimeType, $allowedMimeTypes);
		}
		// return the results of our checks
		return $fileExtensionIsValid && $mimeTypeIsValid;
	}	

?>
<!doctype html>

<html lang="en">
	<head>
		<title>Race Track 2000 - Horse <?= $horse["name"] ?></title>
		<!-- Bootstrap -->
		<meta charset="utf-8">
		<meta name="viewport" content="width=device-widt, initial-scale=1">

		<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
		<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
		<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

		<link rel="stylesheet" href="../css/horse.css" type="text/css">
		<script src="../js/adminHorse.js"></script>
	</head>
	<body>
		<div class="container-fluid">
		<?php require 'adminHeader.php' ?>
			<div class="row">
				<div class="col-lg-4 col-sm-6">
					<table class="table">
						<tr>
							<td><strong>Name:</strong></td>
							<td><?= $horse["name"] ?></td>
						</tr>
						<tr>
							<td><strong>Speed:</strong></td>
							<td><?= $horse["speed"] ?></td>
						</tr>
						<tr>
							<td><strong>Reliability:</strong></td>
							<td><?= $horse["reliability"] ?></td>
						</tr>
						<tr>
							<td><strong>Variation:</strong></td>
							<td><?= $horse["variation"] ?></td>
						</tr>
					</table>
				</div>
				<div class="col-lg-4 col-lg-offset-1 col-sm-6">
					<img src="horseProfileImgs/<?= $horse["profileimage"] ?>" alt="Picture of <?= $horse["name"] ?>" />
				</div>
			</div>
			<div class="row">
				<div class="col-lg-4 col-sm-6">
					<button id="editHorse" type="button" class="btn btn-default" value="<?= $horse["horseid"] . "-". $horse["name"] ?>">Edit Horse</button>
				</div>
				<div class="col-lg-4 col-lg-offset-1 col-sm-6">
				    <form id="uploadImageForm" method="post" enctype="multipart/form-data">
				    	<div class="form-group">
	    					<label for="uploadImage">Profile Image: <span id="profileImage"><?= $horse["profileimage"] ?></span></label><br/>
							<input type="file" name="uploadImage" id="uploadImage" />
		    				<input class="imageupload" type="submit" name="submit" value="Upload" /><br/>
		    				<input id="deleteImage" class="imageupload" type="submit" name="delete" value="Delete"/>
		    			</div>
    				</form>
				</div>
			</div>

		</div>
	</body>
</html>