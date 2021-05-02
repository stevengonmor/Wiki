<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Type;
use App\Models\Category;
use App\Models\Status;
use App\Models\Comment;
use Illuminate\Http\Request;

class PostController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct() {
        $this->middleware('permission:Ver Publicaciones', ['only' => ['index', 'store', 'show']]);
        $this->middleware('permission:Crear Publicaciones', ['only' => ['create', 'store']]);
        $this->middleware('permission:Editar Publicaciones', ['only' => ['edit', 'update']]);
        $this->middleware('permission:Eliminar Publicaciones', ['only' => ['destroy']]);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request) {
        $msg = '';
        $one_user = false;
        $types = Type::get();
        $categories = Category::get();
        if (!empty($request['type_id']) && !empty($request['category_id'])) {
            $posts = Post::where('type_id', $request['type_id'])->where('category_id', $request['category_id'])->orderBy('id', 'desc')->paginate();
            if (!$posts[0]) {
                $msg = "No hay ninguna publicación que comparte ese tipo y categoría";
            }
        } else if (!empty($request['type_id'])) {
            $posts = Post::where('type_id', $request['type_id'])->orderBy('id', 'desc')->paginate();
            if (!$posts[0]) {
                $msg = "No hay ninguna publicación de este tipo";
            }
        } else if (!empty($request['category_id'])) {
            $posts = Post::where('category_id', $request['category_id'])->orderBy('id', 'desc')->paginate();
            if (!$posts[0]) {
                $msg = "No hay ninguna publicación de esta categoría";
            }
        } else {
            $posts = Post::all()->sortByDesc("id");
        }
        if (!empty($msg)) {
            $posts = Post::all()->sortByDesc("id");
        }
        return view('posts.index', compact('posts', 'msg', 'types', 'categories', 'one_user'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $types = Type::get();
        $categories = Category::get();
        return view('posts.create', compact('types', 'categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        request()->validate([
            'tittle' => 'required',
            'text' => 'required',
            'type_id' => 'required',
            'category_id' => 'required',
            'user_id' => 'required',
            'picture' => 'image',
        ]);

        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $extension = $file->getClientOriginalExtension();
            $filename = "tbd";
        } else {
            $filename = "post.jpg";
        }
        $input = $request->all();
        $input['picture'] = $filename;
        $post = Post::create($input);
        $post_with_status_id = Post::find($post->id);
        if ($filename == "tbd") {
            $input['picture'] = "Post" . $post->id . "." . $extension;
            $request->file('picture')->storeAs('public', $input['picture']);
            $post_with_status_id->update(array('picture' => $input['picture']));
        }
        return redirect()->route('posts.index')
                        ->with('success', 'Se creo la publicación.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, Post $post) {
        $msg = '';
        if (!empty($request['text'])) {
            $input = $request->all();
            $comment = Comment::create($input);
            if($post->type_id == 2){
            $post->update(array('status_id' => 2));
            }
        }
        $comments = Comment::where('post_id', $post->id)->paginate();
        return view('posts.show', compact('post', 'comments'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post) {
        $types = Type::get();
        $categories = Category::get();
        $statuses = Status::get();
        return view('posts.edit', compact('post', 'types', 'categories', 'statuses'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $post) {
        request()->validate([
            'tittle' => 'required',
            'text' => 'required',
            'type_id' => 'required',
            'category_id' => 'required',
            'status_id' => 'required',
            'picture' => 'image',
        ]);
        $input = $request->all();
        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $extension = $file->getClientOriginalExtension();
            $filename = "Post" . $post->id . "." . $extension;
            $request->file('picture')->storeAs('public', $filename);
            $input['picture'] = $filename;
        }
        $post->update($input);
        return redirect()->route('posts.show', $post->id)
                        ->with('success', 'Post updated successfully');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post) {
        $picture = $post->_picture;
        if ($picture != "post.jpg") {
            unlink(storage_path('app/public/' . $picture));
        }
        $post->delete();

        return redirect()->route('posts.index')
                        ->with('success', 'Post deleted successfully');
    }

    public function user_posts(Request $request) {
        $msg = '';
        $one_user = true;
        $types = Type::get();
        $categories = Category::get();
        if (!empty($request['type_id']) && !empty($request['category_id'])) {
            $posts = Post::where('type_id', $request['type_id'])->where('category_id', $request['category_id'])->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate();
            if (!$posts[0]) {
                $msg = "No hay ninguna publicación que comparte ese tipo y categoría";
            }
        } else if (!empty($request['type_id'])) {
            $posts = Post::where('type_id', $request['type_id'])->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate();
            if (!$posts[0]) {
                $msg = "No hay ninguna publicación de este tipo";
            }
        } else if (!empty($request['category_id'])) {
            $posts = Post::where('category_id', $request['category_id'])->where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate();
            if (!$posts[0]) {
                $msg = "No hay ninguna publicación de esta categoría";
            }
        } else {
            $posts = Post::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate();
        }
        if (!empty($msg)) {
            $posts = Post::where('user_id', Auth::user()->id)->orderBy('id', 'desc')->paginate();
        }
        return view('posts.index', compact('posts', 'msg', 'types', 'categories', 'one_user'));
    }

}
