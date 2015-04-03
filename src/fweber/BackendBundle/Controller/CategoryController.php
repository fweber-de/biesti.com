<?php

namespace fweber\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

class CategoryController extends Controller
{
    public function collectionAction(Request $request)
    {
        $tags = $this->getDoctrine()->getRepository('fweberDataBundle:Category')->findAll();

        //api response
        if ($request->get('ajax', 0) == 1) {
            $serializer = $this->get('jms_serializer');

            $response = new Response($serializer->serialize($tags, 'json'));
            $response->headers->set('Content-Type', 'application/json');

            return $response;
        }

        return $this->render(
            '@fweberBackend/Category/collection.html.twig',
            array(
                'tags' => $tags
            )
        );
    }
}