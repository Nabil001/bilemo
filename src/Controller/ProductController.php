<?php

namespace App\Controller;

use App\Entity\Product;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;

class ProductController extends FOSRestController
{
    /**
     * @Rest\Get(
     *     "/products/{id}",
     *     name="app_product_show",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View(statusCode=200, populateDefaultVars=false, serializerGroups={"show"})
     */
    public function show(Product $product)
    {
        return $product;
    }
}