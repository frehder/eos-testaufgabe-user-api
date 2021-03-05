<?php

namespace App\Controller;

use App\Entity\User;
use App\Form\Type\UserType;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;
use Swagger\Annotations as SWG;
use Nelmio\ApiDocBundle\Annotation\Model;

class UserController extends AbstractApiController
{

    /**
     * List all existing users.
     *
     * @SWG\Get(
     *     path="/api/v1/users",
     *     summary="Get all users",
     *     description="List all existing users.",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response=200,
     *         description="HTTP_OK",
     *         @Model(type=User::class),
     *         examples={
     *             "application/json": {
     *                 {
     *                      "id": 5,
     *                      "email": "max.mustermann@musterfirma.de",
     *                      "firstname": "Max",
     *                      "lastname": "Mustermann"
     *                 },
     *                 {
     *                      "id": 6,
     *                      "email": "maria.musterfrau@musterfirma.de",
     *                      "firstname": "Maria",
     *                      "lastname": "Musterfrau"
     *                 }
     *             }
     *         }
     *     )
     * )
     */
    public function list(): Response
    {
        $user = $this->getDoctrine()->getRepository(User::class)->findAll();

        return $this->respond($user, Response::HTTP_OK);
    }

    /**
     * Get one existing user by ID.
     *
     * @param Request $request
     * @return Response
     *
     * @SWG\Get(
     *     path="/api/v1/user/{userId}",
     *     summary="Get one user",
     *     description="Get one existing user by ID.",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response=200,
     *         description="HTTP_OK",
     *         @Model(type=User::class),
     *         examples={
     *             "application/json": {
     *                  "id": 5,
     *                  "email": "mia.muster@musterfirma.de",
     *                  "firstname": "Mia",
     *                  "lastname": "Muster"
     *             }
     *         }
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="HTTP_NOT_FOUND - User not found",
     *     )
     * )
     */
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

    /**
     * Create a new user.
     *
     * @param Request $request
     * @return Response
     *
     * @SWG\Post(
     *     path="/api/v1/user",
     *     summary="Create user",
     *     description="Create a new user.",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="body",
     *         description="Post data.",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(
     *             type="object",
     *             required={"email", "firstname", "lastname"},
     *             @SWG\Property(
     *                 property="email",
     *                 type="string",
     *                 format="email",
     *                 example="mia.muster@musterfirma.de"
     *             ),
     *             @SWG\Property(
     *                 property="firstname",
     *                 type="string",
     *                 example="Mia"
     *             ),
     *             @SWG\Property(
     *                 property="lastname",
     *                 type="string",
     *                 example="Muster"
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *         response=201,
     *         description="HTTP_CREATED",
     *         @Model(type=User::class),
     *         examples={
     *             "application/json": {
     *                  "id": 5,
     *                  "email": "mia.muster@musterfirma.de",
     *                  "firstname": "Mia",
     *                  "lastname": "Muster"
     *             }
     *         }
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="HTTP_BAD_REQUEST - Validation failed",
     *     )
     * )
     */
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

    /**
     * Delete existing user by ID.
     *
     * @param Request $request
     * @return Response
     *
     * @SWG\Delete(
     *     path="/api/v1/user/{userId}",
     *     summary="Delete user",
     *     description="Delete existing user by ID.",
     *     produces={"application/json"},
     *     @SWG\Response(
     *         response=200,
     *         description="HTTP_OK"
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="HTTP_NOT_FOUND - User not found",
     *     )
     * )
     */
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

        return $this->respond('', Response::HTTP_OK);
    }

    /**
     * Partially update existing user.
     *
     * @param Request $request
     * @return Response
     *
     * @SWG\Patch(
     *     path="/api/v1/user/{userId}",
     *     summary="Update user",
     *     description="Partially update existing user.",
     *     produces={"application/json"},
     *     @SWG\Parameter(
     *         name="body",
     *         description="Post data. At least one property is required.",
     *         in="body",
     *         required=true,
     *         @SWG\Schema(
     *             type="object",
     *             @SWG\Property(
     *                 property="email",
     *                 type="string",
     *                 format="email",
     *                 example="maria.musterfrau@musterfirma.de"
     *             ),
     *             @SWG\Property(
     *                 property="firstname",
     *                 type="string",
     *                 example="Maria"
     *             ),
     *             @SWG\Property(
     *                 property="lastname",
     *                 type="string",
     *                 example="Musterfrau"
     *             )
     *         )
     *     ),
     *     @SWG\Response(
     *         response=204,
     *         description="HTTP_NO_CONTENT"
     *     ),
     *     @SWG\Response(
     *         response=404,
     *         description="HTTP_NOT_FOUND - User not found",
     *     ),
     *     @SWG\Response(
     *         response=400,
     *         description="HTTP_BAD_REQUEST - Validation failed",
     *     )
     * )
     */
    public function update(Request $request): Response
    {
        $user_id = $request->get('userId');
        $user = $this->getDoctrine()->getRepository(User::class)->findOneBy([
            'id' => $user_id,
        ]);

        if (!$user) {
            return $this->respond($user, Response::HTTP_NOT_FOUND);
        }

        $form = $this->buildForm(UserType::class, $user, [
            'method' => $request->getMethod(),
        ]);
        $form->handleRequest($request);

        if (!$form->isSubmitted() || !$form->isValid()) {
            return $this->respond($form, Response::HTTP_BAD_REQUEST);
        }

        $updated_user_data = $form->getData();

        $this->getDoctrine()->getManager()->persist($updated_user_data);
        $this->getDoctrine()->getManager()->flush();

        return $this->respond('', Response::HTTP_NO_CONTENT);
    }
}
