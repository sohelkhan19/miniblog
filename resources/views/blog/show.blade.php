@extends('layouts.layout')

@section('content')
    <div class="container px-3 px-md-5">
        {{-- Blog Post Card --}}
        <div class="card shadow-sm border-0 rounded-4 mb-5 overflow-hidden">
            @if($post->image)
                <img src="{{ asset('storage/' . $post->image) }}"
                     alt="Post Image"
                     class="w-100" style="aspect-ratio: 16/9; object-fit: cover;">
            @endif

            <div class="card-body p-4">
                <div class="d-flex justify-content-between flex-wrap align-items-center mb-2">
                    <span class="badge bg-info">{{ $post->category->name ?? 'Uncategorized' }}</span>
                    <small class="text-muted">
                        Posted on {{ $post->created_at->format('d M Y, h:i A') }}
                    </small>
                </div>

                <h2 class="fw-bold text-dark">{{ $post->title }}</h2>

                <p class="text-muted mb-3">
                    ✍️ By <strong>{{ $post->user->name ?? 'Unknown' }}</strong>
                </p>

                <div class="text-secondary fs-6" style="white-space: pre-line;">
                    {!! nl2br(e($post->content)) !!}
                </div>
            </div>

            {{-- Like Button --}}
            <div class="px-4 pb-4">
                @auth
                    <form action="{{ route('blog.toggleLike', $post->id) }}" method="POST">
                        @csrf
                        @if($post->isLikedBy(auth()->user()))
                            <button type="submit" class="btn btn-danger">❤️ Unlike ({{ $post->likes->count() }})</button>
                        @else
                            <button type="submit" class="btn btn-outline-danger">🤍 Like ({{ $post->likes->count() }})</button>
                        @endif
                    </form>
                @else
                    <p class="text-muted">Please <a href="{{ route('login') }}">login</a> to like this post.</p>
                @endauth
            </div>
        </div>

        {{-- Comments Section --}}
        <div class="card shadow-sm border-0 rounded-4 mb-5">
            <div class="card-body p-4">
                <h4 class="mb-3">💬 Comments ({{ $post->comments->count() }})</h4>

                <div id="comment-section">
                    @forelse($post->comments->take(5) as $comment)
                        <div class="border rounded p-3 mb-3">
                            <div class="d-flex justify-content-between small">
                                <strong>{{ $comment->user->name }}</strong>
                                <span class="text-muted">{{ $comment->created_at->format('d M Y h:i A') }}</span>
                            </div>
                            <p class="mb-0 mt-1">{{ $comment->content }}</p>
                        </div>
                    @empty
                        <p class="text-muted">No comments yet. Be the first to comment!</p>
                    @endforelse

                    @if($post->comments->count() > 5)
                        <button class="btn btn-link p-0 mt-2" id="viewAllBtn">👀 View All Comments</button>
                        <div id="all-comments" style="display: none;">
                            @foreach($post->comments->skip(5) as $comment)
                                <div class="border rounded p-3 mb-3">
                                    <div class="d-flex justify-content-between small">
                                        <strong>{{ $comment->user->name }}</strong>
                                        <span class="text-muted">{{ $comment->created_at->format('d M Y h:i A') }}</span>
                                    </div>
                                    <p class="mb-0 mt-1">{{ $comment->content }}</p>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>

                {{-- Add New Comment --}}
                @auth
                    <form method="POST" action="{{ route('comments.store', $post->id) }}" class="mt-4">
                        @csrf
                        <div class="mb-3">
                            <label for="content">Leave a Comment:</label>
                            <textarea name="content" class="form-control" rows="3" required></textarea>
                        </div>
                        <button class="btn btn-primary">Submit Comment</button>
                    </form>
                @else
                    <p class="text-muted mt-3">Please <a href="{{ route('login') }}">login</a> to leave a comment.</p>
                @endauth
            </div>
        </div>

        <div class="text-center">
            <a href="{{ $backUrl }}" class="btn btn-outline-secondary mb-3">← Back to Blog</a>
        </div>
    </div>

    {{-- View All Toggle Script --}}
    <script>
        document.getElementById('viewAllBtn')?.addEventListener('click', function () {
            document.getElementById('all-comments').style.display = 'block';
            this.style.display = 'none';
        });
    </script>
@endsection
