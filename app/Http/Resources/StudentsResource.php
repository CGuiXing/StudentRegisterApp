<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class StudentsResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray($request)
    {
        return [
            'id' => (string)$this->id,
                'type' => 'Students',
                'attributes' => [
                    'name' => $this->name,
                    'email' => $this->email, 
                    'address' => $this->address, 
                    'study course' => $this->study_course,
                ]
        ];
    }
}
