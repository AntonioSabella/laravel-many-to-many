@extends('layouts.admin')


@section('content')


@include('partials.session_message')
@include('partials.errors')

<div class="container">
    <h1 class="my-3">Tags</h1>
    <div class="row">
        <div class="col pe-5">
            <form action="" method="post" class="d-flex align-items-center">
                @csrf
                <div class="input-group mb-3">
                    <input type="text" name="name" class="form-control" placeholder="Inserisci nuovo tag" aria-label="Recipient's username" aria-describedby="button-addon2">
                    <button class="btn btn-outline-secondary" type="submit" id="button-addon2">Add</button>
                </div>
            </form>
        </div>
        <div class="col">

            <table class="table table-striped table-inverse table-responsive">
                <thead class="thead-inverse">
                    <tr>
                        <th>Id</th>
                        <th>Name</th>
                        <th>Slug</th>
                        <th>Posts Number</th>
                        <th>Actions</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse($tagz as $tag)
                    <tr>
                        <td scope="row">{{$tag->id}}</td>
                        <td>
                            <form id="tag-{{$tag->id}}" action="{{route('admin.tags.update', $tag->slug)}}" method="post">
                                @csrf
                                @method('PATCH')
                                <input class="border-0 bg-transparent" type="text" name="name" value="{{$tag->name}}">
                            </form>

                        </td>
                        <td>{{$tag->slug}}</td>
                        <td><span class="badge badge-info bg-dark">{{count($tag->posts)}}</span></td>
                        <td>
                            <button form="tag-{{$tag->id}}" type="submit" class="btn btn-primary">
                            <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-pencil-fill" viewBox="0 0 16 16">
                                <path d="M12.854.146a.5.5 0 0 0-.707 0L10.5 1.793 14.207 5.5l1.647-1.646a.5.5 0 0 0 0-.708l-3-3zm.646 6.061L9.793 2.5 3.293 9H3.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.5h.5a.5.5 0 0 1 .5.5v.207l6.5-6.5zm-7.468 7.468A.5.5 0 0 1 6 13.5V13h-.5a.5.5 0 0 1-.5-.5V12h-.5a.5.5 0 0 1-.5-.5V11h-.5a.5.5 0 0 1-.5-.5V10h-.5a.499.499 0 0 1-.175-.032l-.179.178a.5.5 0 0 0-.11.168l-2 5a.5.5 0 0 0 .65.65l5-2a.5.5 0 0 0 .168-.11l.178-.178z"/>
                            </svg>
                            </button>
                            <form action="{{route('admin.tags.destroy', $tag->slug)}}" method="post">
                                @csrf
                                @method('DELETE')
                                <button type="submit" class="btn btn-danger text-white">
                                <svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-trash3-fill" viewBox="0 0 16 16">
                                    <path d="M11 1.5v1h3.5a.5.5 0 0 1 0 1h-.538l-.853 10.66A2 2 0 0 1 11.115 16h-6.23a2 2 0 0 1-1.994-1.84L2.038 3.5H1.5a.5.5 0 0 1 0-1H5v-1A1.5 1.5 0 0 1 6.5 0h3A1.5 1.5 0 0 1 11 1.5Zm-5 0v1h4v-1a.5.5 0 0 0-.5-.5h-3a.5.5 0 0 0-.5.5ZM4.5 5.029l.5 8.5a.5.5 0 1 0 .998-.06l-.5-8.5a.5.5 0 1 0-.998.06Zm6.53-.528a.5.5 0 0 0-.528.47l-.5 8.5a.5.5 0 0 0 .998.058l.5-8.5a.5.5 0 0 0-.47-.528ZM8 4.5a.5.5 0 0 0-.5.5v8.5a.5.5 0 0 0 1 0V5a.5.5 0 0 0-.5-.5Z"/>
                                </svg>
                                </button>
                            </form>

                        </td>
                    </tr>
                    @empty
                    <tr>
                        <td scope="row">Non ci sono tag...aggiungi il tuo primo tag</td>

                    </tr>
                    @endforelse
                </tbody>
            </table>


        </div>

    </div>
</div>


@endsection