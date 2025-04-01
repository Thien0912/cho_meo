@extends('layouts.app')

@section('content')
<div class="container">
    <h1>{{ $page->title }}</h1>
    <p>{{ $page->content }}</p>
    <a href="{{ route('admin.pages.index') }}" class="btn btn-secondary">Back</a>
</div>
@endsection
