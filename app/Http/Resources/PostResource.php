<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // Kalau kita ingin sama ajanya dengan data yang kita terima dari model
        // return parent::toArray($request);

        // Kalau kita menerima data dari model ingin berbeda dengan response yang kita kirimkan
        // $square = 4 * 4;
        return [
            'id' => $this->id,
            'title' => $this->title,
            /* 'whatever' => $square,
            'test' => 'test' */
            'news_content' => $this->news_content,
            // Default created_at
            // 'created_at' => $this->created_at,
            // Ubah format created_at y-m-d
            // 'created_at' => $this->created_at->format('Y/m/d'),
            // Ubah format created_at y-m-d H:i:s
            'created_at' => $this->created_at->format('Y/m/d H:i:s'),
        ];
    }
}
