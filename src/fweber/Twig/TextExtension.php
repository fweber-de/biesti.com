<?php

namespace fweber\Twig;

class TextExtension extends \Twig_Extension
{
    public function getFilters()
    {
        return array(
            new \Twig_SimpleFilter('ellipse', array($this, 'ellipseFilter')),
        );
    }

    public function ellipseFilter($text, $length = 40)
    {
        if (strlen($text) <= $length) {
            return $text;
        }

        return substr($text, 0, $length - 3) . '...';
    }

    public function getName()
    {
        return 'text_extension';
    }
}