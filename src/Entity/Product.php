<?php

namespace App\Entity;

use Doctrine\Common\Collections\ArrayCollection;
use Doctrine\Common\Collections\Collection;
use Doctrine\ORM\Mapping as ORM;
use Hateoas\Configuration\Annotation as Hateoas;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity(repositoryClass="App\Repository\ProductRepository")
 * @ORM\Table(name="product")
 *
 * @Hateoas\Relation(
 *     "self",
 *     href=@Hateoas\Route(
 *         "app_product_show",
 *         parameters={"id"="expr(object.getId())"},
 *         absolute=true
 *     ),
 *     exclusion=@Hateoas\Exclusion(groups={"show", "list"})
 * )
 * @Hateoas\Relation(
 *     "images",
 *     embedded=@Hateoas\Embedded("expr(object.getImages())"),
 *     exclusion=@Hateoas\Exclusion(
 *         excludeIf="expr(!count(object.getImages()))",
 *         groups={"show", "list"}
 *     )
 * )
 */
class Product
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @Serializer\Groups({"show", "list"})
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Serializer\Groups({"show", "list"})
     */
    private $name;

    /**
     * @var string
     *
     * @ORM\Column(type="text")
     *
     * @Serializer\Groups({"show"})
     */
    private $description;

    /**
     * @var float
     *
     * @ORM\Column(type="decimal", precision=6, scale=2)
     *
     * @Serializer\Groups({"show", "list"})
     */
    private $price;

    /**
     * @var float
     *
     * @ORM\Column(name="taxe_rate", type="decimal", precision=5, scale=2)
     *
     * @Serializer\Groups({"show", "list"})
     */
    private $taxeRate;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(
     *     targetEntity="Image",
     *     mappedBy="product",
     *     orphanRemoval=true,
     *     cascade={"persist", "remove"},
     *     fetch="EAGER"
     * )
     *
     * @Serializer\Exclude()
     */
    private $images;

    /**
     * @var Collection
     *
     * @ORM\OneToMany(
     *     targetEntity="ProductFeature",
     *     mappedBy="product",
     *     cascade={"persist", "remove"},
     *     orphanRemoval=true,
     *     fetch="EXTRA_LAZY"
     * )
     *
     * @Serializer\Exclude()
     */
    private $productFeatures;

    public function __construct()
    {
        $this->images = new ArrayCollection();
        $this->productFeatures = new ArrayCollection();
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
    public function getName(): string
    {
        return $this->name;
    }

    /**
     * @param string $name
     * @return Product
     */
    public function setName(string $name): Product
    {
        $this->name = $name;

        return $this;
    }

    /**
     * @return string
     */
    public function getDescription(): string
    {
        return $this->description;
    }

    /**
     * @param string $description
     * @return Product
     */
    public function setDescription(string $description): Product
    {
        $this->description = $description;

        return $this;
    }

    /**
     * @return float
     */
    public function getPrice(): float
    {
        return $this->price;
    }

    /**
     * @param float $price
     * @return Product
     */
    public function setPrice(float $price): Product
    {
        $this->price = $price;

        return $this;
    }

    /**
     * @return float
     */
    public function getTaxeRate(): float
    {
        return $this->taxeRate;
    }

    /**
     * @param float $taxeRate
     * @return Product
     */
    public function setTaxeRate(float $taxeRate): Product
    {
        $this->taxeRate = $taxeRate;

        return $this;
    }

    /**
     * @return Collection
     */
    public function getImages(): Collection
    {
        return $this->images;
    }

    /**
     * @param Image $image
     * @return Product
     */
    public function addImage(Image $image): Product
    {
        if (!$this->images->contains($image)) {
            $this->images[] = $image;
        }
        $image->setProduct($this);

        return $this;
    }

    /**
     * @param Image $image
     * @return Product
     */
    public function removeImage(Image $image): Product
    {
        $this->images->removeElement($image);

        return $this;
    }

    /**
     * @return Collection
     */
    public function getProductFeatures(): Collection
    {
        return $this->productFeatures;
    }

    /**
     * @param ProductFeature $productFeature
     * @return Product
     */
    public function addProductFeature(ProductFeature $productFeature): Product
    {
        if (!$this->productFeatures->contains($productFeature)) {
            $this->productFeatures[] = $productFeature;
        }
        $productFeature->setProduct($this);

        return $this;
    }

    /**
     * @param ProductFeature $productFeature
     * @return Product
     */
    public function removeProductFeature(ProductFeature $productFeature): Product
    {
        $this->productFeatures->removeElement($productFeature);

        return $this;
    }
}