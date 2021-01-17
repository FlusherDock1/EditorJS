<?php namespace ReaZzon\Editor\Classes\Plugins\Image;

use Illuminate\Contracts\Support\Responsable;
use Illuminate\Http\Request;
use Illuminate\Http\UploadedFile;
use ReaZzon\Editor\Classes\Exceptions\PluginErrorException;
use ReaZzon\Editor\Classes\Plugins\Image\Resources\ImageResource;
use System\Models\File;

/**
 * Image Plugin
 * @package ReaZzon\Editor\Classes\Plugins\Image
 * @author Nick Khaetsky, nick@reazzon.ru
 */
class Plugin
{
    const MEDIA_FOLDER = 'media/editor';

    /**
     * @var string[]
     */
    private $whitelist = [
        'uploadFile',
        'fetchUrl'
    ];

    /**
     * Image
     *
     * @param string $type
     * @param Request $request
     * @return Responsable
     * @throws PluginErrorException
     */
    public function __invoke(string $type, Request $request): Responsable
    {
        if (!\in_array($type, $this->whitelist, true)) {
            throw new PluginErrorException;
        }

        try {
            $file = $this->$type($request);
            return new ImageResource($file);
        } catch(\Exception $e) {
            throw new PluginErrorException;
        }
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function uploadFile(Request $request): string
    {
        /** @var UploadedFile $image */
        $image = $request->file('image');
        if (null === $image || !$image instanceof UploadedFile){
            throw new PluginErrorException;
        }

        $file = new File;
        $file->fromPost($image);

        return $this->proccessFile($file);
    }

    /**
     * @param Request $request
     * @return string
     */
    protected function fetchUrl(Request $request): string
    {
        $fileUrl = $request->input('url');
        if (empty($fileUrl)){
            throw new PluginErrorException;
        }

        $file = new File();
        $file->fromUrl($fileUrl, last(explode('/', $fileUrl)));

        return $this->proccessFile($file);
    }

    /**
     * @param File $file
     * @return string
     */
    private function proccessFile(File $file): string
    {
        if (!$file->isImage()) {
            throw new PluginErrorException;
        }

        $attempt = 0;
        $fileMoveToDirectory = static::MEDIA_FOLDER . DIRECTORY_SEPARATOR . $file->getFilename();

        checkFile:
        $attempt++;
        if ($file->getDisk()->exists($fileMoveToDirectory)) {
            $newFileName = sprintf('%s (%s).%s',
                str_replace('.'. $file->getExtension(), '', $file->getFilename()),
                $attempt,
                $file->getExtension()
            );

            $fileMoveToDirectory = static::MEDIA_FOLDER . DIRECTORY_SEPARATOR . $newFileName;
            goto checkFile;
        }

        $file->getDisk()->move($file->getDiskPath(), $fileMoveToDirectory);
        return url('storage/app/'. $fileMoveToDirectory);
    }
}
