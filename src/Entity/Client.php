<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Symfony\Component\Security\Core\User\UserInterface;

/**
 * @ORM\Entity()
 * @ORM\Table(name="client")
 */
class Client implements UserInterface
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
     */
    private $company;

    /**
     * @var string
     *
     * @ORM\Column(type="string", unique=true)
     */
    private $username;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $password;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(
     *     targetEntity="App\Entity\User",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true,
     *     fetch="EXTRA_LAZY",
     *     mappedBy="client"
     * )
     */
    private $users;

    public function __construct()
    {
        $this->users = new ArrayCollection();
    }

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
    public function getCompany(): string
    {
        return $this->company;
    }

    /**
     * @param string $company
     * @return Client
     */
    public function setCompany(string $company): Client
    {
        $this->company = $company;

        return $this;
    }

    /**
     * @return string
     */
    public function getUsername(): string
    {
        return $this->username;
    }

    /**
     * @param string $username
     * @return Client
     */
    public function setUsername(string $username): Client
    {
        $this->username = $username;

        return $this;
    }

    /**
     * @return string
     */
    public function getPassword(): string
    {
        return $this->password;
    }

    /**
     * @param string $password
     * @return Client
     */
    public function setPassword(string $password): Client
    {
        $this->password = $password;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getUsers(): Collection
    {
        return $this->users;
    }

    /**
     * @param User $user
     * @return Client
     */
    public function addUser(User $user): Client
    {
        if (!$this->users->contains($user)) {
            $this->users[] = $user;
        }
        $user->setClient($this);

        return $this;
    }

    /**
     * @param User $user
     * @return Client
     */
    public function removeUser(User $user): Client
    {
        $this->users->removeElement($user);

        return $this;
    }

    /**
     * @return array
     */
    public function getRoles(): array
    {
        return ['ROLE_CLIENT'];
    }

    /**
     * @return null|string
     */
    public function getSalt(): ?string
    {
        return null;
    }

    public function eraseCredentials(): void
    {
    }
}