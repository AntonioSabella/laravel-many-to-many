@extends('layouts.admin')


@section('content')

<div class="posts d-flex py-4">
    <img class="img-fluid" src="{{$post->cover_image}}" alt="{{$post->title}}">

    <div class="post-content px-4">
        <h1>{{$post->title}}</h1>
        <div class="metadata">
           <strong>Category</strong>: {{$post->category ? $post->category->name : 'Uncategorized'}}
        </div>
        <div class="content">
            {{$post->content}}
        </div>
    </div>
</div>


@endsection