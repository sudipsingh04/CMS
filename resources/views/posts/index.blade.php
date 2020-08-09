@extends('layouts.app')

@section('content')
<div class="d-flex justify-content-end mb-2">
    <a href="{{ route('posts.create') }}" class="btn btn-success float-right">Add Post</a>
</div>

<div class="card card-default">
    <div class="card-header">Posts</div>
    <div class="card-body">
        <table class="table">
            <thead>
                <th>Image</th>
                <th>Title</th>
                <th colspan="2">Actions</th>
            </thead>
            <tbody>
                @foreach ($posts as $post)
                    <tr>
                        <td><img src="{{ asset('storage/'.$post->image) }}" width="60px" height="60px"></td>
                        <td>{{ $post->title }}</td>
                        <td>
                            <a href="" class="btn btn-info btn-sm">Edit</a>
                        </td>
                        <td>
                            <form action="{{ route('posts.destroy', $post->id) }}" method="POST">
                                @csrf
                                @method('delete')
                                <button type="submit" href="" class="btn btn-danger btn-sm">Trash</button>
                            </form>
                        </td>
                    </tr>
                @endforeach
            </tbody>
        </table>
    </div>
</div>
@endsection