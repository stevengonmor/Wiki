<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model {

    use HasFactory;

    /**
     * The attributes that are mass assignable.
     * 	
     * @var array
     */
    protected $fillable = [
        'tittle', 'text', 'type_id', 'category_id', 'user_id', 'status_id', 'picture'
    ];

    public function get_user_profile_picture($id) {
        $user = User::where('id', $id)->paginate();
        $profile_picture = $user[0]->profile_picture;
        return $profile_picture;
    }

    public function get_id_name($column, $id) {
        switch ($column) {
            case 'users':
                $object = User::where('id', $id)->paginate();
                break;
            case 'types':
                $object = Type::where('id', $id)->paginate();
                break;
            case 'categories':
                $object = Category::where('id', $id)->paginate();
                break;
            case 'statuses':
                $object = Status::where('id', $id)->paginate();
                break;
        }
        $name = $object[0]->name;
        return $name;
    }

}
