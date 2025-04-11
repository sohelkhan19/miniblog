@extends('layouts.layout')

@section('content')
    <div class="container px-2 px-md-4">
        <h2 class="mb-4">📝 My Blog Posts</h2>

        {{-- Success Message --}}
        @if (session('success'))
            <div class="alert alert-success">{{ session('success') }}</div>
        @endif

        <div class="row g-4">
            @forelse ($posts as $post)
                    <div class="col-md-6">
                        <div class="card h-100 shadow-sm border-0 rounded-4 overflow-hidden">
                            @if($post->image)
                                <img src="{{ asset('storage/' . $post->image) }}" alt="Post Image" class="card-img-top"
                                    style="aspect-ratio: 16/9; object-fit: cover;">
                            @endif

                            <div class="card-body d-flex flex-column">
                                <div>
                                    @php
                                        $badgeColors = ['bg-primary', 'bg-success', 'bg-warning', 'bg-info', 'bg-danger'];
                                        $colorClass = $badgeColors[$post->category->id % count($badgeColors)];
                                    @endphp
                                    <span class="badge {{ $colorClass }} mb-2">{{ $post->category->name ?? 'Uncategorized' }}</span>
                                    <small class="text-muted float-end">{{ $post->created_at->format('d M Y') }}</small>
                                </div>

                                <h5 class="card-title fw-semibold text-dark">{{ $post->title }}</h5>

                                <p class="card-text text-muted flex-grow-1">
                                    {{ \Illuminate\Support\Str::limit(strip_tags($post->content), 120) }}
                                </p>

                                <div class="d-flex justify-content-start align-items-center mt-2 mb-3 text-muted">
                                    <div class="me-3">
                                        ❤️ {{ $post->likes->count() }} Likes
                                    </div>
                                    <div>
                                        💬 {{ $post->comments->count() }} Comments
                                    </div>
                                </div>

                                <div class="d-flex justify-content-between mt-auto">
                                    <div class="btn-group">
                                        <a href="{{ route('blog.show', ['id' => $post->id, 'back_url' => route('blog.myPosts')]) }}"
                                            class="btn btn-sm btn-outline-info">👁️ View</a>
                                        <a href="{{ route('blog.edit', $post->id) }}" class="btn btn-sm btn-outline-warning">✏️
                                            Edit</a>
                                        <a href="{{ route('blog.delete', $post->id) }}" class="btn btn-sm btn-outline-danger"
                                            onclick="return confirm('Are you sure you want to delete this post?')">🗑️ Delete</a>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
            @empty
                <p class="text-muted">You haven't posted any blogs yet.</p>
            @endforelse
        </div>

        <div class="d-flex justify-content-center mt-4">
            {{ $posts->links() }}
        </div>
    </div>
@endsection