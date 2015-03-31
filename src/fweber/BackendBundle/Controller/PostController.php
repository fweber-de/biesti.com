<?php

namespace fweber\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

/**
 * @author Florian Weber <florian.weber@fweber.info>
 */
class PostController extends Controller
{
    public function collectionAction()
    {
        $posts = $this->getDoctrine()->getRepository('fweberDataBundle:Post')->findAll();

        return $this->render('fweberBackendBundle:Post:collection.html.twig', array(
            'posts' => $posts,
        ));
    }

    public function createAction(Request $request)
    {
        if ($request->get('sent', 0) == 1) {
        }

        return $this->render('fweberBackendBundle:Post:create.html.twig');
    }
}
