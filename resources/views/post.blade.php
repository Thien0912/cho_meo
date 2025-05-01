@extends('layouts.app')

@section('content')

    <div class="container py-5">
        <h1 class="display-4 fw-bold text-center mb-5">Blogs</h1>

        @if($posts->isEmpty())
            <p class="text-muted text-center fs-4 fst-italic">Chưa có bài viết nào được đăng.</p>
        @else
            <div class="row row-cols-1 g-4">
                @foreach($posts as $post)
                    <div class="col">
                        <div class="card shadow-lg h-100 border-0">
                            <div class="card-body p-4">
                                <h2 class="card-title h3 fw-bold mb-3">{{ $post->title }}</h2>
                                <p class="card-text text-secondary">{{ $post->content }}</p>
                                <div class="d-flex align-items-center mt-3">
                                    @if(auth()->check())
                                        <button class="btn btn-outline-danger btn-sm like-btn" 
                                                data-post-id="{{ $post->id }}"
                                                data-liked="{{ $post->likedByUser(auth()->id()) ? 'true' : 'false' }}"
                                                type="button">
                                            <i class="bi bi-heart{{ $post->likedByUser(auth()->id()) ? '-fill' : '' }}"></i>
                                            <span class="like-count">{{ $post->likes }}</span>
                                        </button>
                                    @else
                                        <p class="text-muted small">Đăng nhập để thích bài viết.</p>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>
                @endforeach
            </div>
        @endif
    </div>

    @if(auth()->check())
        <script>
            document.querySelectorAll('.like-btn').forEach(button => {
                button.addEventListener('click', function() {
                    const postId = this.dataset.postId;
                    const isLiked = this.dataset.liked === 'true';
                    const heartIcon = this.querySelector('i');
                    const likeCount = this.querySelector('.like-count');

                    button.disabled = true;

                    // Sử dụng helper route() để tạo URL chính xác
                    const likeUrl = '{{ route("posts.like", ":postId") }}'.replace(':postId', postId);

                    fetch(likeUrl, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json'
                        }
                    })
                    .then(response => {
                        button.disabled = false;
                        if (!response.ok) {
                            throw new Error(`HTTP error! status: ${response.status}`);
                        }
                        return response.json();
                    })
                    .then(data => {
                        if (data.error) {
                            alert(data.error);
                            return;
                        }
                        likeCount.textContent = data.likes;
                        this.dataset.liked = data.liked;
                        heartIcon.classList.toggle('bi-heart', !data.liked);
                        heartIcon.classList.toggle('bi-heart-fill', data.liked);
                    })
                    .catch(error => {
                        button.disabled = false;
                        console.error('Error:', error);
                        alert('Có lỗi khi thích bài viết: ' + error.message);
                    });
                });
            });
        </script>
    @endif
@endsection