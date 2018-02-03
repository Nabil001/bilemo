<?php

namespace App\Controller;

use App\Entity\Product;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class ProductController extends FOSRestController
{
    /**
     * @Rest\Get(
     *     "/products/{id}",
     *     name="app_product_show",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View(
     *     statusCode=200,
     *     populateDefaultVars=false,
     *     serializerGroups={"Show"}
     * )
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
     * @Rest\View(
     *     statusCode=200,
     *     populateDefaultVars=false,
     *     serializerGroups={"Default"}
     * )
     * @Rest\QueryParam(
     *     name="page",
     *     requirements="^[1-9]+[0-9]*$",
     *     default="1",
     *     description="The page of the product list."
     * )
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="^[1-9]+[0-9]*$",
     *     default="10",
     *     description="The maximum amount of products per page."
     * )
     * @Rest\QueryParam(
     *     name="term",
     *     nullable=true,
     *     description="The searched term."
     * )
     */
    public function list(ParamFetcher $fetcher, Request $request)
    {
        return $this->getDoctrine()
            ->getManager()
            ->getRepository(Product::class)
            ->search(
                $fetcher->get('page'),
                $fetcher->get('limit'),
                $fetcher->get('term'),
                $request
            );
    }
}