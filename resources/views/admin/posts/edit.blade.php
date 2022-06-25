@extends('layouts.admin')


@section('content')

<h2 class="py-4">Edit {{$post->title}}</h2>
@include('partials.errors')
    <form action="{{route('admin.posts.update', $post->slug)}}" method="post">
        @csrf
        @method('PUT')
        <div class="mb-4">
            <label for="title">Titolo</label>
            <input type="text" name="title" id="title" class="form-control @error('title') is-invalid @enderror" placeholder="Aggiorna titolo" aria-describedby="titleHelper" value="{{old('title', $post->title)}}">
            <small id="titleHelper" class="text-muted">Aggiorna il titolo del post, max: 150 carachters</small>
        </div>
        <div class="d-flex gap-2">
            <div class="media me-4">
                <img class="shadow" width="150" src="{{$post->cover_image}}" alt="{{$post->title}}">
            </div>
            <div class="mb-4">
                <label for="cover_image">Immagine</label>
                <input type="text" name="cover_image" id="cover_image" class="form-control  @error('cover_image') is-invalid @enderror" placeholder="Aggiorna immagine" aria-describedby="cover_imageHelper" value="{{old('cover_image', $post->cover_image)}}">
                <small id="cover_imageHelper" class="text-muted">Aggiorna immagine</small>
            </div>
            <div class="mb-4">
                <label for="category_id">Categories</label>
                <select class="form-control" name="category_id" id="category_id">
                    <option value="" disabled>Select a category</option>
                    @foreach($categories as $category)
                    <option value="{{$category->id}}" {{$category->id == old('category', $post->category_id) ? 'selected' : ''}}>{{$category->name}}</option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
              <label for="tags" class="form-label m-0">Tags</label>
              <select multiple class="form-select" name="tags[]" id="tags" aria-label="tags">
              <option value= "" disabled>Select a Tag</option>
              @forelse ($tags as $tag)
                @if($errors->any())
                    <option value="{{$tag->id}}" {{in_array($tag->id,old('tags')) ? 'selected' : ''}}>{{$tag->name}}</option>
                @else
                    <option value="{{$tag->id}}" {{$post->tags->contains($tag->id) ? 'selected' : ''}}>{{$tag->name}}</option>
                @endif
              @empty
                  <option value="">No tags</option>

              @endforelse
              </select>
            </div>
        </div>
        <div class="mb-4">
            <label for="content">Corpo</label>
            <textarea class="form-control  @error('content') is-invalid @enderror" name="content" id="content" rows="4">{{old('content', $post->content)}}</textarea>
        </div>

        <button type="submit" class="btn btn-primary">Modifica Post</button>

    </form>

@endsection