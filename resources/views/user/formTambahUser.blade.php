@extends('adminlte::page')

@section('title', 'Isi Form User')

@section('content_header')
    <h1>Isi Form User</h1>
@stop

@section('content')
<form>
    <div class="card-body">
      <div class="form-group">
        <label for="exampleInputNama">Nama</label>
        <input type="email" class="form-control" id="exampleInputNama" placeholder="Enter Nama">
      </div>
      <div class="form-group">
        <label for="exampleInputUsername">Username</label>
        <input type="email" class="form-control" id="exampleInputUsername" placeholder="Enter Username">
      </div>
        <!-- select -->
    <div class="form-group">
        <label>Level</label>
        <select class="form-control">
            <option>Administrator</option>
            <option>Manager</option>
            <option>Staff/Kasir</option>
            <option>Customer</option>
        </select>
    </div>
      <div class="form-group">
        <label for="exampleInputPassword1">Password</label>
        <div class="input-group">
            <input type="password" class="form-control" id="exampleInputPassword1" placeholder="Password">
            <button class="btn btn-outline-secondary" type="button" id="togglePassword">
                <svg id="eyeOpen" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye" viewBox="0 0 16 16">
                    <path d="M16 8s-3-5-8-5-8 5-8 5 3 5 8 5 8-5 8-5z"/>
                    <path d="M8 11.5A3.5 3.5 0 1 1 8 4.5a3.5 3.5 0 0 1 0 7z"/>
                </svg>
                <svg id="eyeClosed" xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor" class="bi bi-eye-slash" viewBox="0 0 16 16" style="display: none;">
                    <path d="M13.359 11.238A7.758 7.758 0 0 0 16 8s-3-5-8-5a7.75 7.75 0 0 0-3.637.864"/>
                    <path d="M10.73 12.146a7.72 7.72 0 0 1-2.73.354c-5 0-8-5-8-5a14.16 14.16 0 0 1 2.99-3.727"/>
                    <path d="M3.354 3.646a.5.5 0 1 1 .707.708l-3 3a.5.5 0 1 1-.707-.708l3-3z"/>
                </svg>
            </button>
        </div>
    <!-- /.card-body -->

    <div class="card-footer">
      <button type="submit" class="btn btn-primary">Submit</button>
    </div>
</form>
@stop

@section('css')
    {{-- Add here extra stylesheets --}}
    {{-- <link rel="stylesheet" href="/css/admin_custom.css"> --}}
@stop

@section('js')
    <script> console.log("Hi, I'm using the Laravel-AdminLTE package!"); </script>
    <script>
        document.getElementById('togglePassword').addEventListener('click', function () {
            var passwordInput = document.getElementById('exampleInputPassword1');
            var eyeOpen = document.getElementById('eyeOpen');
            var eyeClosed = document.getElementById('eyeClosed');

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                eyeOpen.style.display = "none";
                eyeClosed.style.display = "inline";
            } else {
                passwordInput.type = "password";
                eyeOpen.style.display = "inline";
                eyeClosed.style.display = "none";
            }
        });
    </script>
@stop
