<?php namespace ReaZzon\Editor\Classes\Exceptions;

use October\Rain\Exception\ApplicationException;

/**
 * Class PluginErrorException
 * @package ReaZzon\Editor\Classes\Exceptions
 */
class PluginErrorException extends ApplicationException
{
    protected $code = 406;

    /**
     * @return array
     */
    public function render(): array
    {
        $errorBody = [
            'success' => 0
        ];

        if (!empty($this->getMessage())) {
            $errorBody['message'] = $this->getMessage();
        }

        return $errorBody;
    }
}
