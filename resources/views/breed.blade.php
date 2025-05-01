@extends('layouts.app')

@section('content')
<section>
    <div class="container py-5">
        <div class="row d-flex justify-content-center">
            <div class="col-md-10 col-lg-8 col-xl-8">
                <div class="card rounded-3" style="border: 1px solid #4e73df; box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);">
                    <div class="card-body mx-1 my-2">
                        <div class="text-center mb-4">
                            <h3>Thư viện giống chó và mèo</h3>
                        </div>

                        <div class="row row-cols-1 row-cols-md-5 g-4">
                            @forelse ($breeds as $breed)
                                <div class="col">
                                    <div class="card h-100 breed-card" style="cursor: pointer;" data-bs-toggle="modal" data-bs-target="#breedModal{{ $breed->id }}">
                                        @if ($breed->image)
                                            <img src="{{ asset('storage/' . $breed->image) }}" class="card-img-top" alt="{{ $breed->name }}" style="width: 100%; aspect-ratio: 2/2; object-fit: cover;">
                                        @else
                                            <div class="card-img-top bg-secondary text-white d-flex align-items-center justify-content-center" style="width: 100%; aspect-ratio: 2/2;">
                                                Không có ảnh
                                            </div>
                                        @endif
                                        <div class="card-body" style="padding: 0.5rem;">
                                            <h5 class="card-title text-center" style="font-size: 1rem;">{{ $breed->name }}</h5>
                                        </div>
                                    </div>
                                </div>

                                <!-- Modal cho giống -->
                                <div class="modal fade" id="breedModal{{ $breed->id }}" tabindex="-1" aria-labelledby="breedModalLabel{{ $breed->id }}" aria-hidden="true">
                                    <div class="modal-dialog modal-dialog-centered">
                                        <div class="modal-content">
                                            <div class="modal-header">
                                                <h5 class="modal-title" id="breedModalLabel{{ $breed->id }}">{{ $breed->name }}</h5>
                                                <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                                            </div>
                                            <div class="modal-body">
                                                @if ($breed->image)
                                                    <img src="{{ asset('storage/' . $breed->image) }}" class="img-fluid mb-3" alt="{{ $breed->name }}" style="width: 100%; max-height: 450px; aspect-ratio: 2/3; object-fit: cover;">
                                                @else
                                                    <p class="text-center">Không có ảnh</p>
                                                @endif
                                                <p><strong>Loại:</strong> {{ $breed->type == 'dog' ? 'Chó' : 'Mèo' }}</p>
                                                <p><strong>Thông tin:</strong> {{ $breed->description ?? 'Không có thông tin' }}</p>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @empty
                                <div class="col-12 text-center">
                                    <p>Chưa có giống nào trong thư viện.</p>
                                </div>
                            @endforelse
                        </div>

                        <div class="d-flex justify-content-between align-items-center mt-4">
                            <a href="{{ url('/') }}" class="text-muted">Trở về</a>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<style>
    .breed-card {
        transition: transform 0.3s ease, box-shadow 0.3s ease;
    }
    .breed-card:hover {
        transform: translateY(-5px);
        box-shadow: 0 0.5rem 1rem rgba(0, 0, 0, 0.15);
    }
</style>
@endsection