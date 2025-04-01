<!-- resources/views/admin/uploads/create.blade.php -->

@extends('layouts.app')

@section('content')
    <div class="container">
        <h1>Upload File</h1>

        <form action="{{ route('admin.uploads.store') }}" method="POST" enctype="multipart/form-data">
            @csrf
            <div class="mb-3">
                <label for="file" class="form-label">Choose File</label>
                <input type="file" class="form-control" id="file" name="file" required>
            </div>
            <button type="submit" class="btn btn-success">Upload</button>
        </form>
    </div>
@endsection
