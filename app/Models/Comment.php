<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Comment extends Model {

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * 	
     * @var array
     */
    protected $fillable = [
        'text', 'post_id', 'user_id'
    ];

}
