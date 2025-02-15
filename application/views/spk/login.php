<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login | SPK</title>
   <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/back/dist/img/fav-insaba.png') ?>">

   <!-- Google Font: Source Sans Pro -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,400i,700&display=fallback">
   <!-- Font Awesome -->
   <link rel="stylesheet" href="<?php echo base_url('assets/back') ?>/plugins/fontawesome-free/css/all.min.css">
   <!-- icheck bootstrap -->
   <link rel="stylesheet" href="<?php echo base_url('assets/back') ?>/plugins/icheck-bootstrap/icheck-bootstrap.min.css">
   <!-- SweetAlert2 -->
   <link rel="stylesheet" href="<?php echo base_url('assets/back') ?>/plugins/sweetalert2-theme-bootstrap-4/bootstrap-4.min.css">
   <!-- Toastr -->
   <link rel="stylesheet" href="<?php echo base_url('assets/back') ?>/plugins/toastr/toastr.min.css">
   <!-- Theme style -->
   <link rel="stylesheet" href="<?php echo base_url('assets/back') ?>/dist/css/adminlte.min.css">
   <style>
      .alert-danger {
         max-width: 100%;
         padding: 5px;
         margin: 6px 0;
         border: 1px solid transparent;
         border-radius: 4px;
         font-size: 14px;
      }
   </style>
</head>

<body class="hold-transition login-page">
   <div class="login-box">
      <div class="login-logo">
         <a href="#"><b>SPK</b> IT</a>
      </div>
      <div class="card">
         <div class="card-body login-card-body" style="border-radius: 20px;">
            <p class="login-box-msg">Sign in to start your session</p>
            <?php if ($this->session->flashdata('message')) : ?>
               <div class="alert alert-danger">
                  <?php echo $this->session->flashdata('message'); ?>
               </div>
            <?php endif; ?>
            <form action="#" method="post" id="formLogin">
               <div class="input-group mb-3">
                  <input type="email" name="email" id="email" class="form-control" placeholder="Email">
                  <div class="input-group-append">
                     <div class="input-group-text">
                        <span class="fas fa-envelope"></span>
                     </div>
                  </div>
               </div>
               <div class="input-group mb-3">
                  <input type="password" name="password" id="password" class="form-control" placeholder="Password">
                  <div class="input-group-append">
                     <div class="input-group-text">
                        <span class="fas fa-lock"></span>
                     </div>
                  </div>
               </div>
               <div class="row">
                  <div class="col-8">
                     <div class="icheck-primary">
                        <input type="checkbox" id="remember">
                        <label for="remember">
                           Remember Me
                        </label>
                     </div>
                  </div>
                  <div class="col-4">
                     <button type="submit" class="btn btn-primary btn-block">Sign In</button>
                  </div>
               </div>
            </form>
         </div>
      </div>
   </div>

   <!-- jQuery -->
   <script src="<?php echo base_url('assets/back') ?>/plugins/jquery/jquery.min.js"></script>
   <!-- Bootstrap 4 -->
   <script src="<?php echo base_url('assets/back') ?>/plugins/bootstrap/js/bootstrap.bundle.min.js"></script>
   <!-- SweetAlert2 -->
   <script src="<?php echo base_url('assets/back') ?>/plugins/sweetalert2/sweetalert2.min.js"></script>
   <!-- Toastr -->
   <script src="<?php echo base_url('assets/back') ?>/plugins/toastr/toastr.min.js"></script>
   <!-- AdminLTE App -->
   <script src="<?php echo base_url('assets/back') ?>/dist/js/adminlte.min.js"></script>
   <script>
      $(document).ready(function() {
         $('#formLogin').on("submit", function(event) {
            event.preventDefault();
            var email = $('#email').val();
            var password = $('#password').val();

            if (!validateForm()) {
               return false;
            } else {
               $.ajax({
                  type: "post",
                  url: "<?php echo base_url('auth/login_aksi') ?>",
                  data: {
                     "email": email,
                     "password": password
                  },
                  dataType: "json",
                  success: function(response) {
                     if (response.role == '1') {
                        Swal.fire({
                              icon: 'success',
                              title: 'Login Berhasil',
                              text: response.success,
                              showCancelButton: false,
                              showConfirmButton: false,
                              timer: '1000'
                           })
                           .then(function() {
                              window.location.href = "<?php echo base_url('dashboard/admin') ?>";
                           });
                     }
                     if (response.role == '2') {
                        Swal.fire({
                              icon: 'success',
                              title: 'Login Berhasil',
                              text: response.success,
                              showCancelButton: false,
                              showConfirmButton: false,
                              timer: '1000'
                           })
                           .then(function() {
                              window.location.href = "<?php echo base_url('dashboard/user') ?>";
                           });
                     }
                     if (response.error) {
                        Swal.fire({
                           icon: 'error',
                           title: 'Oops...',
                           text: response.error
                        });
                     }
                  },
                  error: function(response) {
                     Swal.fire({
                        icon: 'error',
                        title: 'Oops',
                        text: 'server error!'
                     });

                     console.log(response);
                  },
                  error: function(xhr, ajaxOptions, thrownError) {
                     alert(xhr.status + "\n" + xhr.responseText + "\n" + thrownError);
                  }
               });
               return false;
            }

         });

      });

      function validateForm() {
         if (document.forms["formLogin"]["email"].value == "") {
            toastr.error("Email Pengguna harus diisi !!");
            document.forms["formLogin"]["email"].focus();
            return false;
         }
         if (document.forms["formLogin"]["password"].value == "") {
            toastr.error("Kata Sandi harus diisi !!");
            document.forms["formLogin"]["password"].focus();
            return false;
         }
         return true;
      }
   </script>
</body>

</html>