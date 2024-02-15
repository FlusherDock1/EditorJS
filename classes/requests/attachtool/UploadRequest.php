<?php namespace ReaZzon\Editor\Classes\Requests\AttachTool;

use Illuminate\Foundation\Http\FormRequest;

class UploadRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, mixed>
     */
    public function rules()
    {
        return [
            'file' => 'file|required'
        ];
    }
}
