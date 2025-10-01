<?php

namespace App\Http\Requests\Api\V1;

use Illuminate\Foundation\Http\FormRequest;

class BuildingRadiusSearchRequest extends FormRequest
{
    public function authorize(): bool
    {
        return true;
    }

    public function rules(): array
    {
        return [
            'lat' => 'required|numeric',
            'lon' => 'required|numeric',
            'radius' => 'nullable|numeric|min:1',
        ];
    }
}
