@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Pages</h1>
    <a href="{{ route('admin.pages.create') }}" class="btn btn-success mb-3">Create New Page</a>
    
    <table class="table">
        <thead>
            <tr>
                <th>#</th>
                <th>Title</th>
                <th>Created At</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            @foreach ($pages as $page)
                <tr>
                    <td>{{ $page->id }}</td>
                    <td>{{ $page->title }}</td>
                    <td>{{ $page->created_at->format('Y-m-d H:i:s') }}</td>
                    <td>
                        <a href="{{ route('admin.pages.show', $page->id) }}" class="btn btn-info btn-sm">Show</a>
                        <a href="{{ route('admin.pages.edit', $page->id) }}" class="btn btn-warning btn-sm">Edit</a>
                        <form action="{{ route('admin.pages.destroy', $page->id) }}" method="POST" style="display:inline;">
                            @csrf
                            @method('DELETE')
                            <button type="submit" class="btn btn-danger btn-sm"
                                onclick="return confirm('Are you sure you want to delete this page?')">
                                Delete
                            </button>
                        </form>
                    </td>
                </tr>
            @endforeach
        </tbody>
    </table>
</div>
@endsection
