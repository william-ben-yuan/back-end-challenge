<?php

namespace App\Http\Requests\Tracks;

use Illuminate\Foundation\Http\FormRequest;

class UpdateTrackRequest extends FormRequest
{
    /**
     * Determine if the user is authorized to make this request.
     */
    public function authorize(): bool
    {
        return true;
    }

    /**
     * Get the validation rules that apply to the request.
     *
     * @return array<string, \Illuminate\Contracts\Validation\Rule|array|string>
     */
    public function rules(): array
    {
        return [
            'title' => 'required|string',
            'artist' => 'required|string',
            'album' => 'required|string',
            'isrc' => 'required|string|size:12|unique:tracks,isrc,' . $this->route('track')->id,
        ];
    }
}