<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends AbstractApiController
{
    public function list(): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->json($user);
    }

    public function fetch(Request $request): Response
    {
        $user_id = $request->get('userId');
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'id' => $user_id,
        ]);

        if (!$user) {
            return $this->respond($user, Response::HTTP_NOT_FOUND);
        }

        return $this->respond($user, Response::HTTP_OK);
    }

    public function create(Request $request): Response
    {
        $form = $this->buildForm(UserType::class);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        $user = $form->getData();
        $this->getDoctrine()->getManager()->persist($user);
        $this->getDoctrine()->getManager()->flush();

        return $this->respond($user, Response::HTTP_CREATED);
    }

    public function delete(Request $request): Response
    {
        $user_id = $request->get('userId');
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'id' => $user_id,
        ]);

        if (!$user) {
            return $this->respond($user, Response::HTTP_NOT_FOUND);
        }

        $this->getDoctrine()->getManager()->remove($user);
        $this->getDoctrine()->getManager()->flush();

        return $this->respond('');
    }
}
