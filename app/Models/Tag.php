<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Tag extends Model
{
    use HasFactory;

    protected $hidden = ['pivot'];

    protected $perPage = 10;

    public $timestamps = false;
//
//    const UPDATED_AT = null;

    protected $fillable = [
        'slug',
        'tag',
    ];

    public function posts() {
        return $this->belongsToMany(Post::class);
    }

}
