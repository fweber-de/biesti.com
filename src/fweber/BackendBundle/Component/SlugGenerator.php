<?php

namespace fweber\BackendBundle\Component;

/**
 * @author Florian Weber <florian.weber@fweber.info>
 */
class SlugGenerator
{
    /**
     * Generates a Slug.
     *
     * @param $str string
     *
     * @return string
     */
    public static function generate($str)
    {
        // replace non letter or digits by -
        $str = preg_replace('~[^\\pL\d]+~u', '-', $str);

        // trim
        $str = trim($str, '-');

        // transliterate
        $str = iconv('utf-8', 'us-ascii//TRANSLIT', $str);

        // lowercase
        $str = strtolower($str);

        // remove unwanted characters
        $str = preg_replace('~[^-\w]+~', '', $str);

        if (empty($str)) {
            return 'n-a';
        }

        return $str;
    }
}
