<?php namespace ReaZzon\Editor\Classes\Exceptions;

use October\Rain\Exception\ApplicationException;

class ToolRequestErrorException extends ApplicationException
{
    protected $code = 406;

    /**
     * __construct the exception
     */
    public function __construct($contents = null)
    {
        $contents = [
            'success' => 0,
            'message' => $contents
        ];

        parent::__construct(json_encode($contents));
    }
}
