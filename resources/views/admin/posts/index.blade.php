@extends('layouts.admin')

@section('content')
<div class="container">
    <div class="d-flex justify-content-between py-4">
        <h1>Elenco dei post</h1>
        <div><a href="{{route('admin.posts.create')}}" class="btn btn-primary text-white">Add Post</a></div>
    </div>

    @if (session('message'))
    <div class="alert alert-success">
        {{ session('message') }}
    </div>
    @endif
    <table class="table table-striped table-inverse table-responsive">
        <thead class="thead-inverse">
            <tr>
                <th>Id</th>
                <th>Titolo</th>
                <th>Slug</th>
                <th>Category</th>
                <th>Tag</th>
                <th>Immagine</th>
                <th>Azioni</th>
            </tr>
        </thead>

        <tbody>
            @forelse($posts as $post)
            <tr>
                <td scope="row">{{$post->id}}</td>
                <td>{{$post->title}}</td>
                <td>{{$post->slug}}</td>
                <td>Category: {{ $post->category ? $post->category->name : 'Uncategorized'}}</td>
                <td>Tags: {{ $post->tag ? $post->tag->name : 'Untagged'}}</td>


                <td><img height="150" width='200' src="{{$post->cover_image}}" alt="Cover image {{$post->title}}"></td>
                <td class='d-flex gap-1'>
                    <a class="btn btn-primary text-white btn-sm" href="{{route('admin.posts.show', $post->slug)}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-eye-fill" viewBox="0 0 16 16">
                         <path d="M10.5 8a2.5 2.5 0 1 1-5 0 2.5 2.5 0 0 1 5 0z"/>
                         <path d="M0 8s3-5.5 8-5.5S16 8 16 8s-3 5.5-8 5.5S0 8 0 8zm8 3.5a3.5 3.5 0 1 0 0-7 3.5 3.5 0 0 0 0 7z"/>
                        </svg>
                    </a>
                    <a class="btn btn-success text-white btn-sm" href="{{route('admin.posts.edit', $post->slug)}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                            <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                        </svg>
                    </a>

                    <!-- Buttone per avviare la modale -->
                    <button type="button" class="btn btn-danger btn-sm text-white" data-bs-toggle="modal" data-bs-target="#delete-post-{{$post->id}}">
                        <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash-fill" viewBox="0 0 16 16">
                        <path d="M2.5 1a1 1 0 0 0-1 1v1a1 1 0 0 0 1 1H3v9a2 2 0 0 0 2 2h6a2 2 0 0 0 2-2V4h.5a1 1 0 0 0 1-1V2a1 1 0 0 0-1-1H10a1 1 0 0 0-1-1H7a1 1 0 0 0-1 1H2.5zm3 4a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 .5-.5zM8 5a.5.5 0 0 1 .5.5v7a.5.5 0 0 1-1 0v-7A.5.5 0 0 1 8 5zm3 .5v7a.5.5 0 0 1-1 0v-7a.5.5 0 0 1 1 0z"/>
                        </svg>
                    </button>

                    <!-- Modale -->
                    <div class="modal fade" id="delete-post-{{$post->id}}" tabindex="-1" role="dialog" aria-labelledby="modelTitle-{{$post->id}}" aria-hidden="true">
                        <div class="modal-dialog" role="document">
                            <div class="modal-content">
                                <div class="modal-header">
                                    <h5 class="modal-title">Cancella il post: "{{$post->title}}"</h5>
                                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                </div>
                                <div class="modal-body">
                                    Sei sicuro di voler cancellare questo post? <br> !Attenzione è un operazione distruttiva!
                                </div>
                                <div class="modal-footer">
                                    <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Annulla</button>


                                    <form action="{{route('admin.posts.destroy', $post->slug)}}" method="post">
                                        @csrf
                                        @method('DELETE')

                                        <button type="submit" class="btn btn-danger">Elimina</button>
                                    </form>

                                </div>
                            </div>
                        </div>
                    </div>
                </td>
            </tr>

            @empty
            <tr>
                <td scope="row">Crea il tuo primo post<a href="{{route('admin.posts.create')}}">Qui</a></td>
            </tr>
            @endforelse
        </tbody>
    </table>


</div>
@endsection