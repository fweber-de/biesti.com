<?php

namespace fweber\WebsiteBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function indexAction()
    {
        return $this->render(':Page:index.html.twig');
    }

    public function portfolioAction()
    {

    }

    public function contactAction()
    {

    }

    public function imprintAction()
    {

    }
}