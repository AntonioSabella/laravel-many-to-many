<?php

namespace App\Http\Controllers\Admin;

use App\Models\Post;
use App\Http\Controllers\Controller;
use App\Http\Requests\PostRequest;
use App\Models\Category;
use App\Models\Tag;
use Illuminate\Support\Facades\Storage;
use App\Mail\NewPostCreated;
use Illuminate\Support\Facades\Mail;



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
        //ddd($request->all());

        // Validazione dati
        $val_data = $request->validated();
        // Generazione dello slug
        $slug = Post::generateSlug($request->title);
        $val_data['slug'] = $slug;
     /* $val_data['category_id'] = $request->category_id;
        dd($val_data); */

        //Verificare che la richiesta contiene il file
        //ddd($request->hasfile('cover_image'));

        if ($request->hasfile('cover_image')) {
            //validazione del file
            $request->validate([
                'cover_image' => 'nullable|image|max:500',
            ]);
            // salvataggio nel file system e recupero percorso
            //ddd($reuqest->all());
            $path = Storage::put('post_images', $request->cover_image);
            //ddd($path);
            // trasmettere il percorso all'array per il salvataggio della risorsa
            $val_data['cover_image'] = $path;
        }
        
        //ddd($val_data);

        // Creazione della risorsa
        $new_post = Post::create($val_data);
        $new_post->tags()->attach($request->tags);
        
        //Metodo per mostrare la view della mail
        //return(new NewPostCreated($new_post))->render();

        //Invio della mail di prova mediante mailTrap
        Mail::to('test@example.com')->send(new NewPostCreated($new_post));

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

        if ($request->hasfile('cover_image')) {
            //validazione del file
            $request->validate([
                'cover_image' => 'nullable|image|max:500',
            ]);
            //cancellazione immagine precedente
            Storage::delete($post->cover_image);
            // salvataggio nel file system e recupero percorso
            //ddd($reuqest->all());
            $path = Storage::put('post_images', $request->cover_image);
            //ddd($path);
            // trasmettere il percorso all'array per il salvataggio della risorsa
            $val_data['cover_image'] = $path;
        }
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
        Storage::delete($post->cover_image);
        $post->delete();
        return redirect()->route('admin.posts.index')->with('message', "$post->title deleted successfully");

    }
}
