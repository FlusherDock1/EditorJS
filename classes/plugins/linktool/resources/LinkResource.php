<?php namespace ReaZzon\Editor\Classes\Plugins\LinkTool\Resources;


use Illuminate\Http\Resources\Json\Resource;

/**
 * Class LinkResource
 * @package ReaZzon\Editor\Classes\Plugins\LinkTool\Resources
 */
class LinkResource extends Resource
{
    /**
     * @var string
     */
    public static $wrap = 'meta';

    /**
     * @var array
     */
    public $additional = [
        'success' => 1
    ];

    /**
     * @param \Illuminate\Http\Request $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'title'       => optional($this->resource)->title,
            'description' => optional($this->resource)->description,
            'image'       => [
                'url' => optional($this->resource)->image
            ]
        ];
    }
}
