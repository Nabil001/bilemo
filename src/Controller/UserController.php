<?php

namespace App\Controller;

use App\Entity\User;
use FOS\RestBundle\Controller\Annotations as Rest;
use FOS\RestBundle\Controller\FOSRestController;
use FOS\RestBundle\Request\ParamFetcher;
use Sensio\Bundle\FrameworkExtraBundle\Configuration\ParamConverter;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Symfony\Component\Validator\ConstraintViolationListInterface;

class UserController extends FOSRestController
{
    /**
     * @Rest\Get(
     *     path="/users/{id}",
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
     *     path="/users/",
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

    /**
     * @Rest\Post(
     *     path="/users",
     *     name="app_user_create"
     * )
     *
     * @ParamConverter(
     *      "user",
     *      converter="fos_rest.request_body",
     * )
     */
    public function create(User $user, ConstraintViolationListInterface $errors)
    {
        if (count($errors)) {
            $normalizedErrorList = [];
            foreach ($errors as $error) {
                $normalizedErrorList[$error->getPropertyPath()] = $error->getMessage();
            }

            return $this->view(
                ['errors' => $normalizedErrorList],
                Response::HTTP_BAD_REQUEST
            );
        }

        $user->setClient($this->getUser());

        $em = $this->getDoctrine()->getManager();
        $em->persist($user);
        $em->flush();

        return $this->view(
            $user,
            Response::HTTP_CREATED,
            [
                'Location' => $this->generateUrl(
                    'app_user_show',
                    ['id' => $user->getId()]
                )
            ]
        );
    }

    /**
     * @Rest\Delete(
     *     path="/users/{id}",
     *     name="app_user_delete",
     *     requirements={"id"="\d+"}
     * )
     */
    public function delete(User $user)
    {
        $em = $this->getDoctrine()->getManager();
        $em->remove($user);
        $em->flush();

        return new Response();
    }
}