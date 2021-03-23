<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class WorkerResource extends JsonResource
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
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'age'=>$this->age,
            'salary'=>$this->salary,
            'vehicle_type'=>$this->vehicle_type,
            'role'=>$this->role,
            'government'=>$this->government,
            'rating'=>$this->rating,
            'raters'=>$this->raters,
       ];
    }
}
