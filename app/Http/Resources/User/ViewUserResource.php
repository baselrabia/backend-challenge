<?php

namespace App\Http\Resources\User;

use Illuminate\Http\Resources\Json\JsonResource;

class ViewUserResource extends JsonResource
{
    public function toArray($request)
    {
 
        return [
            'id'           => $this->id,
            'name'         => $this->name,
            "email"        => $this->email,
            'roles'        => $this->roles->pluck('name'),
            'permissions'  => $this->permissions->pluck('name'),


            'created_at' => $this->created_at ? $this->created_at->format('Y-m-d H:m:s') : '',
            'updated_at' => $this->updated_at ? $this->updated_at->format('Y-m-d H:m:s') : '',
    ];
    }
}
