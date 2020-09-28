<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class UserResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return array
     */
    public function toArray($request)
    {
        $userRoles = $this->roles()->with('permissions')->get();
        $roles = $userRoles->pluck('slug');
        $rolesPermissions = $userRoles->pluck('permissions')->flatten(1)->pluck('slug');
        $userPermissions = $rolesPermissions->merge($this->permissions->pluck('slug'));

        return [
            'fullname' => $this->fullname,
            'username' => $this->username,
            'email' => $this->email,
            'handphone' => $this->handphone,
            'created_at' => $this->created_at->format('Y-m-d'),
            'role' => $this->role,
            'permissions' => $userPermissions,
            'openTicketCount' => $this->tickets->where('status', 'open')->count(),
            'closedTicketCount' => $this->tickets->where('status', 'closed')->count(),
            'projectCount' => $this->projects->count(),
            'company' => $this->company
        ];
    }
}
