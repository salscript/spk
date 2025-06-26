<!DOCTYPE html>
<html lang="en">

<head>
   <meta charset="UTF-8">
   <meta name="viewport" content="width=device-width, initial-scale=1.0">
   <title>Login | SPK</title>
   <link rel="icon" type="image/x-icon" href="<?php echo base_url('assets/back/dist/img/technolife.webp') ?>">

   <!-- Google Font -->
   <link rel="stylesheet" href="https://fonts.googleapis.com/css?family=Source+Sans+Pro:300,400,600,700&display=swap">
   <!-- Font Awesome -->
   <link rel="stylesheet" href="<?php echo base_url('assets/back/plugins/fontawesome-free/css/all.min.css') ?>">

   <style>
      * {
         box-sizing: border-box;
      }

      body {
         margin: 0;
         padding: 0;
         font-family: 'Source Sans Pro', sans-serif;
         background: url('<?php echo base_url("assets/back/dist/img/bg-pattern.png"); ?>') no-repeat center center fixed;
         background-size: cover;
         height: 100vh;
         display: flex;
         justify-content: center;
         align-items: center;
      }

      .login-container {
         background-color: rgba(255, 255, 255, 0.95);
         border-radius: 20px;
         padding: 30px 25px;
         width: 100%;
         max-width: 400px;
         box-shadow: 0 8px 20px rgba(0, 0, 0, 0.1);
         text-align: center;
         position: relative;
      }

      .login-container img {
         width: 70px;
         margin-bottom: 10px;
      }

      .login-container h1 {
         font-size: 22px;
         margin: 0;
         font-weight: 600;
         color: #000;
      }

      .login-container small {
         font-size: 16px;
         color: #333;
         display: block;
         margin-bottom: 15px;
      }

      .input-group {
         position: relative;
         margin-bottom: 15px;
         display: flex;
         align-items: center;
      }

      .input-group input {
         width: 100%;
         padding: 10px 12px 10px 40px;
         border: 1px solid #ccc;
         border-radius: 10px;
         font-size: 14px;
      }

      .input-group .fas {
         position: absolute;
         left: 12px;
         color: #999;
      }

      .btn {
         background-color: #2b4c81;
         color: white;
         border: none;
         padding: 10px;
         width: 100%;
         border-radius: 10px;
         font-size: 16px;
         cursor: pointer;
         margin-top: 5px;
      }

      .btn:hover {
         background-color: #1f3a66;
      }

      .help-text {
         font-size: 13px;
         margin-top: 15px;
         color: #555;
      }

      .help-text a {
         color: #2b4c81;
         text-decoration: none;
      }

      #loginError {
         background-color: #f8d7da;
         color: #721c24;
         padding: 10px;
         border-radius: 8px;
         font-size: 14px;
         margin-bottom: 15px;
         display: none;
      }
   </style>
</head>

<body>

   <div class="login-container">
      <img src="<?php echo base_url('assets/back/dist/img/technolife.webp') ?>" alt="Logo Technolife">
      <h1>PT.Technolife</h1>
      <small>Karya Industri Utama</small>

      <div id="loginError"></div>

      <form id="formLogin" method="post" autocomplete="off">
         <div class="input-group">
            <i class="fas fa-user"></i>
            <input type="email" name="email" id="email" placeholder="Email" required>
         </div>
         <div class="input-group">
            <i class="fas fa-lock"></i>
            <input type="password" name="password" id="password" placeholder="Password" required>
         </div>
         <button type="submit" class="btn">Login</button>
      </form>

      <p class="help-text">Hubungi admin apabila anda lupa password.</p>
   </div>

   <script src="https://code.jquery.com/jquery-3.6.0.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
<script>
   $(document).ready(function () {
      $('#formLogin').submit(function (e) {
         e.preventDefault();

         let email = $('#email').val().trim();
         let password = $('#password').val().trim();

         $('#loginError').hide();

         $.ajax({
            type: "POST",
            url: "<?php echo base_url('auth/login_aksi') ?>",
            data: { email: email, password: password },
            dataType: "json",
            success: function (response) {
               if (response.error) {
                  $('#loginError').hide().text(response.error).fadeIn();
               } else if (response.role) {
                  Swal.fire({
                     icon: 'success',
                     title: 'Login Berhasil',
                     text: response.success,
                     timer: 1200,
                     showConfirmButton: false
                  }).then(() => {
                     let url = response.role == '1' ? 'dashboard/admin' :
                               response.role == '2' ? 'dashboard/user' :
                               'dashboard/operator';
                     window.location.href = "<?php echo base_url(); ?>" + url;
                  });
               }
            },
            error: function () {
               $('#loginError').hide().text('Terjadi kesalahan pada server.').fadeIn();
            }
         });
      });
   });
</script>

</html>
