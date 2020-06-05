<?php namespace ReaZzon\Editor\Classes\Plugins\Image;

use Storage;

class Plugin
{
    use \ReaZzon\Editor\Traits\PluginHelper;

    const MEDIA_FOLDER = 'editor';
    const MIME_TYPES = ['image/jpeg','image/gif','image/png','image/bmp','image/svg+xml'];

    /**
     * LinkTool constructor
     */
    public function __construct()
    {
    }

    /**
     * @param $data
     * @param $type
     * @return \Response
     */
    public function createResponse($type, $data)
    {
        if ($this->checkRequest()){
            return $this->error();
        }

        if ($type === 'uploadFile'){
            return $this->processFile($data);
        }

        if ($type === 'fetchUrl'){
            return $this->processUrl($data);
        }
    }

    protected function processFile($data)
    {
        if (!array_has($data, 'image') && empty(array_get($data, 'image'))){
            return $this->error();
        }

        if ($this->checkMime(array_get($data, 'image')->getMimeType())){
            return $this->error();
        }

        $file = Storage::put('media/'.self::MEDIA_FOLDER, array_get($data, 'image'));

        return $this->success('file', [
            'url' => url('storage/app/'.$file)
        ]);
    }

    protected function processUrl($data)
    {
        if (!array_has($data, 'url') && empty(array_get($data, 'url'))){
            return $this->error();
        }

        $image = file_get_contents(array_get($data, 'url'));

        if ($this->checkMime((new \finfo(FILEINFO_MIME_TYPE))->buffer($image))){
            return $this->error();
        }

        $fileUrl = explode('/', array_get($data, 'url'));
        $filename = end($fileUrl);

        if (!Storage::put('media/'.self::MEDIA_FOLDER.'/'.$filename, $image)){
            return $this->error();
        }

        return $this->success('file', [
            'url' => url('storage/app/media/'.self::MEDIA_FOLDER.'/'.$filename)
        ]);
    }

    /**
     * @param $mime
     * @return bool|void
     */
    protected function checkMime($mime)
    {
        if (!in_array($mime, self::MIME_TYPES)){
            return true;
        }
    }
}