<?php

namespace App\Http\Resources;

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

        //transforms the resource into an array made up of the attributes to be converted to JSON
        return [
            'id' => $this->id,
            'first_name' => $this->first_name,
            'last_name' => $this->last_name,
            'email' => $this->email,
            'date_of_birth' => $this->date_of_birth,
            'number_of_points' => $this->number_of_points,
            'government' => $this->government,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
