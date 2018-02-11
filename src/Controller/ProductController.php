<?php

namespace App\Controller;

use App\Entity\Product;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use Nelmio\ApiDocBundle\Annotation as Doc;
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
     *
     * @Doc\ApiDoc(
     *     section="Products",
     *     resource=true,
     *     description="Get one of the products.",
     *     requirements={
     *         {
     *             "name"="id",
     *             "dataType"="integer",
     *             "requirement"="\d+",
     *             "description"="The product unique identifier."
     *         }
     *     },
     *     statusCodes={
     *         200="Returned when the request succeed.",
     *         404="Returned when the given product hasn't been found."
     *     }
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
     *
     * @Doc\ApiDoc(
     *     section="Products",
     *     resource=true,
     *     description="Get a list of the products.",
     *     statusCodes={
     *         200="Returned when the wanted page is found.",
     *         404="Returned when the wanted page is not found."
     *     }
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
                $request->get('_route')
            );
    }
}