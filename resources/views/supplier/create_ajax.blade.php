<form action="{{ route('supplier.store_ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="myModal" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Supplier</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
                <div class="modal-body">
                    <div class="form-group">
                        <label for="supplier_nama">Nama Supplier</label>
                        <input type="text" name="supplier_nama" id="supplier_nama" class="form-control" required>
                        <small id="error-supplier_nama" class="form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="supplier_kode">Kode Supplier</label>
                        <input type="text" name="supplier_kode" id="supplier_kode" class="form-control" required>
                        <small id="error-supplier_kode" class="form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="supplier_alamat">Alamat Supplier</label>
                        <input type="text" name="supplier_alamat" id="supplier_alamat" class="form-control" required>
                        <small id="error-supplier_alamat" class="form-text text-danger"></small>
                    </div>
                    <div class="form-group">
                        <label for="supplier_phonenumber">Telepon Supplier</label>
                        <input type="text" name="supplier_phonenumber" id="supplier_phonenumber" class="form-control" required>
                        <small id="error-supplier_phonenumber" class="form-text text-danger"></small>
                    </div>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
        </div>
    </div>
</form>
    <script>
        $(document).ready(function() {
            $.ajaxSetup({
                headers: {
                    'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content'),
                    'Accept': 'application/json'
                }
            });
            $("#form-tambah").validate({
                rules: {
                    supplier_nama: {required: true, minlength: 3, maxlength: 100},
                    supplier_kode: {required: true, minlength: 4, maxlength: 4},
                    supplier_alamat: {required: true, minlength: 3, maxlength: 100},
                    supplier_phonenumber: {required: true, minlength: 3, maxlength: 20},
                },
                submitHandler: function(form) {
                    $.ajax({
                    url: form.action,
                    type: form.method,
                    data: $(form).serialize(),
                    success: function(response) {
                        if(response.status){
                            $('#myModal').modal('hide');
                            Swal.fire({
                                icon: 'success',
                                title: 'Berhasil',
                                text: response.message
                            });
                            dataSupplier.ajax.reload();
                        }else{
                            $('.error-text').text('');
                            $.each(response.msgField, function(prefix, val) {
                                $('#error-'+prefix).text(val[0]);
                                });
                            Swal.fire({
                                icon: 'error',
                                title: 'Terjadi Kesalahan',
                                text: response.message
                                });
                        }
                    }
                });
                    return false; // Cegah form submit biasa
                },
                errorElement: 'span',
                errorPlacement: function (error, element) {
                    error.addClass('invalid-feedback');
                    element.closest('.form-group').append(error);
                },
                highlight: function (element, errorClass, validClass) {
                    $(element).addClass('is-invalid');
                },
                unhighlight: function (element, errorClass, validClass) {
                    $(element).removeClass('is-invalid');
                }
            });
        });
        $(document).on('click', '[data-dismiss="modal"]', function() {
            $('#myModal').modal('hide');
        });

    </script>
