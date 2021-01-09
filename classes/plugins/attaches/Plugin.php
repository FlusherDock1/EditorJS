<?php namespace ReaZzon\Editor\Classes\Plugins\Attaches;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\UploadedFile;
use ReaZzon\Editor\Classes\Exceptions\PluginErrorException;
use ReaZzon\Editor\Classes\Plugins\Attaches\Resources\AttachResource;
use Illuminate\Http\Request;
use System\Models\File;

/**
 * Image Plugin
 * @package ReaZzon\Editor\Classes\Plugins\Attaches
 * @author Nick Khaetsky, nick@reazzon.ru
 */
class Plugin
{
    /**
     * Attaches
     * @return Responsable
     */
    public function __invoke(Request $request): Responsable
    {
        $file = $request->file('file');
        if (null === $file || !$file instanceof UploadedFile) {
            throw new PluginErrorException;
        }

        $file = $this->processFile($file);
        return new AttachResource($file);
    }

    /**
     * @param UploadedFile $uploadedFile
     * @return File
     */
    protected function processFile(UploadedFile $uploadedFile): File
    {
        $file = new File;
        $file->fromPost($uploadedFile);

        return $file;
    }
}
