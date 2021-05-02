<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\HomeController;
use App\Http\Controllers\RoleController;
use App\Http\Controllers\UserController;
use App\Http\Controllers\PostController;
use App\Http\Controllers\LogController;
use App\Models\Post;
use App\Models\Type;
use App\Models\Category;

//use App\Models\Post;

/*
  |--------------------------------------------------------------------------
  | Web Routes
  |--------------------------------------------------------------------------
  |
  | Here is where you can register web routes for your application. These
  | routes are loaded by the RouteServiceProvider within a group which
  | contains the "web" middleware group. Now create something great!
  |
 */



Route::get('/', function () {
    if (Auth::check()) {
        $one_user = false;
        $msg = '';
        $types = Type::get();
        $categories = Category::get();
        $posts = Post::all()->sortByDesc("id");
        return view('posts.index', compact('posts', 'msg', 'types', 'categories', 'one_user'));
    } else {
        return view('auth.login');
    }
});

Auth::routes();

Route::get('/home', [HomeController::class, 'index'])->name('home');

Route::group(['middleware' => ['auth']], function() {
    Route::resource('roles', RoleController::class);
    Route::resource('users', UserController::class);
    Route::resource('posts', PostController::class);
});

Route::match(array('GET', 'POST'), '/MyPosts', [PostController::class, 'user_posts'])->name('user_posts');
Route::get('/history', [LogController::class, 'index'])->name('log');

