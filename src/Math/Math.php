<?php

namespace App\Math;

class Math
{
	function getOverallStats($games, $team) {

		$overall_stats = [
			"games" => 0,
			"wins" => 0,
			"draws" => 0,
			"looses" => 0
		];

		foreach ($games as $game) {

			if (!empty($game["result"])) {

				$result = $this->getWinner($game);

				$overall_stats["games"]++;

				if ($result == $team) {
					$overall_stats["wins"]++;
				} elseif ($result == "draw") {
					$overall_stats["draws"]++;
				} else {
					$overall_stats["looses"]++;
				}


			}
		}

		return $overall_stats;
	}

	function getWinner($game) {

		$result_arr = explode(":", $game["result"]);

		$score_home = $result_arr[0];
		$score_away = $result_arr[1];

		if ($score_home > $score_away) {
			return $game["home"];
		} elseif ($score_home == $score_away) {
			return "draw";
		} else {
			return $game["away"];
		}
	}

	function getwinningChance($teamdata) {

		$wins = $teamdata['wins'];
		$ties = $teamdata['draws'];
		$games = $teamdata['games'];

		$percentage = ($wins+(0.5 * $ties))/$games;

		return round($percentage, 3);
	}

}