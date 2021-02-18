<?php

namespace App\Entity;

use App\Repository\StatisticRepository;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity(repositoryClass=StatisticRepository::class)
 */
class Statistic
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\ManyToOne(targetEntity=Beer::class, inversedBy="statistics")
     * @ORM\JoinColumn(nullable=false)
     */
    private $beer;

    /**
     * @ORM\Column(type="integer")
     */
    private $category_id;

    /**
     * @ORM\Column(type="integer")
     */
    private $score;


    /**
     * @ORM\ManyToOne(targetEntity=Client::class, inversedBy="statistics")
     * @ORM\JoinColumn(nullable=false)
     */
    private $client;



    public function getId(): ?int
    {
        return $this->id;
    }

    public function getBeerId(): ?Beer
    {
        return $this->beer;
    }

    public function setBeerId(?Beer $beer): self
    {
        $this->beer = $beer;

        return $this;
    }

    public function getCategoryId(): ?int
    {
        return $this->category_id;
    }

    public function setCategoryId(int $category_id): self
    {
        $this->category_id = $category_id;

        return $this;
    }

    public function getScore(): ?int
    {
        return $this->score;
    }

    public function setScore(int $score): self
    {
        $this->score = $score;

        return $this;
    }

    public function getClientId(): ?Client
    {
        return $this->client;
    }
    
    
    public function setClientId(?Client $client): self
    {
        $this->client = $client;

        return $this;
    }
}
