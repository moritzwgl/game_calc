<?php

namespace App\Service;

use App\Crawler\Crawler;
use App\Entity\Gameday;
use App\Entity\Games;
use DateTime;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;

class GamedayService extends AbstractController
{
	public function saveAllGamedays(Crawler $crawler) {

		$entityManager = $this->getDoctrine()->getManager();

		$last_gameday = 34;

		for ($i = 1; $i <= $last_gameday; $i++) {

			$gameday_info = $crawler->crawlGameday($i);

			$gameday = new Gameday();
			$gameday->setGameday($i);
			$gameday->setDate($gameday_info["gameday_info"]["date"]);

			$this->saveAllGames($gameday_info["games"], $i);

			$entityManager->persist($gameday);
			$entityManager->flush();
		}
	}

	public function saveAllGames($games, $gameday) {

		$entityManager = $this->getDoctrine()->getManager();

		foreach ($games as $game) {

			if (preg_match('/\d/', $game["result"])) {
				$result = $game["result"];
			} else {
				$result = "";
			}

			$games = new Games();
			$games->setGameday($gameday);
			$games->setHome($game["home"]);
			$games->setAway($game["away"]);
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

		if (!$gameday) {
			throw $this->createNotFoundException(
				'No gameday found with date ' . $current_date
			);
		}

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