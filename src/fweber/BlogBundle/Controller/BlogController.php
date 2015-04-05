<?php

namespace fweber\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    public function postsAction()
    {
        $posts = $this->getDoctrine()->getRepository('fweberDataBundle:Post')->findBy(
            array(),
            array('publishDate' => 'desc')
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
