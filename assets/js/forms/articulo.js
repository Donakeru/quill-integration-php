function unescapeHTML(str) {
  var doc = new DOMParser().parseFromString(str, 'text/html');
  return doc.documentElement.textContent || doc.documentElement.innerText;
}

async function saveArticleAndSendNotifications(url, type, formData) {
  try {
      // Primera petición: Guardar el artículo
      const firstResponse = await $.ajax({
          url: url,
          type: type,
          data: formData,
      });

      // Mostrar mensaje de éxito
      await swal({
          title: "Buen trabajo!",
          text: formData.article_id ? "Artículo actualizado correctamente." : "Artículo creado correctamente.",
          icon: "success",
          buttons: {
              confirm: {
                  text: "Confirmar",
                  value: true,
                  visible: true,
                  className: "btn btn-success",
                  closeModal: true,
              },
          },
      });
      window.location.href = "articulos-creados.php";

      console.log(firstResponse)

      // Verificar si formData tiene la propiedad id_article
      /* if (type === "POST") {
        
        url = "controllers/enviar_correos.inc.php"

        // Segunda petición: Enviar notificaciones solo si no hay id_article (es un nuevo artículo)
        const secondResponse = await $.ajax({
            url: url,
            type: type,
            data: { post_id: firstResponse }, // Enviar el ID del post recién creado
        });

        console.log(secondResponse)
        
      }  */


  } catch (error) {
      // Manejar errores
      swal({
          title: "Error!",
          text: "Hubo un problema al procesar la solicitud.",
          icon: "error",
          buttons: {
              confirm: {
                  text: "Confirmar",
                  value: true,
                  visible: true,
                  className: "btn btn-danger",
                  closeModal: true,
              },
          },
      });
  }
}

function cargarArticulo(id, quill) {
  $.ajax({
      url: 'controllers/obtener_articulo.inc.php',
      type: 'GET',
      data: { id: id },
      dataType: 'json',
      success: function(response) {
          if (response.error) {
              alert(response.error);
          } else {
              $('#title').val(response.title);
              $('#category_id').val(response.category_id);
              $('#video').val(response.url)
              let content = unescapeHTML(response.content);
              if (content) {
                  quill.clipboard.dangerouslyPasteHTML(content);  // Inserta el HTML directamente
              }
              $('#page-title').text('Editar Artículo');
              $('#card-title').text('Editar Artículo');
              $('#submit-btn').text('Actualizar Artículo');
              $('#nav-breadcrumb').text('Actualizar Artículo');
          }
      },
      error: function() {
          alert('Error al obtener el artículo.');
      }
  });
}

$(document).ready(function () {

    // Inicializar Quill
    var quill = new Quill('#editor', {
        theme: 'snow'
    });

    // Consultar si hay busqueda por id para entrar en modo editar
    const PARAMS = new URLSearchParams(window.location.search);

    if (PARAMS.has('id')) {
      cargarArticulo(PARAMS.get('id'), quill); // Llamar a la función de carga de artículo con el ID de la URL
      $('#delete-btn').show(); // Mostrar el botón de eliminar artículo
    } else {
      $('#page-title').text('Crear Artículo');
      $('#card-title').text('Crear Artículo');
      $('#submit-btn').text('Crear Artículo');
      $('#nav-breadcrumb').text('Crear Artículo');
    }

    // Cargar listado de categorías de artículos
    $.ajax({
      url: 'controllers/obtener_listado_categorias.inc.php', // El archivo que obtiene las categorías
      type: 'GET',
      dataType: 'json',
      success: function(response) {
          if (response && response.length > 0) {
              var $categorySelect = $('#category_id');
              $categorySelect.empty(); // Limpiar las opciones actuales

              // Iterar sobre las categorías y agregar cada una como una opción
              response.forEach(function(category) {
                  $categorySelect.append('<option value="' + category.category_id + '">' + category.name + '</option>');
              });
          } else {
              alert('No se encontraron categorías.');
          }
      },
      error: function() {
          alert('Error al cargar las categorías.');
      }
  });


    $("#article_form").on("submit", function (e) {
        e.preventDefault();

        const formData = {
            title: $("#title").val(),
            category_id: $("#category_id").val(),
            video: $("#video").val(),
            usuario_id: JSON.parse(atob(sessionStorage.getItem('info'))).id,
            content: quill.root.innerHTML,
        };

        if (!formData.title || !formData.category_id || !formData.content ) {
            swal({
                title: "Oops!",
                text: "Hay campos faltantes",
                icon: "error",
                buttons: {
                  confirm: {
                    text: "Acepto",
                    value: true,
                    visible: true,
                    className: "btn btn-error",
                    closeModal: true,
                  },
                },
              });
            return;
        }

        let url = "controllers/guardar_articulo.inc.php"; // URL por defecto para crear
        let type = "POST"; // Método por defecto para crear

        if (PARAMS.has('id')) { // Si existe un ID de artículo, estamos actualizando
            url = "controllers/actualizar_articulo.inc.php"; // URL para actualizar
            type = "PUT"; // Usamos PUT para actualizar
            formData.article_id = PARAMS.get('id');  // Agregamos el ID del artículo a los datos del formulario
        }

        console.log (formData)

        // Llamar a la función
        saveArticleAndSendNotifications(url, type, formData);

        
    });
});
