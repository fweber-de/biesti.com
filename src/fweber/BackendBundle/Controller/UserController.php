<?php

namespace fweber\BackendBundle\Controller;

use fweber\BackendBundle\Component\ApiMessage;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class UserController extends Controller
{
    public function collectionAction()
    {
        $users = $this->getDoctrine()->getRepository('fweberUserBundle:User')->findAll();

        return $this->render(
            '@fweberBackend/User/collection.html.twig',
            array(
                'users' => $users,
            )
        );
    }

    public function updateAction(Request $request, $userId)
    {
        $user = $this->getDoctrine()->getRepository('fweberUserBundle:User')->findOneById($userId);

        if ($request->get('sent', 0) == 1) {
            $user->setFirstName($request->get('firstname'))
                ->setLastName($request->get('lastname'))
                ->setEmail($request->get('email'))
                ->setAbout($request->get('about'));

            /*//validation
            $validator = $this->get('validator');
            $errors = $validator->validate($user);*/

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($user);
            $em->flush();

            if ($request->get('ajax', 0) == 1) {
                $message = new ApiMessage();
                $message->message = 'User saved!';
                $message->status = ApiMessage::STATUS_SUCCESS;

                $response = new Response(json_encode($message));
                $response->setStatusCode(200);

                return $response;
            } else {
                return $this->redirectToRoute('backend_users_collection');
            }
        }

        return $this->render(
            '@fweberBackend/User/update.html.twig',
            array(
                'user' => $user,
            )
        );
    }
}
