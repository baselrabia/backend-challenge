<?php

namespace Modules\TeamManagement\Http\Requests\Teams;

use Modules\TeamManagement\Entities\Role;
use Illuminate\Foundation\Http\FormRequest;

class ListRolesRequest extends FormRequest
{
    /**
     * Get the validation rules that apply to the request.
     *
     * @return array
     */
    public function rules(): array
    {
        return [
            'search' => 'string|nullable'
        ];
    }
}
