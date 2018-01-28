<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;


/**
 * @ORM\Entity
 * @ORM\Table(
 *     name="product_feature",
 *     uniqueConstraints={
 *         @ORM\UniqueConstraint(
 *             name="unique_couple",
 *             columns={"product_id", "feature_id"}
 *         )
 *     }
 * )
 */
class ProductFeature
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
     * @ORM\Column(type="string")
     */
    private $value;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(
     *     targetEntity="Product",
     *     inversedBy="productFeatures",
     *     cascade={"persist"},
     *     fetch="EAGER"
     * )
     */
    private $product;

    /**
     * @var Feature
     *
     * @ORM\ManyToOne(
     *     targetEntity="Feature",
     *     cascade={"persist"},
     *     fetch="EAGER"
     * )
     */
    private $feature;

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
    public function getValue(): string
    {
        return $this->value;
    }

    /**
     * @param string $value
     * @return ProductFeature
     */
    public function setValue(string $value): ProductFeature
    {
        $this->value = $value;

        return $this;
    }

    /**
     * @return Product
     */
    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     * @return ProductFeature
     */
    public function setProduct(Product $product): ProductFeature
    {
        $this->product = $product;

        return $this;
    }

    /**
     * @return Feature
     */
    public function getFeature(): Feature
    {
        return $this->feature;
    }

    /**
     * @param Feature $feature
     * @return ProductFeature
     */
    public function setFeature(Feature $feature): ProductFeature
    {
        $this->feature = $feature;

        return $this;
    }
}