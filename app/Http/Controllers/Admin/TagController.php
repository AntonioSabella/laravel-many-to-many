<?php

namespace App\Http\Controllers\Admin;

use App\Models\Tag;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Str;
use Illuminate\Validation\Rule;

class TagController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $tagz = Tag::orderByDesc('id')->get();
        return view('admin.tags.index', compact('tagz'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        // Not used
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //dd($request->all());

        // Validare
        $val_data = $request->validate([
            'name' => ['required','unique:tags']
        ]);
        // generate slug
        $slug = Str::slug($request->name);
        $val_data['slug'] = $slug;

        // salvare

        Tag::create($val_data);

        // redirect
        return redirect()->back()->with('message', "Tag $slug aggiunto con successo");
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function show(Tag $tag)
    {
        // Not used
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function edit(Tag $tag)
    {
        // Not used
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Tag  $tag
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Tag $tag)
    {
        //dd($request->all());

        $val_data = $request->validate([
            'name' => ['required', Rule::unique('tags')->ignore($tag)]
        ]);
        // generate slug
        $slug = Str::slug($request->name);
        $val_data['slug'] = $slug;

        $tag->update($val_data);
        return redirect()->back()->with('message', "Tag $slug modificata con successo");
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Tag $tag)
    {
        $tag->delete();
        return redirect()->back()->with('message', "Tag $tag->name rimosso con successo");
    }
}
