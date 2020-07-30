<?php namespace ReaZzon\Editor\Classes\Plugins\LinkTool;

use ReaZzon\Editor\Classes\Plugins\LinkTool\OpenGraph;

/**
 * LinkTool Plugin
 * @package ReaZzon\Editor\Classes\Plugins\LinkTool
 * @author Nick Khaetsky, nick@reazzon.ru
 */
class Plugin
{
    use \ReaZzon\Editor\Traits\PluginHelper;

    /**
     * LinkTool constructor
     */
    public function __construct()
    {
    }

    /**
     * @param $data
     * @return \Response
     */
    public function createResponse($data)
    {
        if (!array_has($data, 'url') && empty(array_get($data, 'url'))){
            return $this->error();
        }

        if (filter_var(array_get($data, 'url'), FILTER_VALIDATE_URL) === FALSE) {
            return $this->error();
        }

        if ($this->checkRequest()){
            return $this->error();
        }

        $graphResponse = OpenGraph::fetch(array_get($data, 'url'));
        return $this->success('meta', [
            'title' => $graphResponse->title,
            'description' => $graphResponse->description,
            'image' => [
                'url' => $graphResponse->image,
            ]
        ]);
    }
}