@extends('layouts.app')

@section('content')
<div class="container">
    <h1>Uploads</h1>
    <a href="{{ route('admin.uploads.create') }}" class="btn btn-success mb-3">Upload New File</a>
    <ul>
        @foreach ($uploads as $upload)
            <li>
                {{ $upload->file_path }}
                <form action="{{ route('admin.uploads.destroy', $upload->id) }}" method="POST" style="display:inline;">
                    @csrf
                    @method('DELETE')
                    <button type="submit" class="btn btn-danger btn-sm">Delete</button>
                </form>
            </li>
        @endforeach
    </ul>
</div>
@endsection
