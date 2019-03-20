<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\JsonResource;

class House extends JsonResource
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
            'id' => $this->id,
            'name' => $this->name,
            'price' => $this->price,
            'bedrooms' => $this->bedrooms,
            'bathrooms' => $this->bathrooms,
            'storeys' => $this->storeys,
            'garages' => $this->garages
        ];
    }
    
    public function with($request)
    {
        return [
            'version' => '1.0.0',
            'author_url' => url('https://github.com/garstvic')
        ];
    }
}
