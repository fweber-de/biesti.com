<?php

namespace fweber\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

class PageController extends Controller
{
    public function dashboardAction()
    {
        return $this->render('fweberBackendBundle:Page:dashboard.html.twig');
    }
}
