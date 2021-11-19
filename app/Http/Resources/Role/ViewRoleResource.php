<?php

namespace App\Http\Resources\Role;

use Illuminate\Http\Resources\Json\JsonResource;

class ViewRoleResource extends JsonResource
{
    public function toArray($request)
    {
        $permissions = collect($this->permissions ?? [])
            ->groupBy('group_name')->toArray();

        return [
            'id' => $this->id,
            'name' => $this->display_name,
            'type' => $this->type,
            'company_id' => $this->company_id,
            'permissions' => $permissions,
        ];
    }
}
