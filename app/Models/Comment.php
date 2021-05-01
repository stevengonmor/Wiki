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

    public function get_user_profile_picture($id) {
        $user = User::where('id', $id)->paginate();
        $profile_picture = $user[0]->profile_picture;
        return $profile_picture;
    }

    public function get_user_name($id) {
        $user = User::where('id', $id)->paginate();
        $name = $user[0]->name;
        return $name;
    }

}
