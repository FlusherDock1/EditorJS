<?php namespace ReaZzon\Editor\Classes\Plugins\LinkTool;

use ReaZzon\Editor\Classes\Plugins\LinkTool\OpenGraph;

class Plugin {

    /**
     * LinkTool constructor
     */
    public function __construct()
    {
    }

    /**
     * @param $data
     * @return array
     */
    public function createResponse($data)
    {
        if (!array_has($data, 'url') && empty(array_get($data, 'url'))){
            return $this->error();
        }

        if (filter_var(array_get($data, 'url'), FILTER_VALIDATE_URL) === FALSE) {
            return $this->error();
        }

        $graphResponse = OpenGraph::fetch(array_get($data, 'url'));
        return $this->success([
            "title" => $graphResponse->title,
            "description" => $graphResponse->description,
            "image" => [
                "url" => $graphResponse->image,
            ]
        ]);
    }

    protected function success($response)
    {
        return [
            'success' => 1,
            'meta' => $response
        ];
    }

    protected function error()
    {
        return [
            'success' => 0
        ];
    }
}