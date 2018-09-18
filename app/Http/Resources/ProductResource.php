<?php

namespace App\Http\Resources;

use Illuminate\Http\Resources\Json\Resource;

class ProductResource extends Resource
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
            'category_id' => $this->category_id,
            'user_id' => $this->user_id,
            'sold_count' => $this->sold_count,
            'video_url' => $this->video_url,
            'assurance' => $this->assurance,
            'bl_id' => $this->bl_id,
            'url' => $this->url,
            'name' => $this->name,
            'city' => $this->city,
            'province' => $this->province,
            'price' => $this->price,
            'weight' => $this->weight,
            'description' => $this->description,
            'product_condition' => $this->product_condition,
            'stock' => $this->stock,
            'view_count' => $this->view_count,
        ];
    }
}