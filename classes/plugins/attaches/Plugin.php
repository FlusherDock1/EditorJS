<?php namespace ReaZzon\Editor\Classes\Plugins\Attaches;

use System\Models\File;
use Illuminate\Http\UploadedFile;

/**
 * Image Plugin
 * @package ReaZzon\Editor\Classes\Plugins\Attaches
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
        if ($this->checkRequest()){
            return $this->error();
        }

        return $this->processFile($data);
    }

    /**
     * @param $data
     * @return \Response
     */
    protected function processFile($data)
    {
        if (!array_has($data, 'file') && empty(array_get($data, 'file'))){
            return $this->error();
        }

        $file = new File();
        $file->fromPost(array_get($data, 'file'));
        $file->save();

        return $this->success('file', [
            'url' => $file->path,
            'name' => $file->file_name,
            'size' => $file->file_size,
            'extension' => $file->getExtension()
        ]);
    }
}