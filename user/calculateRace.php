<?php

	require 'authenticateUser.php';

	if(!isset($_POST) || $_POST == [] || $_SESSION["racers"] == [])
	{
		echo ("null");
		die();
	}
	else
	{
		$_SESSION["horses"] = [];

		$horses = $_SESSION["racers"];

		$horses = calculateQuarterSpeeds($horses);

		$winners = calculateWinners($horses);

		$bet = [	'race' => $_POST["racetype"], 
					'wager' =>$_POST["picktype"], 
					'bet' =>$_POST["bet"], 
					'picks' => [$_POST["horse01"], $_POST["horse02"], $_POST["horse03"]]
		];

		$betResult = CheckBetResults($winners, $bet);

		UpdateUserBank($betResult, $user, $db);
		UpdateBetTable($betResult, $bet, $db);
		$dataReturn = [$bet, $betResult, $horses, $winners];
		$_SESSION["racers"] = [];
		echo json_encode($dataReturn);
	}

	// run the race to calculate the results
	function calculateWinners($horses)
	{
		// calculate the race results
		$results = [];
		for($i=0; $i<5;$i++)
		{
			$time = 0;
			for($j=0; $j<4;$j++)
			{
				$time += 180 / abs($horses[$i]["race"][$j]);
			}

			$currentHorse = $horses[$i];
			for($j=0;$j<count($results);$j++)
			{
				if($time < $results[$j]["result"])
				{
					$tempResults = $results[$j]["result"];
					$tempHorse = $results[$j]["horse"];

					$results[$j]["result"] = $time;
					$results[$j]["horse"] = $currentHorse;

					$time = $tempResults;
					$currentHorse = $tempHorse;
				}
			}

			$results[$i]["result"] = $time;
			$results[$i]["horse"] = $currentHorse;
		}

		for($i=0;$i<count($results);$i++)
		{
			$winners[$i] = $results[$i]["horse"];
		}

		return $winners;
	}

	// used to calculate the speed chunks for the horses
	function calculateQuarterSpeeds($horses)
	{
		// Calculate the quater speeds for the horses
		$j = 0;
		foreach($horses as $racingHorse)
		{
			for($i = 0; $i<4; $i++)
			{
				$chance = mt_rand(1,100);
				$multiplier = abs($chance - 50) - (100 - $racingHorse["reliability"]);
				if($chance < 50)
				{
					$multiplier *= -1;
				}

				$speedFactor = (0.7 * ($racingHorse["variation"]/100)) * $multiplier;
				$quaterSpeeds[$i] = 0.70 * (($racingHorse["speed"] / 100) + $speedFactor);
			}

			$horses[$j]["race"] = [
											$quaterSpeeds[0], 
											$quaterSpeeds[1], 
											$quaterSpeeds[2], 
											$quaterSpeeds[3]
										];
			$j++;
		}
		return $horses;
	}

	// check bet results
	function CheckBetResults($results, $bet){

		$modifier = 0;
		if($bet['race'] == "single")
		{
			$pick = $bet['picks'][0];
			switch($bet['wager'])
			{
				case "show":
					if($results[0]['name'] == $pick || $results[1]['name'] == $pick || $results[2]['name'] == $pick)
					{$win = true; $modifier = 1.5;}
					else {$win = false;}
					break;
				case "place":
					if($results[0]['name'] == $pick || $results[1]['name'] == $pick)
					{$win = true; $modifier = 2;}
					else {$win = false;}
					break;
				case "win":
					if($results[0]['name'] == $pick)
						{$win = true; $modifier = 3;}
					else{$win = false;}
					break;
			}
		}
		else if($bet['race']  == "multi")
		{
			switch($bet['wager'])
			{
				case "quinella":
					if( ($results[0]['name'] == $bet['picks'][0] || $results[1]['name'] == $bet['picks'][0]) &&
						($results[0]['name'] == $bet['picks'][1] || $results[1]['name'] == $bet['picks'][1]))
					{$win = true; $modifier = 4;}
					else {$win = false;}
					break;
				case "exacta":
					if($results[0]['name'] == $bet['picks'][0] && $results[1]['name'] == $bet['pick'][1])
					{$win = true;}
					else {$win = false; $modifier = 5;}
					break;
				case "trifecta":
					if($results[0]['name'] == $bet['picks'][0] && $results[1]['name'] == $bet['picks'][1] && $results[2]['name'] == $bet['picks'][2])
					{$win = true; $modifier = 6;}
					else {$win = false;}
					break;
			}
		}
	
		if($win)
		{
			$payout = $bet['bet'] * $modifier;
		}
		else
		{
			$payout = $bet['bet'] * -1;
		}

		return $payout;
	}

	function UpdateUserBank($betResult, $user, $db)
	{
		$user['account'] = $user['account'] + $betResult;
		$query = "UPDATE users SET account = :account WHERE userid = :id";
		$statement = $db->prepare($query);
		$statement->bindValue(':account', $user['account']);
		$statement->bindValue(':id', $_SESSION['userid']);
		$statement->execute();
	}

	function UpdateBetTable($betResult, $bet, $db)
	{
		if($betResult > 0)
		{
			$result = "W";
		}
		else
		{
			$result = "L";
		}
		$query = "	INSERT INTO bets (userid, result, amount, racetype, horse1, horse2, horse3)
					VALUES (:userid, :result, :amount, :racetype, :horse1, :horse2, :horse3)";
		$statement = $db->prepare($query);
		$statement->bindValue(":userid", $_SESSION["userid"]);
		$statement->bindValue(":result", $result);
		$statement->bindValue(":amount", $betResult);
		$statement->bindValue(":racetype", $bet["wager"]);
		$statement->bindValue(":horse1", $bet["picks"][0]);
		if($bet["wager"] == "show" || $bet["wager"] == "place" || $bet["wager"] == "win")
		{
			$statement->bindValue(":horse2", NULL);
			$statement->bindValue(":horse3", NULL);
		}
		else if($bet["wager"] == "quinella" || $bet["wager"] == "exacta")
		{
			$statement->bindValue(":horse2", $bet["picks"][1]);
			$statement->bindValue(":horse3", NULL);
		}
		else
		{
			$statement->bindValue(":horse2", $bet["picks"][1]);
			$statement->bindValue(":horse3", $bet["picks"][2]);
		}

		$statement->execute();
	}






	// // just needed now to convert the horses from the old to the new format
	// // will be able to remove this once I get around to updated the horse stats
	// function convertHorses($horses)
	// {
	// 	// Convert the horses from the old "name"/"speed" format to the newer
	// 	// "name"/"speed"/"variation"/"reliability" format
	// 	$i = 0;
	// 	foreach($horses as $horse)
	// 	{
	// 		// right now just picking random numbers to fill out the form
	// 		// these will be attributed to individual horses
	// 		$variation = mt_rand(1,100) / 100;
	// 		$reliability = mt_rand(5, 30);
	// 		$convertedHorse[$i] = [	'name' => $horse["name"],
	// 								'speed' => $horse["speed"],
	// 								'variation' => $variation,
	// 								'reliability' => $reliability,
	// 								'race' => []
	// 							];
	// 		$i++;
	// 	}
	// 	return $convertedHorse;
	// }
?>
