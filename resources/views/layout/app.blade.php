@extends('adminlte::page')

{{-- Extend and customize the browser title --}}

@section('title')
    {{ config('adminlte.title') }}
    @hasSection('subtitle') | @yield('subtitle') @endif
@stop

@vite('resources/js/app.js')

{{-- Extend and customize the page content header --}}

@section('content_header')
    @hasSection('content_header_title')
        <h1 class="text-muted">
            @yield('content_header_title')

            @hasSection('content_header_subtitle')
            <small class="text-dark">
                <i class="fas fa-xs fa-angle-right text-muted"></i>
                @yield('content_header_subtitle')
            </small>
        @endif
    </h1>
@endif
@stop

{{-- Rename section content to content_body --}}

@section('content')
@yield('content_body')
@stop


{{-- Create a common footer --}}

@section('footer')
<div class="float-right">
    Version: {{ config('app.version', '1.0.0') }}
</div>

<strong>
    <a href="{{ config('app.company_url', '#') }}">
        {{ config('app.company_name', 'My company') }}
    </a>
</strong>
@stop


{{-- Add common Javascript/Jquery code --}}



@push('js')
<!-- jQuery -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery Validation -->
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/jquery.validate.min.js"></script>
<script src="https://cdn.jsdelivr.net/jquery.validation/1.19.5/additional-methods.min.js"></script>

<!-- DataTables -->
<script src="https://cdn.datatables.net/2.0.2/js/jquery.dataTables.min.js"></script>

<!-- Bootstrap -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>




@endpush

@stack('scripts')


{{-- Add common CSS customizations --}}

@push('css')
<link rel="stylesheet" href="https://cdn.datatables.net/2.0.2/css/dataTables.dataTables.css" />
<!-- SweetAlert2 -->
<link rel="stylesheet" href="{{ asset('template/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css') }}">

<style type="text/css">

    {{-- You can add AdminLTE customizations here --}}
    /*
    .card-header {
        border-bottom: none;
    }
    .card-title {
        font-weight: 600;
    }
    */

</style>

@endpush
