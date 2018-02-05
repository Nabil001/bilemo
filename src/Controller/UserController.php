<?php

namespace App\Controller;

use App\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;

class UserController extends FOSRestController
{
    /**
     * @Rest\Get(
     *     "/users/{id}",
     *     name="app_user_show",
     *     requirements={"id"="\d+"}
     * )
     * @Rest\View(
     *     statusCode=200,
     *     populateDefaultVars=false
     * )
     *
     * @ParamConverter(
     *     name="user",
     *     class="App\Entity\User",
     *     converter="app.user_converter"
     * )
     */
    public function show(User $user)
    {
        return $user;
    }

    /**
     * @Rest\Get(
     *     "/users/",
     *     name="app_user_list"
     * )
     * @Rest\View(
     *     statusCode=200,
     *     populateDefaultVars=false
     * )
     * @Rest\QueryParam(
     *     name="page",
     *     requirements="^[1-9]+[0-9]*$",
     *     default="1",
     *     description="The page of the user list."
     * )
     * @Rest\QueryParam(
     *     name="limit",
     *     requirements="^[1-9]+[0-9]*$",
     *     default="10",
     *     description="The maximum amount of users per page."
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
            ->getRepository(User::class)
            ->search(
                $fetcher->get('page'),
                $fetcher->get('limit'),
                $fetcher->get('term'),
                $request->get('_route'),
                $this->getUser()
            );
    }
}