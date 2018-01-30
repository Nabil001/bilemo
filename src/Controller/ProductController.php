<?php

namespace App\Controller;

use App\Entity\Product;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

class ProductController extends FOSRestController
{
    /**
     * @Rest\Get(
     *     "/products/{id}",
     *     name="app_product_show",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View(statusCode=200, populateDefaultVars=false, serializerGroups={"show"})
     *
     * @ParamConverter(
     *     name="product",
     *     class="App\Entity\Product",
     *     options={"repository_method" = "findWithJoins"}
     * )
     */
    public function show(Product $product)
    {
        return $product;
    }

    /**
     * @Rest\Get(
     *     "/products/",
     *     name="app_product_list"
     * )
     * @Rest\View(statusCode=200, populateDefaultVars=false, serializerGroups={"list"})
     */
    public function list()
    {
        return $this->getDoctrine()->getManager()->getRepository(Product::class)->findAll();
    }
}