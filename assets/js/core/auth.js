
// Verificar sesión al cargar la página (excepto en index.php)
if (!window.location.pathname.endsWith('/index.php')) {
    $.ajax({
        url: 'controllers/check_session.php',
        type: 'GET',
        success: function(response) {
            var data = JSON.parse(response);
            if (!data.isLoggedIn) {
                window.location.href = 'index.php';
            } else {
                let tobase = btoa(JSON.stringify(data))
                let userData = sessionStorage.getItem("info")

                if (!userData){
                    sessionStorage.setItem("info", tobase);
                }
            }
        }
    });
}

$(document).ready(function() {

    // Manejar el logout
    $('#logoutButton').on('click', function() {
        $.ajax({
            url: 'controllers/auth.php',
            type: 'POST',
            data: { action: 'logout' },
            success: function(response) {
                // Limpiar localStorage
                sessionStorage.removeItem('info');
                window.location.href = 'index.php';
            }
        });
    });
});