<?php

namespace App\Controller;

use App\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;

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
}