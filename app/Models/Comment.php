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

    /**
     * Returns the name of the profile_picture of the comment's user
     * 
     * @param int $id
     * @return string
     */
    public function get_user_profile_picture($id) {
        $user = User::where('id', $id)->paginate();
        $profile_picture = $user[0]->profile_picture;
        return $profile_picture;
    }

    /**
     * Returns the name of the user of the comment
     * 
     * @param int $id
     * @return string
     */
    public function get_user_name($id) {
        $user = User::find($id);
        $name = $user->name;
        return $name;
    }

}
