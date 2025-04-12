<form action="{{ route('level.store_ajax') }}" method="POST" id="form-tambah">
    @csrf
    <div id="modal-master" class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Tambah Data Level</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <form id="formLevel">
                <div class="modal-body">
                    <div class="form-group">
                        <label for="level_nama">Nama Level</label>
                        <input type="text" name="level_nama" id="level_nama" class="form-control" required>
                        <small id="error-level_nama" class="form-text text-danger"></small>
                    </div>

                    <div class="form-group">
                        <label for="level_kode">Kode Level</label>
                        <input type="text" name="level_kode" id="level_kode" class="form-control" required>
                        <small id="error-level_kode" class="form-text text-danger"></small>
                    </div>
                </div>

                <div class="modal-footer">
                    <button type="button" class="btn btn-warning" data-dismiss="modal">Batal</button>
                    <button type="submit" class="btn btn-primary">Simpan</button>
                </div>
            </form>
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
                    level_nama: {required: true, minlength: 3, maxlength: 20},
                    level_kode: {required: true, minlength: 3, maxlength: 3},
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
                            dataUser.ajax.reload();
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
