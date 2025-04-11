@extends('layouts.layout')

@section('content')
    <h2 class="mb-4 text-primary">🆕 Create New Blog Post</h2>

    @if ($errors->any())
        <div class="alert alert-danger rounded shadow-sm">
            <ul class="mb-0 ps-3">
                @foreach ($errors->all() as $error)
                    <li>{{ $error }}</li>
                @endforeach
            </ul>
        </div>
    @endif

    <form method="POST" action="{{ route('blog.store') }}" enctype="multipart/form-data" class="bg-light p-4 mb-4 border border-3 rounded shadow-sm">
        @csrf

        <div class="mb-3">
            <label class="form-label fw-semibold">📌 Title</label>
            <input type="text" name="title" class="form-control" placeholder="Enter blog title..." required>
        </div>

        <div class="mb-3">
            <label class="form-label fw-semibold">📝 Content</label>
            <textarea name="content" class="form-control" rows="5" placeholder="Write your content here..." required></textarea>
        </div>

        <div class="mb-3">
            <label for="category" class="form-label fw-semibold">📂 Category</label>
            <select name="category_id" class="form-select" required>
                <option value="">-- Select Category --</option>
                @foreach($categories as $category)
                    <option value="{{ $category->id }}">{{ $category->name }}</option>
                @endforeach
            </select>
        </div>

        <div class="mb-3">
            <label for="image" class="form-label fw-semibold">🖼️ Post Thumbnail</label>
            <input type="file" name="image" class="form-control">
        </div>

        <div class="d-flex justify-content-between align-items-center mt-4">
            <button type="submit" class="btn btn-success px-4">✅ Save</button>
            <a href="{{ route('home') }}" class="btn btn-outline-secondary px-4">🔙 Back</a>
        </div>
    </form>
@endsection
