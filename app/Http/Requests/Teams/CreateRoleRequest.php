<?php

namespace App\Http\Requests\Teams;

use Illuminate\Foundation\Http\FormRequest;


class CreateRoleRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        $array= [
            "name" => "required|min:3",
            "permissions" => "required|array",
           
        ];
        return $array;
    }
}
