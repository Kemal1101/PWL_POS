@extends('adminlte::page')

@section('title', 'Isi Form Level')

@section('content_header')
    <h1>Isi Form Level</h1>
@stop

@section('content')
<form>
    <div class="card-body">
      <div class="form-group">
        <label for="exampleInputNama">Nama Level</label>
        <input type="email" class="form-control" id="exampleInputNama" placeholder="Enter Nama Level">
      </div>
      <div class="form-group">
        <label for="exampleInputUsername">Kode Level</label>
        <input type="email" class="form-control" id="exampleInputUsername" placeholder="Enter Kode Level">
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
@stop
