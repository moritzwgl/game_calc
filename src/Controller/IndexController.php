<?php

namespace App\Controller;

use App\Crawler\Crawler;
use App\Math\Math;
use App\Service\GamedayService;
use Symfony\Bundle\FrameworkBundle\Controller\AbstractController;
use Symfony\Component\Routing\Annotation\Route;

class IndexController extends AbstractController
{
	protected $gamedayService;
	protected $gamedays;
	protected $math;

	public function __construct(GamedayService $gamedayService, Math $math) {

		$this->gamedayService = $gamedayService;
		$this->gamedays = $gamedayService->getAllGamedays();
		$this->math = $math;
	}


	/**
	 * @Route("", name="index")
	 */
	public function indexAction() {

		return $this->render('index.html.twig', [
			"gamedays" => $this->gamedays,
			"games" => $this->gamedayService->getCurrentGameday()
		]);
	}

	/**
	 * @Route("/gameday/{num}", name="gameday")
	 */
	public function gamedayAction($num) {

		$games = $this->gamedayService->getGamedayById($num);

		return $this->render('gameday.html.twig', [
			"gamedays" => $this->gamedays,
			"gameday" => $games[0]->getGameday(),
			"games" => $games
		]);
	}

	/**
	 * @Route("/team/{team}", name="team")
	 */
	public function teamAction($team) {

		$games = $this->gamedayService->getGamesByTeam($team);

		$overall_stats = $this->math->getOverallStats($games, $team);

		$overall_stats["win_percentage"] = ($this->math->getwinningChance($overall_stats) * 100);

		return $this->render('team.html.twig', [
			"gamedays" => $this->gamedays,
			"team" => $team,
			"games" => $games,
			"stats" => $overall_stats
		]);
	}


	/**
	 * @Route("/crawler/{action}", defaults={"action"=""}, name="crawler")
	 */
	public function crawlerAction($action) {

		$crawler = new Crawler();

		if ($action === "teams") {

			$table_url = "https://www.sport.de/widget_standing_round-matchday/ro109214/md";
			$teams = $crawler->crawlTeams($table_url);

			$this->gamedayService->saveTeams($teams);

			return $this->redirectToRoute('crawler', [], 301);
		}

		if ($action === "teams_stats") {

			$table_url = "https://www.sport.de/widget_standing_round-matchday/ro109214/md";
			$teams_stats = $crawler->crawlTeamsStats($table_url);

			$this->gamedayService->saveTeamsStats($teams_stats);

			return $this->redirectToRoute('crawler', [], 301);
		}

		if ($action === "gameday") {

			$gameday_url = "https://www.sport.de/widget_gameplan_round-matchday/sp1/se35753/co12/ro109214/md";

			for ($i = 1; $i <= 34; $i++) {

				$gameday_arr = $crawler->crawlGameday($gameday_url, $i);

				$this->gamedayService->saveGameday($gameday_arr);
			}

			return $this->redirectToRoute('crawler', [], 301);
		}

		if ($action === "games") {

			$gameday_url = "https://www.sport.de/widget_gameplan_round-matchday/sp1/se35753/co12/ro109214/md";

			for ($i = 1; $i <= 34; $i++) {

				$games = $crawler->crawlGamedayGames($gameday_url, $i);

				$this->gamedayService->saveGames($games);
			}

			return $this->redirectToRoute('crawler', [], 301);
		}


		if ($action == "") {
			return $this->render('crawler/crawler.html.twig', [
				"gamedays" => $this->gamedays,
				"message" => ""
			]);
		}
	}
}