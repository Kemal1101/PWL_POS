<!DOCTYPE html>
<html lang="en">
<head>
  <meta charset="utf-8">
  <meta name="viewport" content="width=device-width, initial-scale=1">
  <title>Login Pengguna</title>

  <!-- Google Font -->
  <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=fallback">
  <!-- Bootstrap 4 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/css/bootstrap.min.css">
  <!-- SweetAlert2 -->
  <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
  <!-- Theme style -->
  <link rel="stylesheet" href="{{ asset('template/dist/css/adminlte.min.css') }}">

  <style>
    .login-box {
      width: 400px;
      margin: 80px auto;
    }
    .error-text {
      font-size: 0.875rem;
    }
  </style>
</head>
<body class="bg-light">

<div class="login-box card shadow">
  <div class="card-body">
    <h4 class="text-center mb-4">Login Pengguna</h4>

    <form action="{{ url('login') }}" method="POST" id="form-login">
      @csrf
      <div class="form-group">
        <label for="username">Username</label>
        <input type="text" name="username" id="username" class="form-control" placeholder="Masukkan username">
        <small id="error-username" class="text-danger error-text"></small>
      </div>

      <div class="form-group">
        <label for="password">Password</label>
        <input type="password" name="password" id="password" class="form-control" placeholder="Masukkan password">
        <small id="error-password" class="text-danger error-text"></small>
      </div>

      <div class="form-group form-check">
        <input type="checkbox" class="form-check-input" id="remember">
        <label class="form-check-label" for="remember">Ingat Saya</label>
      </div>

      <button type="submit" class="btn btn-primary btn-block">Masuk</button>
    </form>
  </div>
</div>

<!-- jQuery (Wajib sebelum plugin lain) -->
<script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>

<!-- jQuery Validation Plugin -->
<script src="https://cdn.jsdelivr.net/npm/jquery-validation@1.19.5/dist/jquery.validate.min.js"></script>

<!-- Bootstrap Bundle (untuk modal, dll) -->
<script src="https://cdn.jsdelivr.net/npm/bootstrap@4.6.2/dist/js/bootstrap.bundle.min.js"></script>

<!-- SweetAlert2 -->
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>


<script>
  $(document).ready(function () {
    console.log("jQuery version:", $.fn.jquery);
    console.log("Validate plugin available:", typeof $.fn.validate);

    $("#form-login").validate({
      rules: {
        username: { required: true, minlength: 4, maxlength: 20 },
        password: { required: true, minlength: 6, maxlength: 20 }
      },
      messages: {
        username: {
          required: "Username wajib diisi",
          minlength: "Minimal 4 karakter",
          maxlength: "Maksimal 20 karakter"
        },
        password: {
          required: "Password wajib diisi",
          minlength: "Minimal 6 karakter",
          maxlength: "Maksimal 20 karakter"
        }
      },
      submitHandler: function (form) {
        $.ajax({
          url: form.action,
          method: form.method,
          data: $(form).serialize(),
          success: function (response) {
            if (response.status) {
              Swal.fire({
                icon: 'success',
                title: 'Berhasil',
                text: response.message
              }).then(() => {
                window.location.href = response.redirect;
              });
            } else {
              $('.error-text').text('');
              $.each(response.msgField, function (field, message) {
                $('#error-' + field).text(message[0]);
              });
              Swal.fire({
                icon: 'error',
                title: 'Login Gagal',
                text: response.message
              });
            }
          }
        });
        return false;
      },
      errorElement: 'span',
      errorClass: 'text-danger',
      errorPlacement: function (error, element) {
        element.closest('.form-group').append(error);
      },
      highlight: function (element) {
        $(element).addClass('is-invalid');
      },
      unhighlight: function (element) {
        $(element).removeClass('is-invalid');
      }
    });
  });
</script>
</body>
</html>
