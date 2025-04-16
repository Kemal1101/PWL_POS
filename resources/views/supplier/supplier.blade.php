@extends ('layout.app')

@section('content')
    <div class="card card-outline card-primary">
        <div class="card-header">
            <div class="card-tools">
                <button onclick="modalAction('{{ route('supplier.create_ajax') }}')" class="btn btn-sm btn-success mt-1">Tambah Ajax</button>
            </div>
        </div>
        <div class="card-body">
            @if (session('success'))
                <div class="alert alert-success">{{ session('success') }}</div>
            @endif
            @if (session('error'))
                <div class="alert alert-danger">{{ session('error') }}</div>
            @endif

            <table id="table_supplier" class="table table-bordered">
                <thead>
                    <tr>
                        <th>Nama Supplier</th>
                        <th>Kode Supplier</th>
                        <th>Alamat Supplier</th>
                        <th>Nomor Telepon Supplier</th>
                        <th>ID Supplier</th>
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


    var dataSupplier;
    $(document).ready(function() {
        dataSupplier = $('#table_supplier').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('supplier.getsuppliers') }}",
                type: "GET",
            },
            columns: [
                { data: 'supplier_nama', name: 'supplier_nama' },
                { data: 'supplier_kode', name: 'supplier_kode' },
                { data: 'supplier_alamat', name: 'supplier_alamat' },
                { data: 'supplier_phonenumber', name: 'supplier_phonenumber' },
                { data: 'supplier_id', name: 'supplier_id' }, // Pastikan ini sesuai dengan kolom di controller
                {
                    data: null,
                    name: 'aksi',
                    render: function(data, type, row) {
                        let url_edit = `{{ route('supplier.edit_ajax', ['id' => ':id']) }}`;
                        url_edit = url_edit.replace(':id', row.supplier_id);
                        let url_hapus = `{{ route('supplier.confirm_ajax', ['id' => ':id']) }}`;
                        url_hapus = url_hapus.replace(':id', row.supplier_id);
                        return `<button onclick="modalAction('${url_edit}')" class="btn btn-sm btn-primary">Edit</button>
                        <button button onclick="modalAction('${url_hapus}')" class="btn btn-sm btn-danger">Hapus</button>`;
                    }
                }
            ]
        });
    });
</script>
@endpush
