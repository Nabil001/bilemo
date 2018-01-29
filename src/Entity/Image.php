<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;

/**
 * @ORM\Entity
 * @ORM\Table(name="image")
 */
class Image
{
    /**
     * @var int
     *
     * @ORM\Id
     * @ORM\GeneratedValue(strategy="AUTO")
     * @ORM\Column(type="integer")
     *
     * @Serializer\Exclude()
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     *
     * @Serializer\Groups({"show", "list"})
     */
    private $url;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="images")
     *
     * @Serializer\Exclude()
     */
    private $product;

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
    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     * @return Image
     */
    public function setUrl(string $url): Image
    {
        $this->url = $url;

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
     * @return Image
     */
    public function setProduct(Product $product): Image
    {
        $this->product = $product;

        return $this;
    }
}