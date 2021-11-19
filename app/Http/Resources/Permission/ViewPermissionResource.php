<?php

namespace App\Http\Resources\Permission;

use Illuminate\Http\Resources\Json\JsonResource;

class ViewPermissionResource extends JsonResource
{
    public function toArray($request)
    {

        return [
            'id' => $this->id,
            'name' => $this->name,
            'roles' => $this->roles->pluck('name'),
        ];
        
    }
}
