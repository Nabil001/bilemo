<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;

/**
 * @ORM\Entity
 * @ORM\Table(name="image")
 */
class Image
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
    private $url;

    /**
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="images")
     */
    private $product;

    public function getId(): int
    {
        return $this->id;
    }

    public function getUrl(): string
    {
        return $this->url;
    }

    /**
     * @param string $url
     */
    public function setUrl(string $url): Image
    {
        $this->url = $url;

        return $this;
    }

    public function getProduct(): Product
    {
        return $this->product;
    }

    /**
     * @param Product $product
     */
    public function setProduct(Product $product): Image
    {
        $this->product = $product;

        return $this;
    }
}