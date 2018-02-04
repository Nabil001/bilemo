<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity
 * @ORM\Table(name="user")
 */
class User
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min="2",
     *     minMessage="The firstname must be at least 2-character long"
     * )
     * @Assert\Regex(
     *     pattern="^[A-Z]+[a-z]*",
     *     message="The firstname in invalid"
     * )
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank()
     * @Assert\Length(
     *     min="2",
     *     minMessage="The lastname must be at least 2-character long"
     * )
     * @Assert\Regex(
     *     pattern="^[A-Z]+[a-z]*",
     *     message="The lastname in invalid"
     * )
     */
    private $lastname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", name="birth_date")
     *
     * @Assert\Date(
     *     format="d/m/Y",
     *     message="The birth date format is invalid"
     * )
     */
    private $birthDate;

    /**
     * @var Client
     *
     * @ORM\ManyToOne(
     *     targetEntity="App\Entity\Client",
     *     inversedBy="users",
     *     fetch="LAZY"
     * )
     */
    private $client;

    /**
     * @return int
     */
    public function getId(): int
    {
        return $this->id;
    }

    /**
     * @return string
     */
    public function getFirstname(): string
    {
        return $this->firstname;
    }

    /**
     * @param string $firstname
     */
    public function setFirstname(string $firstname): void
    {
        $this->firstname = $firstname;
    }

    /**
     * @return string
     */
    public function getLastname(): string
    {
        return $this->lastname;
    }

    /**
     * @param string $lastname
     */
    public function setLastname(string $lastname): void
    {
        $this->lastname = $lastname;
    }

    /**
     * @return \DateTime
     */
    public function getBirthDate(): \DateTime
    {
        return $this->birthDate;
    }

    /**
     * @param \DateTime $birthDate
     */
    public function setBirthDate(\DateTime $birthDate): void
    {
        $this->birthDate = $birthDate;
    }

    /**
     * @return Client
     */
    public function getClient(): Client
    {
        return $this->client;
    }

    /**
     * @param Client $client
     */
    public function setClient(Client $client): void
    {
        $this->client = $client;
    }
}