<?php

namespace App\Models;

use App\Scopes\LatestScope;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class Comments extends Model
{
    use HasFactory;
    use SoftDeletes;

    public function blog_post()
    {
        return $this->belongsTo(BlogPost::class);
    }

    public static function boot(){
        parent::boot();

        static::addGlobalScope(new LatestScope);
    } 
}
