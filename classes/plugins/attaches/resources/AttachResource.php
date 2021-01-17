<?php namespace ReaZzon\Editor\Classes\Plugins\Attaches\Resources;


use Illuminate\Http\Resources\Json\Resource;
use System\Models\File;

/**
 * Class AttachResource
 * @package ReaZzon\Editor\Classes\Plugins\Attaches\Resources
 */
class AttachResource extends Resource
{
    /**
     * @var string
     */
    public static $wrap = 'file';

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
            'url'       => $this->resource->getPath(),
            'name'      => $this->resource->getFileName(),
            'size'      => $this->resource->file_size,
            'extension' => $this->resource->getExtension()
        ];
    }
}
