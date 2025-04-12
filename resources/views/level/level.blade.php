@extends ('layout.app')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="card-tools">
                {{-- <a class="btn btn-sm btn-primary mt-1" href="{{ route('level.tambah') }}">Tambahhh</a> --}}
                <button onclick="modalAction('{{ route('level.create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table id="table_level" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Level</th>
                        <th>Kode Level</th>
                        <th>Level ID</th>
                        <th>Aksi</th>
                    </tr>
                </thead>
                <tbody></tbody>
            </table>
        </div>
    </div>

    <!-- Modal -->
    <div id="myModal" class="modal fade animate shake" tabindex="-1" role="dialog"
        data-backdrop="static" data-keyboard="false" data-width="75%" aria-hidden="true">
    </div>
@endsection

@push('js')
<script>
    function modalAction(url) {
        $.get(url, function(response) {
            $('#myModal').html(response); // Isi modal dengan konten dari server
            $('#myModal').modal('show');  // Tampilkan modal setelah konten dimuat
        }).fail(function() {
            alert('Gagal memuat modal.');
        });
    }


    var dataUser;
    $(document).ready(function() {
        dataUser = $('#table_level').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('level.getLevels') }}",
                type: "GET",
            },
            columns: [
                { data: 'level_nama', name: 'level_nama' },
                { data: 'level_kode', name: 'level_kode' },
                { data: 'level_id', name: 'level_id' }, // Pastikan ini sesuai dengan kolom di controller
                {
                    data: null,
                    name: 'aksi',
                    render: function(data, type, row) {
                        let url_edit = `{{ route('level.edit_ajax', ['id' => ':id']) }}`;
                        url_edit = url_edit.replace(':id', row.level_id);
                        let url_hapus = `{{ route('level.confirm_ajax', ['id' => ':id']) }}`;
                        url_hapus = url_hapus.replace(':id', row.level_id);
                        return `<button onclick="modalAction('${url_edit}')" class="btn btn-sm btn-primary">Edit</button>
                        <button button onclick="modalAction('${url_hapus}')" class="btn btn-sm btn-danger">Hapus</button>`;
                    }
                }
            ]
        });
    });
</script>
@endpush
