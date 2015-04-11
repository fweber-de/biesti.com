<?php

namespace fweber\BackendBundle\Controller;

use Doctrine\Common\Collections\ArrayCollection;
use fweber\BackendBundle\Component\ApiMessage;
use fweber\BackendBundle\Component\SlugGenerator;
use fweber\DataBundle\Entity\Category;
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
        $tags = $this->getDoctrine()->getRepository('fweberDataBundle:Category')->findAll();

        //TODO: implement draft, publish date
        if ($request->get('sent', 0) == 1) {
            $post = new Post();
            $post->setTitle($request->get('title'))
                ->setSlug(SlugGenerator::generate($request->get('title')))
                ->setText($request->get('text'))
                ->setOpenDate(new \DateTime('now'))
                ->setPublishDate(new \DateTime('now'))
                ->setUser($this->getUser())
                ->setMainImageUrl($request->get('main'));

            //draft
            if ((bool)$request->get('publish', false) == true) {
                $post->setIsDraft(false);
            } else {
                $post->setIsDraft(true);
            }

            //handle tags
            $_tags = json_decode($request->get('tags'));

            if (!is_null($_tags)) {
                $tagCollection = new ArrayCollection();

                foreach ($_tags as $_tag) {
                    $tag = $this->getDoctrine()->getRepository('fweberDataBundle:Category')->findOneByTitle($_tag);

                    //if tag is unknown create new
                    if (!$tag) {
                        $tag = new Category();
                        $tag->setTitle($_tag)
                            ->setSlug(SlugGenerator::generate($_tag));

                        //validation
                        $validator = $this->get('validator');
                        $errors = $validator->validate($tag);

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
                                    'fweberBackendBundle:Post:create.html.twig',
                                    array(
                                        'tags' => $tags,
                                    )
                                );
                            }
                        }

                        $em = $this->getDoctrine()->getEntityManager();
                        $em->persist($tag);
                        $em->flush();
                    }

                    $tagCollection->add($tag);
                }

                $post->setCategories($tagCollection);
            }

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
                        'fweberBackendBundle:Post:create.html.twig',
                        array(
                            'tags' => $tags,
                        )
                    );
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
                return $this->redirectToRoute('backend_posts_collection');
            }
        }

        return $this->render(
            'fweberBackendBundle:Post:create.html.twig',
            array(
                'tags' => $tags,
            )
        );
    }

    public function updateAction(Request $request, $postId)
    {
        $post = $this->getDoctrine()->getRepository('fweberDataBundle:Post')->findOneById($postId);
        $tags = $this->getDoctrine()->getRepository('fweberDataBundle:Category')->findAll();

        if (!$post) {
            throw new \InvalidArgumentException('Post not found!');
        }

        //TODO: implement draft, publish date
        if ($request->get('sent', 0) == 1) {
            $post->setTitle($request->get('title'))
                ->setSlug(SlugGenerator::generate($request->get('title')))
                ->setText($request->get('text'))
                ->setMainImageUrl($request->get('main'));

            //draft
            if ((bool)$request->get('publish', false) == true) {
                $post->setIsDraft(false);
            }

            //handle tags
            $_tags = json_decode($request->get('tags'));

            if (!is_null($_tags)) {
                $tagCollection = new ArrayCollection();

                foreach ($_tags as $_tag) {
                    $tag = $this->getDoctrine()->getRepository('fweberDataBundle:Category')->findOneByTitle($_tag);

                    //if tag is unknown create new
                    if (!$tag) {
                        $tag = new Category();
                        $tag->setTitle($_tag)
                            ->setSlug(SlugGenerator::generate($_tag));

                        //validation
                        $validator = $this->get('validator');
                        $errors = $validator->validate($tag);

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
                                    'fweberBackendBundle:Post:create.html.twig',
                                    array(
                                        'tags' => $tags,
                                    )
                                );
                            }
                        }

                        $em = $this->getDoctrine()->getEntityManager();
                        $em->persist($tag);
                        $em->flush();
                    }

                    $tagCollection->add($tag);
                }

                $post->setCategories($tagCollection);
            } else {
                $post->setCategories(new ArrayCollection());
            }

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
                            'tags' => $tags,
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
                return $this->redirectToRoute('backend_posts_collection');
            }
        }

        return $this->render(
            'fweberBackendBundle:Post:update.html.twig',
            array(
                'post' => $post,
                'tags' => $tags,
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

    public function previewAction($postId)
    {
        $post = $this->getDoctrine()->getRepository('fweberDataBundle:Post')->findOneById($postId);

        return $this->render(
            ':Blog:post.html.twig',
            array(
                'post' => $post,
                'preview' => true,
            )
        );
    }
}
