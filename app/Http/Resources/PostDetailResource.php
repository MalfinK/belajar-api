<?php

namespace App\Http\Resources;

use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class PostDetailResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        // return parent::toArray($request);

        return [
            'id' => $this->id,
            'title' => $this->title,
            'news_content' => $this->news_content,
            'created_at' => $this->created_at->format('Y/m/d H:i:s'),
            'author' => $this->author,
            // 'writer' => $this->writer,
            // Pakai eager loading
            'writer' => $this->whenLoaded('writer'),

            /*
                Note:
                Penggunaan eager loading ini sangat penting untuk menghindari N+1 query problem, karena jika kita tidak menggunakan eager loading, maka akan terjadi query berulang terhadap tabel users. Kalau di lihat pada PostController.php, ada yang show() dan show2(), pada show() kita menggunakan with() atau load() untuk eager loading, sedangkan pada show2() kita tidak menggunakan eager loading, maka dari itu kita harus menggunakan eager loading agar tidak terjadi N+1 query problem. Hal ini nantinya data nya kalau ga pakai eager loading yang di show2() jadi keambil relasinya juga saat API nya di panggil, padahal kan ga pakai with ya.
            */
            // Cara 1 (sendiri)
            // 'comments' => CommentResource::collection($this->whenLoaded('comments')),
            // Cara 2 (video)
            'comments' => $this->whenLoaded('comments', function () {
                return collect($this->comments)->each(function ($comment) { // biasa pake map tapi disini pake each
                    $comment->commentator;
                    return $comment;
                });
            }),
            'comments_total' => $this->whenLoaded('comments', function () {
                return $this->comments->count();
            }),
        ];
    }
}
