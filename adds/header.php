<div class="main-header">
  <div class="main-header-logo">
    <!-- Logo Header -->
    <div class="logo-header" data-background-color="dark">
      <div class="nav-toggle">
        <button class="btn btn-toggle toggle-sidebar">
        <i class="gg-menu-right"></i>
        </button>
        <button class="btn btn-toggle sidenav-toggler">
        <i class="gg-menu-left"></i>
        </button>
      </div>
      <button class="topbar-toggler more">
      <i class="gg-more-vertical-alt"></i>
      </button>
    </div>
    <!-- End Logo Header -->
  </div>
  <!-- Navbar Header -->
  <nav
    class="navbar navbar-header navbar-header-transparent navbar-expand-lg border-bottom"
    >
    <div class="container-fluid">
      <ul class="navbar-nav topbar-nav ms-md-auto align-items-center">
        <li class="nav-item topbar-user dropdown hidden-caret">
          <a
            class="dropdown-toggle profile-pic"
            data-bs-toggle="dropdown"
            href="#"
            aria-expanded="false"
            >
            <div class="avatar-sm">
              <img
                src="assets/img/user_image.jpg"
                alt="..."
                class="avatar-img rounded-circle"
                />
            </div>
            <span class="profile-username">
            <span class="op-7">Hola,</span>
            <span class="fw-bold" id="header_username"></span>
            </span>
          </a>
          <ul class="dropdown-menu dropdown-user animated fadeIn">
            <div class="dropdown-user-scroll scrollbar-outer">
              <li>
                <div class="user-box">
                  <div class="avatar-lg">
                    <img
                      src="assets/img/user_image.jpg"
                      alt="image profile"
                      class="avatar-img rounded"
                      />
                  </div>
                  <div class="u-text">
                    <h4 id="header_menu_username"></h4>
                    <p class="text-muted" id="header_menu_email"></p>
                  </div>
                </div>
              </li>
              <li>
                <div class="dropdown-divider"></div>
                <a class="dropdown-item" id="logoutButton">Cerrar Sesión</a>
              </li>
            </div>
          </ul>
        </li>
      </ul>
    </div>
  </nav>
  <!-- End Navbar -->
  <script>
    document.addEventListener("DOMContentLoaded", function() {
      const userData = JSON.parse(atob(sessionStorage.getItem('info')));
      document.getElementById("header_username").innerText = userData.username;
      document.getElementById("header_menu_username").innerText = userData.username;
      document.getElementById("header_menu_email").innerText = userData.email;
    });

  </script>
</div>