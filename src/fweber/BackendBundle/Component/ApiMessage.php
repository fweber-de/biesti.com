<?php

namespace fweber\BackendBundle\Component;

/**
 * @author Florian Weber <florian.weber@fweber.info>
 */
class ApiMessage
{
    const STATUS_ERROR = 'error';
    const STATUS_SUCCESS = 'success';

    /**
     * @var string
     */
    public $message;

    /**
     * @var string
     */
    public $status;
}
