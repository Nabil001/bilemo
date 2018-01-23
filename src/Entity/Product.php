<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="product")
 */
class Product
{
    /**
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     */
    private $id;

    /**
     * @ORM\Column(type="string")
     */
    private $name;

    /**
     * @ORM\Column(type="text")
     */
    private $description;

    /**
     * @ORM\Column(type="decimal", precision=6, scale=2)
     */
    private $price;

    /**
     * @ORM\Column(name="taxe_rate", type="decimal", precision=5, scale=2)
     */
    private $taxeRate;

    /**
     * @ORM\OneToMany(
     *     targetEntity="Image",
     *     mappedBy="product",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove"}
     * )
     */
    private $images;

    public function __construct()
    {
        $this->images = new ArrayCollection();
    }

    public function getId(): int
    {
        return $this->id;
    }

    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     */
    public function setName(string $name): Product
    {
        $this->name = $name;

        return $this;
    }

    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     */
    public function setDescription(string $description): Product
    {
        $this->description = $description;

        return $this;
    }

    public function getPrice()
    {
        return $this->price;
    }

    /**
     * @param float $price
     */
    public function setPrice(float $price): Product
    {
        $this->price = $price;

        return $this;
    }

    public function getTaxeRate()
    {
        return $this->taxeRate;
    }

    /**
     * @param float $taxeRate
     */
    public function setTaxeRate(float $taxeRate): Product
    {
        $this->taxeRate = $taxeRate;

        return $this;
    }

    /**
     * @param Image $image
     */
    public function addImage(Image $image): Product
    {
        if ($this->images->contains($image)) {
            $this->images[] = $image;
        }
        $image->setProduct($this);

        return $this;
    }

    /**
     * @param Image $image
     */
    public function removeImage(Image $image): Product
    {
        $this->images->removeElement($image);

        return $this;
    }
}