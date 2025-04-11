@extends('layouts.layout')

@section('content')
    <div class="d-flex justify-content-between align-items-center mb-4">
        <h2 class="text-primary">📰 Latest Blog Posts</h2>
        <a href="{{ route('blog.create') }}" class="btn btn-success">+ Create New Post</a>
    </div>

    {{-- Filters --}}
    <form method="GET" action="{{ route('home') }}" class="mb-4 row g-2 align-items-center">
        <div class="col-md-4">
            <select name="category" class="form-select shadow-sm">
                <option value="">-- All Categories --</option>
                @foreach($categories as $cat)
                    <option value="{{ $cat->id }}" {{ request('category') == $cat->id ? 'selected' : '' }}>
                        {{ $cat->name }}
                    </option>
                @endforeach
            </select>
        </div>
        <div class="col-md-4">
            <input type="text" name="search" class="form-control shadow-sm" placeholder="Search blog by name or content..."
                value="{{ request('search') }}">
        </div>
        <div class="col-md-4">
            <button type="submit" class="btn btn-outline-primary w-100 shadow-sm">🔍 Apply Filters</button>
        </div>
    </form>

    {{-- Success Message --}}
    @if (session('success'))
        <div class="alert alert-success">{{ session('success') }}</div>
    @endif

    {{-- Blog Cards --}}
    <div class="row">
        @forelse($posts as $post)
            <div class="col-md-6 mb-4">
                <div class="card shadow-sm border-0 rounded-4 overflow-hidden h-100">
                    @if($post->image)
                        <img src="{{ asset('storage/' . $post->image) }}" class="w-100"
                            style="aspect-ratio: 16/9; object-fit: cover;">
                    @endif

                    <div class="card-body p-4 d-flex flex-column">
                        <div>
                            @php
                                $badgeColors = ['bg-primary', 'bg-success', 'bg-warning', 'bg-info', 'bg-danger'];
                                $colorClass = $badgeColors[$post->category->id % count($badgeColors)];
                            @endphp
                            <span class="badge {{ $colorClass }} mb-2">{{ $post->category->name ?? 'Uncategorized' }}</span>
                        </div>
                        <h4 class="card-title text-dark fw-bold mb-2">{{ $post->title }}</h4>

                        <div class="text-muted small mb-2">
                            ✍️ <strong>{{ $post->user->name ?? 'Unknown' }}</strong> |
                            🕒 {{ $post->created_at->format('d M Y') }}
                        </div>

                        <p class="text-secondary mb-3">
                            {{ \Illuminate\Support\Str::limit($post->content, 160) }}
                        </p>

                        <div class="mt-auto">
                            <div class="text-muted small mb-3">
                                <span class="me-3">❤️ {{ $post->likes_count ?? 0 }} Likes</span>
                                <span>💬 {{ $post->comments_count ?? 0 }} Comments</span>
                            </div>

                            <a href="{{ route('blog.show', $post->id) }}" class="btn btn-outline-info btn-sm">👁️ Read
                                More</a>
                        </div>
                    </div>
                </div>
            </div>
        @empty
            <div class="alert alert-info">No blog posts found. Start by creating one!</div>
        @endforelse
    </div>

    {{-- Pagination --}}
    <div class="d-flex justify-content-center mt-4">
        {{ $posts->withQueryString()->links() }}
    </div>
@endsection