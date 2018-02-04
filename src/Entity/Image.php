<?php

namespace App\Entity;

use Doctrine\ORM\Mapping as ORM;
use JMS\Serializer\Annotation as Serializer;
use JMS\Serializer\JsonSerializationVisitor;

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
     */
    private $id;

    /**
     * @var string
     *
     * @ORM\Column(type="string")
     */
    private $url;

    /**
     * @var Product
     *
     * @ORM\ManyToOne(targetEntity="Product", inversedBy="images")
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

    /**
     * @param JsonSerializationVisitor $visitor
     * @return array
     *
     * @Serializer\HandlerCallback(format="json", direction="serialization")
     */
    public function normalize(JsonSerializationVisitor $visitor): array
    {
        return ['url' => $this->getUrl()];
    }
}