<?php namespace ReaZzon\Editor\Classes\Controllers;

use Str;
use Storage;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller;

use ReaZzon\Editor\Classes\Exceptions\ToolRequestErrorException;
use ReaZzon\Editor\Classes\Requests\ImageTool\{FetchRequest, UploadRequest};

class ImageToolController extends Controller
{
    const EDITORJS_MEDIA_PATH = 'media/editorjs';

    /**
     * @throws ToolRequestErrorException
     */
    public function upload(UploadRequest $request): JsonResponse
    {
        $image = $request->file('image');
        if (empty($image) || !$image instanceof UploadedFile){
            throw new ToolRequestErrorException();
        }

        return $this->storeImage($image->getClientOriginalExtension(), $image->getContent());
    }

    public function fetch(FetchRequest $request): JsonResponse
    {
        $imageUrl = $request->get('url');
        if (empty($imageUrl) || !filter_var($imageUrl, FILTER_VALIDATE_URL)) {
            throw new ToolRequestErrorException();
        }

        return $this->storeImage(pathinfo($imageUrl, PATHINFO_EXTENSION), file_get_contents($imageUrl));
    }

    private function storeImage($imageExtension, $imageContents): JsonResponse
    {
        if (!Storage::exists(self::EDITORJS_MEDIA_PATH)) {
            Storage::createDirectory(self::EDITORJS_MEDIA_PATH);
        }

        $imageMediaPath = self::EDITORJS_MEDIA_PATH . '/' . Str::orderedUuid() . '.' . $imageExtension;

        if (!Storage::put($imageMediaPath, $imageContents)) {
            throw new ToolRequestErrorException();
        }

        return response()->json([
            'success' => 1,
            'file' => [
                'url' => url('storage/app/'.$imageMediaPath)
            ]
        ]);
    }
}
