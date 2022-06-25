<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Tag;



class PostController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $posts = Post::orderByDesc('id')->get();
        //dd($posts);
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.index', compact('posts','categories','tags'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.create', compact('categories','tags'));
        
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest $request
     * @return \Illuminate\Http\Response
     */
    public function store(PostRequest $request)
    {
        //dd($request->all());

        // Validazione dati
        $val_data = $request->validated();
        // Generazione dello slug
        $slug = Post::generateSlug($request->title);
        $val_data['slug'] = $slug;
/*         $val_data['category_id'] = $request->category_id;
        dd($val_data); */


        // Creazione della risorsa
        $new_post = Post::create($val_data);
        $new_post->tags()->attach($request->tags);

        // Redirezionamento all'index admin
        return redirect()->route('admin.posts.index')->with('message', 'Post Created Successfully');
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function show(Post $post)
    {
        return view('admin.posts.show', compact('post'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function edit(Post $post)
    {
        $categories = Category::all();
        $tags = Tag::all();
        return view('admin.posts.edit', compact('post', 'categories', 'tags'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \App\Http\Requests\PostRequest  $request
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function update(PostRequest $request, Post $post)
    {
        //dd($request->all());

        // Validazione dati
        $val_data = $request->validated();
        //dd($val_data);
        // Generazione dello slug
        $slug = Post::generateSlug($request->title);
        //dd($slug);
        $val_data['slug'] = $slug;
        // Update della risorsa editata
        $post->update($val_data);
        // Sincronizziamo i tags
        $post->tags()->sync($request->tags);

        // Redirezionamento all'index admin
        return redirect()->route('admin.posts.index')->with('message', "$post->title updated successfully");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Post  $post
     * @return \Illuminate\Http\Response
     */
    public function destroy(Post $post)
    {
        // Cancellazione della risorsa
        $post->delete();
        return redirect()->route('admin.posts.index')->with('message', "$post->title deleted successfully");

    }
}
