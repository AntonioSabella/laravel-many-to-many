@extends('layouts.admin')

@section('content')

<h2 class="py-4">Create a new Post</h2>
@include('partials.errors')
<form action="{{route('admin.posts.store')}}" method="post" enctype="multipart/form-data">
    @csrf
    <div class="mb-4">
        <label for="title">Titolo</label>
        <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Inserisci titolo" aria-describedby="titleHelper" value="{{old('title')}}">
        <small id="titleHelper" class="text-muted">Inserisci il titolo del post, max: 150 carachters</small>
    </div>
    <div class="mb-4">
        <label for="cover_image">Immagine</label>
        <input type="file" name="cover_image" id="cover_image" class="form-control  @error('cover_image') is-invalid @enderror" placeholder="Inserisci immagine" aria-describedby="cover_imageHelper">
        <small id="cover_imageHelper" class="text-muted">Inserisci l'immagine del post</small>
    </div>
    <div class="mb-4">
        <label for="category_id">Categories</label>
        <select class="form-control" name="category_id" id="category_id">
            <option value="" disabled>Select a category</option>
            @foreach($categories as $category)
            <option value="{{$category->id}}">{{$category->name}}</option>
            @endforeach

        </select>
    </div>
    <div class="mb-4">
      <label for="tags" class="form-label">Tags</label>
      <select multiple class="form-select" name="tags[]" id="tags" aria-label="tags">
        <option value= "" disabled>Select a Tag</option>
        @forelse ($tags as $tag)
        <option value="{{$tag->id}}">{{$tag->name}}</option>
        @empty
        <option value="">No tags</option>

        @endforelse
   
      </select>
    </div>
    <div class="mb-4">
        <label for="content">Corpo</label>
        <textarea class="form-control  @error('content') is-invalid @enderror" name="content" id="content" rows="4">
        {{old('content')}}
        </textarea>
    </div>

    <button type="submit" class="btn btn-primary">Aggiungi Post</button>

</form>

@endsection