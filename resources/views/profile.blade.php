@extends('layout.app')

@section('content')
<div class="container mt-5">
    <div class="card shadow-sm p-4">
        <div class="row align-items-center">
            {{-- Foto profil + icon edit --}}
            <div class="col-md-3 text-center">
                <div class="position-relative d-inline-block">
                    <img src="{{ asset('usersphoto/' . $user->username . '.png') . '?' . time() }}" alt="Foto Profil"
                        class="img-fluid rounded-circle shadow" style="width: 150px; height: 150px; object-fit: cover;">

                    {{-- Form upload tersembunyi --}}
                    <form id="photoForm" action="{{ route('profile.uploadPhoto') }}" method="POST" enctype="multipart/form-data">
                        @csrf
                        <input type="file" name="photo" id="photoInput" accept="image/*" class="d-none" onchange="document.getElementById('photoForm').submit();">
                    </form>

                    {{-- Icon pensil --}}
                    <label for="photoInput" class="position-absolute"
                        style="bottom: 0; right: 0; background: #007bff; border-radius: 50%; padding: 6px; cursor: pointer;">
                        <i class="fas fa-pencil-alt text-white" style="font-size: 14px;"></i>
                    </label>
                </div>
            </div>

            {{-- Detail profil --}}
            <div class="col-md-9">
                <h3 class="mb-3">{{ $user->nama }}</h3>
                <p><strong>Username:</strong> {{ $user->username ?? 'Belum diatur' }}</p>
                <p><strong>Level:</strong> {{ $user->level->level_nama ?? 'Belum diatur' }}</p>
            </div>
        </div>
    </div>
</div>
@endsection
