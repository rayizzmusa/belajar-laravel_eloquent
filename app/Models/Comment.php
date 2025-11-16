<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\MorphTo;

class Comment extends Model
{
    protected $table = "comments";
    protected $primaryKey = "id";
    protected $keyType = "int";
    public $incrementing = true;
    public $timestamps = true; //defaultnya true

    //default value management
    protected $attributes = [
        'comment' => 'sample comment default',
        'title' => 'sample title default',
    ];

    public function commentable(): MorphTo
    {
        return $this->morphTo();
    }
}
