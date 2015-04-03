<?php

namespace fweber\BackendBundle\Controller;

use fweber\BackendBundle\Component\ApiMessage;
use fweber\BackendBundle\Component\SlugGenerator;
use fweber\DataBundle\Entity\Category;
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
                'tags' => $tags,
            )
        );
    }

    public function createAction(Request $request)
    {
        if ($request->get('sent', 0) == 1) {
            $tag = new Category();
            $tag->setTitle($request->get('title'))
                ->setSlug(SlugGenerator::generate($request->get('title')));

            //validation
            $validator = $this->get('validator');
            $errors = $validator->validate($tag);

            //error handling
            if (count($errors) > 0) {
                if ($request->get('ajax', 0) == 1) {
                    $message = new ApiMessage();
                    $message->message = (string) $errors;
                    $message->status = ApiMessage::STATUS_ERROR;

                    $response = new Response(json_encode($message));
                    $response->setStatusCode(400);

                    return $response;
                } else {
                    foreach ($errors as $error) {
                        $this->addFlash('error', $error);
                    }

                    return $this->render('fweberBackendBundle:Category:create.html.twig');
                }
            }

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($tag);
            $em->flush();

            if ($request->get('ajax', 0) == 1) {
                $message = new ApiMessage();
                $message->message = 'Tag saved!';
                $message->status = ApiMessage::STATUS_SUCCESS;

                $response = new Response(json_encode($message));
                $response->setStatusCode(200);

                return $response;
            } else {
                return $this->redirectToRoute('backend_tags_collection');
            }
        }

        return $this->render('@fweberBackend/Category/create.html.twig');
    }

    public function updateAction(Request $request, $tagId)
    {
        $tag = $this->getDoctrine()->getRepository('fweberDataBundle:Category')->findOneById($tagId);

        if (!$tag) {
            throw new \InvalidArgumentException('Tag not found!');
        }

        if ($request->get('sent', 0) == 1) {
            $tag->setTitle($request->get('title'))
                ->setSlug(SlugGenerator::generate($request->get('title')));

            //validation
            $validator = $this->get('validator');
            $errors = $validator->validate($tag);

            //error handling
            if (count($errors) > 0) {
                if ($request->get('ajax', 0) == 1) {
                    $message = new ApiMessage();
                    $message->message = (string) $errors;
                    $message->status = ApiMessage::STATUS_ERROR;

                    $response = new Response(json_encode($message));
                    $response->setStatusCode(400);

                    return $response;
                } else {
                    foreach ($errors as $error) {
                        $this->addFlash('error', $error);
                    }

                    return $this->render(
                        'fweberBackendBundle:Category:update.html.twig',
                        array(
                            'tag' => $tag,
                        )
                    );
                }
            }

            $em = $this->getDoctrine()->getEntityManager();
            $em->flush();

            if ($request->get('ajax', 0) == 1) {
                $message = new ApiMessage();
                $message->message = 'Tag saved!';
                $message->status = ApiMessage::STATUS_SUCCESS;

                $response = new Response(json_encode($message));
                $response->setStatusCode(200);

                return $response;
            } else {
                return $this->redirectToRoute('backend_tags_collection');
            }
        }

        return $this->render(
            '@fweberBackend/Category/update.html.twig',
            array(
                'tag' => $tag,
            )
        );
    }

    public function deleteAction(Request $request, $tagId)
    {
        $tag = $this->getDoctrine()->getRepository('fweberDataBundle:Category')->findOneById($tagId);

        if (!$tag) {
            throw new \InvalidArgumentException('Tag not found!');
        }

        if ($request->get('sent', 0) == 1) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($tag);
            $em->flush();

            return $this->redirectToRoute('backend_tags_collection');
        }

        return $this->render(
            'fweberBackendBundle:Category:delete.html.twig',
            array(
                'tag' => $tag,
            )
        );
    }
}
