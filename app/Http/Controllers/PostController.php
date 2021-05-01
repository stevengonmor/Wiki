<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\Auth;
use App\Models\Post;
use App\Models\Category;
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
    public function index() {
        $posts = Post::where('user_id', Auth::user()->id)->paginate();
        return view('posts.index', compact('posts'))
                        ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create() {
        $categories = Category::get();
        return view('posts.create', compact('categories'));
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
            'category_id' => 'required',
            'user_id' => 'required',
        ]);

        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $extension = $file->getClientOriginalExtension();
            $allowed = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array(strtolower($extension), $allowed)) {
                $filename = "tbd";
            } else {
                $filename = "blog.jpg";
                $msg = "No se guardó la foto, formato inválido.";
            }
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
            $request->file('picture')->storeAs('public', $input['picture']);
        }
        return redirect()->route('posts.index')
                        ->with('success', 'Post created successfully.');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post) {
        return view('posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post) {
        return view('posts.edit', compact('post'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Post $id) {
        request()->validate([
            'tittle' => 'required',
            'text' => 'required',
        ]);

        if ($request->hasFile('picture')) {
            $file = $request->file('picture');
            $extension = $file->getClientOriginalExtension();
            $allowed = array('jpg', 'png', 'jpeg', 'gif');
            if (in_array(strtolower($extension), $allowed)) {
                $filename = "Post" . $id + 1 . "." . $extension;
                $request->file('picture')->storeAs('public', $filename);
            } else {
                $filename = "blog.jpg";
                $msg = "No se guardó la foto, formato inválido.";
            }
        } else {
            $filename = "blog.jpg";
        }
        $request['profile_picture'] = $filename;
        $post = Post::find($id);
        $post->update($request->all());

        return redirect()->route('posts.index')
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

}
