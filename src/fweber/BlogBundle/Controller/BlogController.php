<?php

namespace fweber\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    public function postsAction()
    {
        $posts = $this->getDoctrine()->getRepository('fweberDataBundle:Post')->findAll();

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

        return $this->render(
            ':Blog:post.html.twig',
            array(
                'post' => $post,
            )
        );
    }
}
