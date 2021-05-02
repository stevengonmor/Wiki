<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Type;
use App\Models\Category;
use App\Models\Comment;
use Illuminate\Http\Request;

class PostController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    function __construct() {
        $this->middleware('permission:post-list|post-create|post-edit|post-delete', ['only' => ['index', 'show']]);
        $this->middleware('permission:post-create', ['only' => ['create', 'store']]);
        $this->middleware('permission:post-edit', ['only' => ['edit', 'update']]);
        $this->middleware('permission:post-delete', ['only' => ['destroy']]);
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
            $posts = Post::where('type_id', $request['type_id'])->where('category_id', $request['category_id'])->paginate();
            if (!$posts[0]) {
                $msg = "No hay ninguna publicación que comparte ese tipo y categoría";
            }
        } else if (!empty($request['type_id'])) {
            $posts = Post::where('type_id', $request['type_id'])->paginate();
            if (!$posts[0]) {
                $msg = "No hay ninguna publicación de este tipo";
            }
        } else if (!empty($request['category_id'])) {
            $posts = Post::where('category_id', $request['category_id'])->paginate();
            if (!$posts[0]) {
                $msg = "No hay ninguna publicación de esta categoría";
            }
        } else {
            $posts = Post::latest()->paginate();
        }
        if (!empty($msg)) {
            $posts = Post::latest()->paginate();
        }
        return view('posts.index', compact('posts', 'msg', 'types', 'categories', 'one_user'))
                        ->with('i', (request()->input('page', 1) - 1) * 5);
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
            $filename = "blog.jpg";
        }
        $input = $request->all();
        $input['picture'] = $filename;
        $post = Post::create($input);
        if ($filename == "tbd") {
            $input['picture'] = "Post" . $post->id . "." . $extension;
            $request->file('picture')->storeAs('public', $input['picture']);
            $post->update(array('picture' => $input['picture']));
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
        return view('posts.edit', compact('post', 'types', 'categories'));
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
            $posts = Post::where('type_id', $request['type_id'])->where('category_id', $request['category_id'])->where('user_id', Auth::user()->id)->paginate();
            if (!$posts[0]) {
                $msg = "No hay ninguna publicación que comparte ese tipo y categoría";
            }
        } else if (!empty($request['type_id'])) {
            $posts = Post::where('type_id', $request['type_id'])->where('user_id', Auth::user()->id)->paginate();
            if (!$posts[0]) {
                $msg = "No hay ninguna publicación de este tipo";
            }
        } else if (!empty($request['category_id'])) {
            $posts = Post::where('category_id', $request['category_id'])->where('user_id', Auth::user()->id)->paginate();
            if (!$posts[0]) {
                $msg = "No hay ninguna publicación de esta categoría";
            }
        } else {
            $posts = Post::where('user_id', Auth::user()->id)->paginate();
        }
        if (!empty($msg)) {
            $posts = Post::where('user_id', Auth::user()->id)->paginate();
        }
        return view('posts.index', compact('posts', 'msg', 'types', 'categories', 'one_user'))
                        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

}
