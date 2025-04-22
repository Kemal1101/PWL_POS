@extends ('layout.app')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="card-tools">
                <button onclick="modalAction('{{ route('barang.create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
                <button onclick="modalAction('{{ route('barang.import') }}')" class="btn btn-sm btn-info mt-1">Import Barang</button>
                <a href="{{ route('barang.export_pdf') }}" class="btn btn-sm btn btn-primary mt-1">Export Barang</a>
                {{-- <a href="{{ route('barang.export_excel') }}" class="btn btn-sm btn btn-primary mt-1">Export Barang</a> --}}
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table id="table_barang" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Barang</th>
                        <th>Kode Barang</th>
                        <th>Kategori</th>
                        <th>Harga Beli</th>
                        <th>Harga Jual</th>
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


    var dataBarang;
    $(document).ready(function() {
        dataBarang = $('#table_barang').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('barang.getBarangs') }}",
                type: "GET",
                data: function(d) {
                    d.kategori_id = $('#kategori_id').val();
                }
            },
            columns: [
                { data: 'barang_nama', name: 'barang_nama' },
                { data: 'barang_kode', name: 'barang_kode' },
                { data: 'kategori_nama', name: 'kategori_nama' }, // Pastikan ini sesuai dengan kolom di controller
                { data: 'harga_beli', name: 'harga_beli' }, // Pastikan ini sesuai dengan kolom di controller
                { data: 'harga_jual', name: 'harga_jual' }, // Pastikan ini sesuai dengan kolom di controller
                {
                    data: null,
                    name: 'aksi',
                    render: function(data, type, row) {
                        let url_edit = `{{ route('barang.edit_ajax', ['id' => ':id']) }}`;
                        url_edit = url_edit.replace(':id', row.barang_id);
                        let url_hapus = `{{ route('barang.confirm_ajax', ['id' => ':id']) }}`;
                        url_hapus = url_hapus.replace(':id', row.barang_id);

                        return `<button onclick="modalAction('${url_edit}')" class="btn btn-sm btn-primary">Edit</button>
                        <button button onclick="modalAction('${url_hapus}')" class="btn btn-sm btn-danger">Hapus</button>`;
                    }
                }
            ]
        });

        // Event listener untuk filter kategori_id
        $('#kategori_id').change(function() {
            dataBarang.ajax.reload();
        });
    });
</script>
@endpush
