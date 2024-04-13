<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Post extends Model
{
    use HasFactory, SoftDeletes;

    protected $guarded = ['id'];

    public function writer()
    {
        // Bisa gini (cara lama)
        // return $this->belongsTo(User::class, 'author', 'id');
        // Bisa gini (cara baru)
        return $this->belongsTo(User::class, 'author'); // sudah otomatis mencari id di tabel users
        /*
            Note:
            Kalau relasinya mau author, seharusnya author_id karena nanti akan nabrak dengan field author di tabel posts yang merupakan foreign key dari tabel users, sehingga di PostDetailResource.php saat kita declare seperti ini
            return [
                ...
                'author' => $this->author,
                'written_by' => $this->author,
            ];
            maka akan bingung laravel, apakah author itu field di tabel posts atau relasi ke tabel users, maka dari itu kita harus menambahkan parameter kedua di belongsTo() yaitu author_id
        */
    }
}
