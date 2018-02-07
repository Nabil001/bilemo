<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\JsonSerializationVisitor;
use Symfony\Component\Validator\Constraints as Assert;

/**
 * @ORM\Entity(repositoryClass="App\Repository\UserRepository")
 * @ORM\Table(name="user")
 *
 * @Hateoas\Relation(
 *     "self",
 *     href=@Hateoas\Route(
 *         "app_user_show",
 *         parameters={"id"="expr(object.getId())"},
 *         absolute=true
 *     )
 * )
 * @Hateoas\Relation(
 *     "delete",
 *     href=@Hateoas\Route(
 *         "app_user_show",
 *         parameters={"id"="expr(object.getId())"},
 *         absolute=true
 *     )
 * )
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
     * @Assert\NotBlank(message="The lastname can't be blank.")
     * @Assert\Length(
     *     min="2",
     *     minMessage="The firstname must be at least 2-character long."
     * )
     * @Assert\Regex(
     *     pattern="#^[A-Z]*[a-z]*$#",
     *     message="The firstname is invalid."
     * )
     */
    private $firstname;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Assert\NotBlank(message="The lastname can't be blank.")
     * @Assert\Length(
     *     min="2",
     *     minMessage="The lastname must be at least 2-character long."
     * )
     * @Assert\Regex(
     *     pattern="#^[A-Z]*[a-z]*$#",
     *     message="The lastname is invalid."
     * )
     */
    private $lastname;

    /**
     * @var \DateTime
     *
     * @ORM\Column(type="date", name="birth_date")
     *
     * @Assert\NotNull(message="The user must be given a birth date.")
     * @Assert\Date(
     *     message="The birth date format is invalid."
     * )
     *
     * @Serializer\Type("DateTime<'d/m/Y'>")
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
     *
     * @Serializer\Exclude()
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