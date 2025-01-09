<?php namespace ReaZzon\Editor\Classes\Controllers;

use Str;
use Storage;

use Illuminate\Http\JsonResponse;
use Illuminate\Http\UploadedFile;
use Illuminate\Routing\Controller;

use ReaZzon\Editor\Classes\Requests\AttachTool\UploadRequest;
use ReaZzon\Editor\Classes\Exceptions\ToolRequestErrorException;

class AttachesToolController extends Controller
{
    const EDITORJS_MEDIA_PATH = 'resources/editorjs_attaches';

    /**
     * @throws ToolRequestErrorException
     */
    public function upload(UploadRequest $request): JsonResponse
    {
        $file = $request->file('file');
        if (empty($file) || !$file instanceof UploadedFile) {
            throw new ToolRequestErrorException();
        }

        return $this->storeFile($file->getClientOriginalExtension(), $file->getContent());
    }

    private function storeFile($fileExtension, $fileContents): JsonResponse
    {
        if (!Storage::exists(self::EDITORJS_MEDIA_PATH)) {
            try {
                Storage::createDirectory(self::EDITORJS_MEDIA_PATH, [
                    'directory_visibility' => 'public'
                ]);
            } catch (\Exception $ex) {/* Mute this exception because on mass file pasting this can cause false error */}
        }

        $fileMediaPath = self::EDITORJS_MEDIA_PATH . '/' . Str::orderedUuid() . '.' . $fileExtension;

        if (!Storage::put($fileMediaPath, $fileContents)) {
            throw new ToolRequestErrorException();
        }

        return response()->json([
            'success' => 1,
            'file' => [
                'url' => url('storage/app/'.$fileMediaPath)
            ]
        ]);
    }
}
