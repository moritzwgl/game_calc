<?php

namespace App\Entity;

use App\Repository\GamesRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GamesRepository::class)
 */
class Games
{
	/**
	 * @ORM\Id
	 * @ORM\GeneratedValue
	 * @ORM\Column(type="integer")
	 */
	private $id;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $gameday_id;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $home_id;

	/**
	 * @ORM\Column(type="integer")
	 */
	private $away_id;

	/**
	 * @ORM\Column(type="string")
	 */
	private $result;

	public function getId(): ?int {
		return $this->id;
	}

	/**
	 * @return integer
	 */
	public function getGamedayId() {
		return $this->gameday_id;
	}

	/**
	 * @param integer $gameday_id
	 */
	public function setGamedayId($gameday_id): void {
		$this->gameday_id = $gameday_id;
	}

	/**
	 * @return integer
	 */
	public function getHomeId() {
		return $this->home_id;
	}

	/**
	 * @param integer $home_id
	 */
	public function setHomeId($home_id): void {
		$this->home_id = $home_id;
	}

	/**
	 * @return integer
	 */
	public function getAwayId() {
		return $this->away_id;
	}

	/**
	 * @param integer $away_id
	 */
	public function setAwayId($away_id): void {
		$this->away_id = $away_id;
	}

	/**
	 * @return string
	 */
	public function getResult() {
		return $this->result;
	}

	/**
	 * @param string $result
	 */
	public function setResult($result): void {
		$this->result = $result;
	}
}
