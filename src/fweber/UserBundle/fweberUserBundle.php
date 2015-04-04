<?php

namespace fweber\UserBundle;

use Symfony\Component\HttpKernel\Bundle\Bundle;

class fweberUserBundle extends Bundle
{
    public function getParent()
    {
        return 'FOSUserBundle';
    }
}
