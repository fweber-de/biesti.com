<?php

namespace fweber\Twig;

class AppExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('gravatarHash', array($this, 'gravatarHashFilter')),
        );
    }

    public function gravatarHashFilter($email)
    {
        return md5(strtolower(trim($email)));
    }

    public function getName()
    {
        return 'app_extension';
    }
}
