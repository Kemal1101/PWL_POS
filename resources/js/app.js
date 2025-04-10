import './bootstrap';
import "../sass/app.scss";
import 'laravel-datatables-vite';
import $ from 'jquery';
import 'jquery-validation';

window.$ = $;
window.jQuery = $;

$(document).ready(function () {
  $('#form-tambah').validate({
    rules: {
      username: { required: true, minlength: 3 }
    },
    submitHandler: function (form) {
      alert('Valid!');
    }
  });
});
