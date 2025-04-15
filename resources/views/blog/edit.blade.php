@extends('layouts.layout')

@section('content')
    <h2 class="mb-4">✏️ Edit Blog Post</h2>

    @if ($errors->any())
        <div class="alert alert-danger rounded-3 shadow-sm">
            <ul class="mb-0">
                @foreach ($errors->all() as $error)
                    <li>⚠️ {{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <div class="card p-4 mb-4 shadow-sm">
        <form action="{{ route('blog.update', $post->id) }}" method="POST" enctype="multipart/form-data">
            @csrf

            <div class="mb-3">
                <label class="form-label">Title:</label>
                <input type="text" name="title" class="form-control" value="{{ $post->title }}" required>
            </div>

            <div class="mb-3">
                <label class="form-label">Content:</label>
                <textarea name="content" class="form-control" rows="5" required>{{ $post->content }}</textarea>
            </div>

            <div class="mb-3">
                <label for="category_id" class="form-label">Category:</label>
                <select name="category_id" class="form-select" required>
                    <option value="">-- Select Category --</option>
                    @foreach($categories as $category)
                        <option value="{{ $category->id }}" {{ $category->id == $post->category_id ? 'selected' : '' }}>
                            {{ $category->name }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-3">
                <label for="image" class="form-label">Post Thumbnail:</label>
                <input type="file" name="image" class="form-control">
                @if($post->image)
                    <div class="mt-2">
                        <img src="{{ asset('storage/' . $post->image) }}" class="img-thumbnail" style="max-height: 200px; object-fit: cover;">
                        <p class="text-muted mt-1">Current image</p>
                    </div>
                @endif
            </div>

            <div class="d-flex justify-content-between">
                <button class="btn btn-success">✅ Update Post</button>
                <a href="{{ $previousUrl ?? route('home') }}" class="btn btn-outline-secondary">🔙 Back</a>
            </div>
        </form>
    </div>
@endsection
