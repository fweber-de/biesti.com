<?php

namespace fweber\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class UserController extends Controller
{
    public function collectionAction()
    {
        $users = $this->getDoctrine()->getRepository('fweberUserBundle:User')->findAll();

        return $this->render(
            '@fweberBackend/User/collection.html.twig',
            array(
                'users' => $users
            )
        );
    }
}