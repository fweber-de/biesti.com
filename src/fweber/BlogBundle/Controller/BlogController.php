<?php

namespace fweber\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;
use Symfony\Component\HttpFoundation\Request;

class BlogController extends Controller
{
    public function postsAction(Request $request)
    {
        $posts = $this->getDoctrine()->getRepository('fweberDataBundle:Post')->findAllPublished(
            $this->get('knp_paginator'),
            $request->query->get('page', 1),
            $request->query->get('limit', 10)
        );

        return $this->render(
            ':Blog:posts.html.twig',
            array(
                'posts' => $posts,
            )
        );
    }

    public function postAction($slug)
    {
        $post = $this->getDoctrine()->getRepository('fweberDataBundle:Post')->findOneBySlug($slug);

        if (!$post || $post->getIsDraft()) {
            return $this->redirectToRoute('blog_posts');
        }

        return $this->render(
            ':Blog:post.html.twig',
            array(
                'post' => $post,
            )
        );
    }

    public function tagsAction()
    {
        $tags = $this->getDoctrine()->getRepository('fweberDataBundle:Category')->findAll();

        return $this->render(
            ':Blog:tags.html.twig',
            array(
                'tags' => $tags,
            )
        );
    }

    public function tagAction($slug)
    {
        $tag = $this->getDoctrine()->getRepository('fweberDataBundle:Category')->findOneBySlug($slug);

        return $this->render(
            ':Blog:tag.html.twig',
            array(
                'tag' => $tag,
            )
        );
    }

    public function tagCloudAction()
    {
        $tags = $this->getDoctrine()->getRepository('fweberDataBundle:Category')->findAll();

        return $this->render(
            ':Blog:_tag_cloud.html.twig',
            array(
                'tags' => $tags,
            )
        );
    }
}
