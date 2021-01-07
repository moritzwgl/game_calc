<?php

namespace App\Crawler;

use DateTime;
use KubAT\PhpSimple\HtmlDomParser;

class Crawler
{
	function crawlGameday($gameday) {

		$url = "https://www.sport.de/widget_gameplan_round-matchday/sp1/se35753/co12/ro109214/md" . $gameday;

		$html = HtmlDomParser::file_get_html($url);

		$date = $html->find('.match-date', 0)->plaintext;
		$date = explode(" ", $date)[0];
		$date = new DateTime($date);
		$week = $date->format("W");
		$year = $date->format("Y");

		$gameday_arr["gameday_info"] = [
			"date" => $week . "/" . $year
		];

		$games = $html->find('.match');
		foreach ($games as $game) {

			$home = $game->find('.team-name-home', 0)->plaintext;
			$away = $game->find('.team-name-away', 0)->plaintext;
			$result = $game->find('.match-result.match-result-0 a', 0)->plaintext;


			$games_arr[] = [
				"home" => $home,
				"away" => $away,
				"result" => $result
			];
		}

		$gameday_arr["games"] = $games_arr;

		return $gameday_arr;
	}

	function crawlLastResults($team) {

		$fcb_url = "https://www.sport.de/fussball/te209/bayern-muenchen/spiele-und-ergebnisse/";

		$html = HtmlDomParser::file_get_html($fcb_url);

		$results_html = $html->find('.hs-traditional-left-column .finished[data-competition_id="12"] .match-result a');
		foreach ($results_html as $result_html) {

			$results[] = $result_html->plaintext;
		}

		return $results;
	}

	function crawlTable($gameday) {
		$table_url = "https://www.sport.de/widget_standing_round-matchday/ro109214/md" . $gameday;

		$html = HtmlDomParser::file_get_html($table_url);

	}

}