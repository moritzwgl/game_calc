<?php

namespace App\Entity;

use App\Repository\GamedayRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=GamedayRepository::class)
 */
class Gameday
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
    private $gameday;

	/**
	 * @ORM\Column(type="string")
	 */
    private $date;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getGameday(): ?int
    {
        return $this->gameday;
    }

    public function setGameday(int $gameday): self
    {
        $this->gameday = $gameday;

        return $this;
    }

	public function getDate() {
		return $this->date;
	}

	public function setDate(string $date): void {
		$this->date = $date;
	}
}
