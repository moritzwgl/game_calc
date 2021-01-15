<?php

namespace App\Service;

use App\Crawler\Crawler;
use App\Entity\Gameday;
use App\Entity\Games;
use App\Entity\Teams;
use App\Entity\TeamStats;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GamedayService extends AbstractController
{

	//Speichert ein Array mit Teams in die Datenbank
	public function saveTeams($teams) {

		$entityManager = $this->getDoctrine()->getManager();

		foreach ($teams as $team) {

			$teams_entity = new Teams();
			$teams_entity->setName($team);

			$entityManager->persist($teams_entity);
			$entityManager->flush();
		}
	}

	// Holt sich anhand des Teamnames die team_id aus der Tabelle teams und speichert diese mit den Statistiken in die Tabelle team_stats
	public function saveTeamsStats($teams_stats) {

		$entityManager = $this->getDoctrine()->getManager();

		foreach ($teams_stats as $team_stats) {

			$team_name = $team_stats["team"];

			$team = $this->getDoctrine()
				->getRepository(Teams::class)
				->findBy(["name" => $team_name]);

			$team_id = $team[0]->getId();

			$team_stats_entity = new TeamStats();

			$team_stats_entity->setTeamId($team_id);
			$team_stats_entity->setGames($team_stats["games"]);
			$team_stats_entity->setWins($team_stats["wins"]);
			$team_stats_entity->setDraws($team_stats["draws"]);
			$team_stats_entity->setLooses($team_stats["looses"]);
			$team_stats_entity->setGoals($team_stats["goals"]);
			$team_stats_entity->setPoints($team_stats["points"]);

			$entityManager->persist($team_stats_entity);
			$entityManager->flush();
		}
	}

	// Speichert den Spieltag in die Datenbank
	public function saveGameday($gameday_arr) {

		$entityManager = $this->getDoctrine()->getManager();

		$gameday = new Gameday();
		$gameday->setGameday($gameday_arr["gameday"]);
		$gameday->setDate($gameday_arr["date"]);

		$entityManager->persist($gameday);
		$entityManager->flush();
	}

	public function saveGames($games) {

		$entityManager = $this->getDoctrine()->getManager();

		foreach ($games as $game) {

			if (preg_match('/\d/', $game["result"])) {
				$result = $game["result"];
			} else {
				$result = "";
			}

			$home = $this->getDoctrine()
				->getRepository(Teams::class)
				->findBy(["name" => $game["home"]]);
			$home_id = $home[0]->getId();

			$away = $this->getDoctrine()
				->getRepository(Teams::class)
				->findBy(["name" => $game["away"]]);
			$away_id = $away[0]->getId();


			$gameday_num = explode(".", $game["gameday"])[0];

			$gameday = $this->getDoctrine()
				->getRepository(Gameday::class)
				->findBy(["gameday" => $gameday_num]);
			$gameday_id = $gameday[0]->getId();

			$games = new Games();
			$games->setGamedayId($gameday_id);
			$games->setHomeId($home_id);
			$games->setAwayId($away_id);
			$games->setResult($result);

			$entityManager->persist($games);
			$entityManager->flush();
		}
	}


	public function getAllGamedays() {

		$gamedays = $this->getDoctrine()
			->getRepository(Gameday::class)
			->findAll();

		/*
		if (!$gamedays) {
			throw $this->createNotFoundException(
				'No gamedays found'
			);
		}
		*/

		return $gamedays;
	}

	public function getGamedayById($id) {

		$gameday = $this->getDoctrine()
			->getRepository(Games::class)
			->findBy(["gameday" => $id]);

		if (!$gameday) {
			throw $this->createNotFoundException(
				'No gameday found with id ' . $id
			);
		}

		return $gameday;
	}

	public function getCurrentGameday() {

		$current_date = new DateTime(date("d.m.Y"));
		$current_week = $current_date->format("W");
		$current_year = $current_date->format("Y");
		$current_date = $current_week . "/" . $current_year;

		$gameday = $this->getDoctrine()
			->getRepository(Gameday::class)
			->findBy(["date" => $current_date]);

		/*
		if (!$gameday) {
			throw $this->createNotFoundException(
				'No gameday found with date ' . $current_date
			);
		}
		*/

		if (empty($gameday)) {
			return $gameday;
		} else {
			$gameday = end($gameday)->getGameday();

			$games = $this->getDoctrine()
				->getRepository(Games::class)
				->findBy(["gameday" => $gameday]);

			if (!$games) {
				throw $this->createNotFoundException(
					'No games found with gameday ' . $gameday
				);
			}

			return $games;
		}
	}

	public function getGamesByTeam($team) {

		$conn = $this->getDoctrine()->getConnection();

		$sql = ' 
            SELECT * FROM games g
            WHERE g.home = :team
            OR g.away = :team
            ';

		$stmt = $conn->prepare($sql);
		$stmt->execute(['team' => $team]);

		return $stmt->fetchAllAssociative();
	}

}