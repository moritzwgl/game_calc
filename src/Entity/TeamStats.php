<?php

namespace App\Entity;

use App\Repository\TeamStatsRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=TeamStatsRepository::class)
 */
class TeamStats
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
    private $team_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $games;

    /**
     * @ORM\Column(type="integer")
     */
    private $wins;

    /**
     * @ORM\Column(type="integer")
     */
    private $draws;

    /**
     * @ORM\Column(type="integer")
     */
    private $looses;

    /**
     * @ORM\Column(type="string")
     */
    private $goals;

    /**
     * @ORM\Column(type="integer")
     */
    private $points;

    public function getId(): ?int
    {
        return $this->id;
    }

    public function getTeamId(): ?int
    {
        return $this->team_id;
    }

    public function setTeamId(int $team_id): self
    {
        $this->team_id = $team_id;

        return $this;
    }

    public function getGames(): ?int
    {
        return $this->games;
    }

    public function setGames(int $games): self
    {
        $this->games = $games;

        return $this;
    }

    public function getWins(): ?int
    {
        return $this->wins;
    }

    public function setWins(int $wins): self
    {
        $this->wins = $wins;

        return $this;
    }

    public function getDraws(): ?int
    {
        return $this->draws;
    }

    public function setDraws(int $draws): self
    {
        $this->draws = $draws;

        return $this;
    }

    public function getLooses(): ?int
    {
        return $this->looses;
    }

    public function setLooses(int $looses): self
    {
        $this->looses = $looses;

        return $this;
    }

    public function getGoals(): ?string
    {
        return $this->goals;
    }

    public function setGoals(string $goals): self
    {
        $this->goals = $goals;

        return $this;
    }

    public function getPoints(): ?int
    {
        return $this->points;
    }

    public function setPoints(int $points): self
    {
        $this->points = $points;

        return $this;
    }
}
