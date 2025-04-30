@extends ('layout.app')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="card-tools">
                <button onclick="modalAction('{{ route('user.create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
                <button onclick="modalAction('{{ route('user.import') }}')" class="btn btn-sm btn-info mt-1">Import User</button>
                <a href="{{ route('user.export_pdf') }}" class="btn btn-sm btn btn-primary mt-1">Export User</a>
                {{-- <a href="{{ route('user.export_excel') }}" class="btn btn-sm btn btn-primary mt-1">Export User</a> --}}
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <select id="level_id">
                <option value="">Semua Level</option>
                <option value="1">Admin</option>
                <option value="2">User</option>
            </select>

            <table id="table_user" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama</th>
                        <th>Username</th>
                        <th>Level</th>
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
        dataUser = $('#table_user').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('user.getUsers') }}",
                type: "GET",
                data: function(d) {
                    d.level_id = $('#level_id').val();
                }
            },
            columns: [
                { data: 'nama', name: 'nama' },
                { data: 'username', name: 'username' },
                { data: 'level_nama', name: 'level_nama' }, // Pastikan ini sesuai dengan kolom di controller
                {
                    data: null,
                    name: 'aksi',
                    render: function(data, type, row) {
                        let url_edit = `{{ route('user.edit_ajax', ['id' => ':id']) }}`;
                        url_edit = url_edit.replace(':id', row.user_id);
                        let url_hapus = `{{ route('user.confirm_ajax', ['id' => ':id']) }}`;
                        url_hapus = url_hapus.replace(':id', row.user_id);

                        return `<button onclick="modalAction('${url_edit}')" class="btn btn-sm btn-primary">Edit</button>
                        <button button onclick="modalAction('${url_hapus}')" class="btn btn-sm btn-danger">Hapus</button>`;
                    }
                }
            ]
        });

        // Event listener untuk filter level_id
        $('#level_id').change(function() {
            dataUser.ajax.reload();
        });
    });
</script>
@endpush
