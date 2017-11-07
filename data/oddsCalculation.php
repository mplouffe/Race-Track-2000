<?php

	if(isset($_POST))
	{
		session_start();

		$_SESSION["horses"] = [];
		
		$bank = $_SESSION["account"];
		$horses = $_SESSION["racers"];

		$winners = HorseRace($horses);
	
		$bet = [	'race' => $_POST["racetype"], 
					'wager' =>$_POST["picktype"], 
					'bet' =>$_POST["bet"], 
					'picks' => [$_POST["horse01"], $_POST["horse02"], $_POST["horse03"]]
				];

		$betResult = CheckBetResults($winners, $bet);

		UpdateUserBank($betResult);
	}
	
	function HorseRace($horses){
		$winners = [];
		for($i=0;$i<5;$i++)
		{
			$horses = CalculateOdds($horses);
			$winner = FindWinner($horses);

			$winners[$i] = $horses[$winner]['name'];
			unset($horses[$winner]);
			$horses = array_values($horses);
		}

		return $winners;
	}

	function FindWinner($horses) {
		$winner = rand(1, 100);
		$winnerFound = false;

		for($i=0;$i<count($horses) && !$winnerFound; $i++)
		{
			if($winner <= $horses[$i]['resultCheck'])
			{
				return $i;
			}
		}
	}


	function CalculateOdds($horses) {
		$total = 0;

		for($i=0;$i<count($horses); $i++)
		{
			$total += $horses[$i]['speed'];
		}

		for($i=0;$i<count($horses); $i++)
		{
			$horses[$i]['odds'] = ($horses[$i]['speed']/$total)*100;
			$horses[$i]['resultCheck'] = $horses[$i]['odds'];

			for($j=$i-1;$j>=0;$j--)
			{
				$horses[$i]['resultCheck'] += $horses[$j]['odds'];
			}
		}
		return $horses;
	} // end of CalculateOdds function


?>



<html lang="en">
	<head>
			<script src="https://ajax.googleapis.com/ajax/libs/jquery/3.1.1/jquery.min.js"></script>

			<script src="bettingForm.js"></script>
			<script src="jquery.numeric.js"></script>
			<!-- Bootstrap -->
			<meta charset="utf-8">
			<meta name="viewport" content="width=device-widt, initial-scale=1">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap.min.css" integrity="sha384-BVYiiSIFeK1dGmJRAkycuHAHRg32OmUcww7on3RYdg4Va+PmSTsz/K68vbdEjh4u" crossorigin="anonymous">
			<link rel="stylesheet" href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/css/bootstrap-theme.min.css" integrity="sha384-rHyoN1iRsVXV4nD0JutlnGaslCJuC7uwjduW9SVrLvRYooPp2bWYgmgJQIXwl/Sp" crossorigin="anonymous">
			<script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.7/js/bootstrap.min.js" integrity="sha384-Tc5IQib027qvyjSMfHjOMaLkfuWVxZxUPnCJA7l2mCWNIpG9mGCD8wGNIcPD7Txa" crossorigin="anonymous"></script>

			<link rel="stylesheet" href="css/bettingsheet.css" type="text/css">
	</head>
	<body>                                                                        

		<table>
			<tr>
				<th colspan="2">Results</th>
			</tr>
			<tr>
				<td>Winner</td>
				<td><?= $winners[0] ?></td>
			</tr>
			<tr>
				<td>2nd</td>
				<td><?= $winners[1] ?></td>
			</tr>
			<tr>
				<td>3rd</td>
				<td><?= $winners[2] ?></td>
			</tr>
			<tr>
				<td>4th</td>
				<td><?= $winners[3] ?></td>
			</tr>
			<tr>
				<td>5th</td>
				<td><?= $winners[4] ?></td>
			</tr>
		</table>			
		<?php if($betResult < 0): ?>
			<h1>You Loose</h1>
			<p> You lost <?= $betResult ?></p>
			<p> You currently have <?= $_SESSION['account'] ?></p>
		<?php else: ?>
			<h1>You Win</h1>
			<p> You won <?= $betResult ?></p>
			<p> You currently have <?= $_SESSION['account'] ?></p>
		<?php endif ?>
		<button id="goHome" type="submit" class="btn btn-default">Return to User Window</button>
	</body>
	<script>
		$(document).ready(function()
		{
			$("#goHome").on("click", function(){
				$(location).attr("href", "user.php");
			});
		});
	</script>
</html>