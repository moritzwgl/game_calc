<?php

namespace App\Crawler;

use DateTime;
use KubAT\PhpSimple\HtmlDomParser;

class Crawler
{

	// Holt sich mithilfe der Tabelle alle Teams und deren Namen
	function crawlTeams($url){

		$html = HtmlDomParser::file_get_html($url);
		$rows = $html->find('.standing');

		foreach ($rows as $row){
			$teams[] = $row->find('.team-name a', 0)->plaintext;
		}

		return $teams;
	}

	// Holt sich mithilfe der Tabelle alle Statistiken der Teams
	function crawlTeamsStats($url) {

		$html = HtmlDomParser::file_get_html($url);
		$rows = $html->find('.standing');

		foreach ($rows as $row){

			$teams_stats[] = [
				"team" => $row->find('.team-name a', 0)->plaintext,
				"games" => $row->find('.standing-games_played', 0)->plaintext,
				"wins" => $row->find('.standing-win', 0)->plaintext,
				"draws" => $row->find('.standing-draw', 0)->plaintext,
				"looses" => $row->find('.standing-lost', 0)->plaintext,
				"goals" => $row->find('.standing-goaldiff', 0)->plaintext,
				"points" => $row->find('.standing-points', 0)->plaintext
			];
		}

		return $teams_stats;
	}

	function crawlGameday($url, $gameday){

		$html = HtmlDomParser::file_get_html($url . $gameday);

		$date = $html->find('.match-date', 0)->plaintext;
		$date = explode(" ", $date)[0];
		$date = new DateTime($date);
		$week = $date->format("W");
		$year = $date->format("Y");

		$gameday_arr = [
			"gameday" => $gameday,
			"date" =>  $week . "/" . $year
		];

		return $gameday_arr;
	}


	function crawlGamedayGames($url, $gameday) {

		$html = HtmlDomParser::file_get_html($url . $gameday);

		$rows = $html->find('.match');

		$gameday = $html->find('.match-round', 0)->plaintext;

		foreach ($rows as $row) {

			$home = $row->find('.team-name-home', 0)->plaintext;
			$away = $row->find('.team-name-away', 0)->plaintext;
			$result = $row->find('.match-result.match-result-0 a', 0)->plaintext;

			$games[] = [
				"gameday" => $gameday,
				"home" => $home,
				"away" => $away,
				"result" => $result
			];
		}

		return $games;
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



}