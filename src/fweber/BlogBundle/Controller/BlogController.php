<?php

namespace fweber\BlogBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class BlogController extends Controller
{
    public function postsAction()
    {
        return $this->render(':Blog:posts.html.twig');
    }
}