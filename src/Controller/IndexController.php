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

		$overall_stats["win_percentage"] = ($this->math->getwinningChance($overall_stats)*100);

		return $this->render('team.html.twig', [
			"gamedays" => $this->gamedays,
			"team" => $team,
			"games" => $games,
			"stats" => $overall_stats
		]);
	}


	/**
	 * @Route("/crawl", name="crawl")
	 */
	public function testAction() {

		$this->gamedayService->saveAllGamedays(new Crawler());

		return $this->redirectToRoute('index', [], 301);
	}
}