<?php

namespace fweber\BackendBundle\Controller;

use fweber\BackendBundle\Component\ApiMessage;
use fweber\BackendBundle\Component\SlugGenerator;
use fweber\DataBundle\Entity\Post;
use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;
use Symfony\Component\HttpFoundation\Response;

/**
 * @author Florian Weber <florian.weber@fweber.info>
 */
class PostController extends Controller
{
    public function collectionAction()
    {
        $posts = $this->getDoctrine()->getRepository('fweberDataBundle:Post')->findBy(
            array(),
            array('publishDate' => 'desc')
        );

        return $this->render(
            'fweberBackendBundle:Post:collection.html.twig',
            array(
                'posts' => $posts,
            )
        );
    }

    public function createAction(Request $request)
    {
        //TODO: implement draft, publish date

        if ($request->get('sent', 0) == 1) {
            $post = new Post();
            $post->setTitle($request->get('title'))
                ->setSlug(SlugGenerator::generate($request->get('title')))
                ->setText($request->get('text'))
                ->setIsDraft(false)
                ->setOpenDate(new \DateTime('now'))
                ->setPublishDate(new \DateTime('now'));

            //validation
            $validator = $this->get('validator');
            $errors = $validator->validate($post);

            //error handling
            if (count($errors) > 0) {
                if ($request->get('ajax', 0) == 1) {
                    $message = new ApiMessage();
                    $message->message = (string)$errors;
                    $message->status = ApiMessage::STATUS_ERROR;

                    $response = new Response(json_encode($message));
                    $response->setStatusCode(400);

                    return $response;
                } else {
                    foreach ($errors as $error) {
                        $this->addFlash('error', $error);
                    }

                    return $this->render('fweberBackendBundle:Post:create.html.twig');
                }
            }

            $em = $this->getDoctrine()->getEntityManager();
            $em->persist($post);
            $em->flush();

            if ($request->get('ajax', 0) == 1) {
                $message = new ApiMessage();
                $message->message = 'Post saved!';
                $message->status = ApiMessage::STATUS_SUCCESS;

                $response = new Response(json_encode($message));
                $response->setStatusCode(200);

                return $response;
            } else {
                $this->redirectToRoute('backend_posts_collection');
            }
        }

        return $this->render('fweberBackendBundle:Post:create.html.twig');
    }

    public function updateAction(Request $request, $postId)
    {
        $post = $this->getDoctrine()->getRepository('fweberDataBundle:Post')->findOneById($postId);

        if (!$post) {
            throw new \InvalidArgumentException('Post not found!');
        }

        //TODO: implement draft, publish date

        if ($request->get('sent', 0) == 1) {
            $post->setTitle($request->get('title'))
                ->setSlug(SlugGenerator::generate($request->get('title')))
                ->setText($request->get('text'))
                ->setIsDraft(false)
                ->setPublishDate(new \DateTime('now'));

            //validation
            $validator = $this->get('validator');
            $errors = $validator->validate($post);

            //error handling
            if (count($errors) > 0) {
                if ($request->get('ajax', 0) == 1) {
                    $message = new ApiMessage();
                    $message->message = (string)$errors;
                    $message->status = ApiMessage::STATUS_ERROR;

                    $response = new Response(json_encode($message));
                    $response->setStatusCode(400);

                    return $response;
                } else {
                    foreach ($errors as $error) {
                        $this->addFlash('error', $error);
                    }

                    return $this->render(
                        'fweberBackendBundle:Post:update.html.twig',
                        array(
                            'post' => $post,
                        )
                    );
                }
            }

            $em = $this->getDoctrine()->getEntityManager();
            $em->flush();

            if ($request->get('ajax', 0) == 1) {
                $message = new ApiMessage();
                $message->message = 'Post saved!';
                $message->status = ApiMessage::STATUS_SUCCESS;

                $response = new Response(json_encode($message));
                $response->setStatusCode(200);

                return $response;
            } else {
                $this->redirectToRoute('backend_posts_collection');
            }
        }

        return $this->render(
            'fweberBackendBundle:Post:update.html.twig',
            array(
                'post' => $post,
            )
        );
    }

    public function deleteAction(Request $request, $postId)
    {
        $post = $this->getDoctrine()->getRepository('fweberDataBundle:Post')->findOneById($postId);

        if (!$post) {
            throw new \InvalidArgumentException('Post not found!');
        }

        if ($request->get('sent', 0) == 1) {
            $em = $this->getDoctrine()->getEntityManager();
            $em->remove($post);
            $em->flush();

            return $this->redirectToRoute('backend_posts_collection');
        }

        return $this->render(
            'fweberBackendBundle:Post:delete.html.twig',
            array(
                'post' => $post,
            )
        );
    }
}
