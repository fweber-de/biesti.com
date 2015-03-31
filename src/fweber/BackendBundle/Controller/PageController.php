<?php

namespace fweber\BackendBundle\Controller;

use Symfony\Bundle\FrameworkBundle\Controller\Controller;

/**
 * @author Florian Weber <florian.weber@fweber.info>
 */
class PageController extends Controller
{
    public function dashboardAction()
    {
        return $this->render('fweberBackendBundle:Page:dashboard.html.twig');
    }
}
