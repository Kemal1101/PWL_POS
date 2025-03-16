@extends('layout.app')

{{-- Customize layout sections --}}
@section('subtitle', 'Kategori')
@section('content_header_title', 'Home')
@section('content_header_subtitle', 'Kategori')

@include('kategori.modal_hapus')

@section('content')
<div class="container">
    <div class="card">
        <div class="card-header d-flex justify-content-between align-items-center">
            <span>Manage Kategori</span>
        </div>
        <div class="card-body">
            {{ $dataTable->table() }}
            <a href="{{ route('kategori.create') }}" class="btn btn-primary">
                + Add Kategori
            </a>
        </div>
    </div>
</div>
@endsection

@push('scripts')
    {{ $dataTable->scripts() }}
    <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
    <script>
        $(document).ready(function() {
            $(document).on('click', '.btn-delete', function() {
                var kategoriId = $(this).data('id');
                var actionUrl = "{{ route('kategori.hapus', ':id') }}".replace(':id', kategoriId);
                $('#formHapus').attr('action', actionUrl);
            });
        });
    </script>
@endpush

