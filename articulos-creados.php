<!DOCTYPE html>
<html lang="en">
  <?php
    require('adds/head_tag.php');
    ?>
  <body>
    <div class="wrapper">
    <?php
      require('adds/sidebar.php');
      ?>
    <div class="main-panel">
      <?php
        require('adds/header.php');
        ?>
      <div class="container">
        <div class="page-inner">
          <div class="page-header">
            <h4 class="page-title">Dashboard</h4>
            <ul class="breadcrumbs">
              <li class="nav-home">
                <a href="#">
                <i class="icon-home"></i>
                </a>
              </li>
              <li class="separator">
                <i class="icon-arrow-right"></i>
              </li>
              <li class="nav-item">
                <a href="#">Tabla de Artículos</a>
              </li>
            </ul>
          </div>
          <div class="page-category">
            <div class="card">
              <div class="card-header d-flex justify-content-between">
                <h4 class="card-title">Tabla de Artículos</h4>
                <!-- Botón para crear nuevo artículo -->
                <a href="text-editor.php" class="btn btn-primary btn-sm float-right"><i class="icon-plus"></i> Crear Nuevo Artículo</a>
              </div>
              <div class="card-body">
                <div class="table-responsive w-100">
                    <table id="miTabla" class="table table-striped w-100">
                        <thead>
                            <tr>
                                <th>ID</th>
                                <th>Título</th>
                                <th>Fecha</th>
                                <th>Vista previa</th>
                                <th>Estado</th>
                                <th>Acciones</th>
                            </tr>
                        </thead>
                    </table>
                </div>
              </div>
            </div>
          </div>
        </div>
        <?php
          require('adds/footer.php');
          ?>
      </div>
    </div>
    <?php
      require('adds/adding_libraries.php');
    ?>
    <script src="assets/js/forms/datatable_articulos.js?v=4"></script>
  </body>
</html>
