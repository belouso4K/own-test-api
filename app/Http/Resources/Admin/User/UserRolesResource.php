<?php

namespace App\Http\Resources\Admin\User;

use Illuminate\Http\Resources\Json\JsonResource;
use Illuminate\Support\Facades\Storage;

class UserRolesResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array|\Illuminate\Contracts\Support\Arrayable|\JsonSerializable
     */
    public function toArray($request)
    {
        $role = $this->roles()->exists()
            ? $this->roles()->first()->only(['id'])
            : '';

        $avatar = Storage::exists($this->avatar) ?  '' : 'avatar/';

        return [
            'id' => $this->id,
            'name' => $this->name,
            'email' => $this->email,
            'avatar' => env('APP_URL'). '/storage/' . $avatar . $this->avatar,
            'role' => [
                'name' => $this->role->name,
                'desc' => $this->role->desc,
            ],
        ];
    }
}
