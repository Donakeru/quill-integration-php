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
              <h4 class="page-title" id="page-title">Dashboard</h4>
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
                <li class="separator">
                  <i class="icon-arrow-right"></i>
                </li>
                <li class="nav-item">
                  <a href="#" id="nav-breadcrumb"></a>
                </li>
              </ul>
            </div>
            <div class="page-category">

            <div class="card">
              <div class="card-header d-flex justify-content-between">
                <div class="card-title" id="card-title"></div>
                <a href="articulos-creados.php" class="btn btn-primary btn-sm float-right"><i class="icon-arrow-left"></i> Volver a la tabla de artículos</a>
              </div>
              <div class="card-body">

                <form action="" name="article_form" id="article_form" method="POST">
                  <input type="hidden" name="article_id" id="article_id" />
                  <div class="row">
                    <div class="col-md-6 col-lg-4">
                      <div class="form-group">
                        <label for="title">Titulo Artículo</label>
                        <input
                          type="text"
                          class="form-control"
                          name="title"
                          id="title"
                          placeholder="Escribe el titulo del artículo"
                        />
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                      <div class="form-group">
                          <label for="category_id">Categoría del Artículo</label>
                          <select
                            class="form-select form-control"
                            id="category_id"
                            name="category_id"
                          >
                          </select>
                      </div>
                    </div>
                    <div class="col-md-6 col-lg-4">
                      <div class="form-group">
                        <label for="video">Vincular video (Opcional)</label>
                        <input
                          type="text"
                          class="form-control"
                          name="video"
                          id="video"
                          placeholder="Pega el URL del video"
                        />
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="col-md-12">
                      <div class="form-group">
                      <label for="content">Contenido del Artículo</label>
                        <!-- Contenedor de Quill -->
                        <div id="editor" style="height: 200px;"></div>
                        <!-- Campo oculto para enviar el contenido formateado -->
                        <input type="hidden" name="content" id="content">
                      </div>
                    </div>
                  </div>
                  <div class="row">
                    <div class="">
                      <div class="form-group">
                        <button class="btn btn-success" id="submit-btn"></button>
                        <!-- Botón de eliminar artículo -->
                        <button class="btn btn-danger" id="delete-btn" style="display: none;">Eliminar Artículo</button>
                      </div>
                    </div>
                  </div>
                </form>

                <script src="https://cdn.quilljs.com/1.3.6/quill.js"></script>
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
    <script src="assets/js/forms/articulo.js?v=3"></script>
  </body>
</html>