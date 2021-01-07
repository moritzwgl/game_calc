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
    private $gameday;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $home;

    /**
     * @ORM\Column(type="string", length=255)
     */
    private $away;

    /**
     * @ORM\Column(type="string")
     */
    private $result;

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

    public function getHome(): ?string
    {
        return $this->home;
    }

    public function setHome(string $home): self
    {
        $this->home = $home;

        return $this;
    }

    public function getAway(): ?string
    {
        return $this->away;
    }

    public function setAway(string $away): self
    {
        $this->away = $away;

        return $this;
    }

    public function getResult(): ?string
    {
        return $this->result;
    }

    public function setResult(string $result): self
    {
        $this->result = $result;

        return $this;
    }
}
