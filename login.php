<!DOCTYPE html>
<html lang="en">
  <head>
    <meta charset="UTF-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>e-Arsip | Login</title>

    <link
      rel="shortcut icon"
      href="dist/img/favicon2.ico"
      type="image/x-icon"
    />
    <link
      rel="stylesheet"
      href="plugins/fontawesome-free/css/all.min.css"
    />
    <link rel="stylesheet" href="assets/css/sign-in.css" />
  </head>
  <body>
    <div class="container">
      <div class="row">
        <div class="col-left">
          <div class="banner">
            <img src="assets/img/oxxo.png" alt="Banner" />
            <!-- <h3>PT OXXO FASTON Indonesia</h3> -->
          </div>
        </div>

        <div class="col-right">
          <div class="card-header">
            <h1>Selamat Datang</h1>
            <p>Silakan masuk ke akun Anda</p>
          </div>

          <form action="cek_login.php" method="post" novalidate>
            <div class="form-group">
              <label for="username"
                >Username atau Email<span class="text-danger">*</span></label
              >

              <div class="input-group">
              
                <input
                  class="input form-control"
                  type="text"
                  name="username"
                  id="username"
                  placeholder="Username"
                  required
                  autofocus
                  autocomplete="off"
                />
              </div>
              
            </div>

            <div class="form-group">
              <label for="password"
                >Kata Sandi<span class="text-danger">*</span></label
              >

              <div class="input-group">
               
                <input
                  class="input form-control"
                  type="password"
                  name="password"
                  id="password"
                  placeholder="password"
                  required
                />
              </div>
            </div>

            <div class="form-group" style="margin-top: 2rem">
              <button type="submit" class="btn-login">Masuk</button>
            </div>

              </form>
        </div>
      </div>
    </div>

    <script src="plugins/jquery/jquery.min.js"></script>
    <script src="dist/js/login.js"></script>
  </body>
</html>

