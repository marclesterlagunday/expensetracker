<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class Role extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        return [
            'role_id' => $this->id,
            'role_name' => $this->role_name,
            'role_description' => $this->role_description,
            'created_at' => date_format(date_create($this->created_at), 'Y-m-d')
        ];
    }
}
