<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Enlace Global - Blog Login</title>
    <link
      rel="icon"
      href="assets/img/kaiadmin/enlaceglobal_favicon.ico"
      type="image/x-icon"
    />
    <!-- Bootstrap 5 CDN-Import: -->
    <link rel="stylesheet" href="assets/css/bootstrap.min.css" />
    <link rel="stylesheet" href="assets/css/plugins.min.css" />
    <link rel="stylesheet" href="assets/css/kaiadmin.min.css" />
    
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta2/css/all.min.css" integrity="sha512-YWzhKL2whUzgiheMoBFwW8CKV4qpHQAEuvilg9FAn5VJUDwKZZxkJNuGM4XkWuk94WCrrwslk8yWNGmY1EduTA==" crossorigin="anonymous" referrerpolicy="no-referrer" />
    
    <!-- Light-Theming: -->
    <link id="mainStyle" rel="stylesheet" href="assets/css/login.css">

</head>
<body>

    <div class="page-content d-flex align-items-center">

        <div class="container d-flex justify-content-center">

            <div class="col-12 col-sm-10 col-md-8 col-lg-7 col-xl-6 col-xxl-5">

                <div class="auth-card">

                    <div class="logo-area">

                        <img id="header_logo" class="logo" src="assets/img/kaiadmin/enlaceglobal_logo_negro.png"/>

                    </div>

                    <h5 class="auth-title">Blog Dashboard</h5>

                    <hr class="separator">

                    <!-- Login-Form-->
                    <form id="loginForm">

                        <div class="mb-2 mt-5">
                            <input type="email" name="email" class="form-control auth-input" placeholder="Nombre de Usuario">
                        </div>

                        <div class="mb-3">
                            <input type="password" name="password" class="form-control auth-input" placeholder="Contraseña">
                        </div>

                        <button class="btn auth-btn mt-2 mb-4">Iniciar Sesión</button>

                    </form>

                </div>
            </div>
        </div>
    </div>

    <script src="assets/js/core/jquery-3.7.1.min.js"></script>
    <script src="assets/js/plugin/jquery-scrollbar/jquery.scrollbar.min.js"></script>
    <script src="assets/js/plugin/jquery.sparkline/jquery.sparkline.min.js"></script>
    <script src="assets/js/core/bootstrap.min.js"></script>
    <script src="assets/js/core/auth.js"></script>
    <script>
        // Manejar el login
    $('#loginForm').on('submit', function(e) {
        e.preventDefault();
        $.ajax({
            url: 'controllers/auth.php',
            type: 'POST',
            data: {
                action: 'login',
                email: $('input[name="email"]').val(),
                password: $('input[name="password"]').val()
            },
            success: function(response) {
                var data = JSON.parse(response);
                if (data.status === 'success') {
                    let tobase = btoa(JSON.stringify(data))
                    sessionStorage.setItem("info", tobase);
                    window.location.href = 'articulos-creados.php';
                } else {
                    $('#message').text(data.message || 'Error en el login');
                }
            }
        });
    });
    </script>
</body>
</html>
