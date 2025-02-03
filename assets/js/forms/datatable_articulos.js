$(document).ready(function() {
    let user_id = JSON.parse(atob(sessionStorage.getItem('info'))).id;

    $('#miTabla').DataTable({
        "processing": true,  
        "serverSide": true,  
        "order": [[2, "desc"]],
        "ajax": {
            "url": "controllers/obtener_listado_articulos.inc.php",  
            "type": "POST",
            "data": function(d) {
                d.user_id = user_id;
            },
            "error": function(xhr, error, thrown) {
                console.error("Error en la petición:", xhr.responseText);
            }
        },
        "columns": [
            { "data": "post_id" },
            { 
                "data": "title",
                "render": function(data) {
                    return `<span title="${data}" style="display:block; max-width:150px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${data}</span>`;
                }
            },
            { 
                "data": "created_at_formatted",
                "render": function(data) {
                    return `<span title="${data}" style="display:block; max-width:80px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${data}</span>`;
                }
            },
            { 
                "data": "preview",
                "render": function(data) {
                    return `<span title="${data}" style="display:block; max-width:250px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${data}</span>`;
                }
            },
            { 
                "data": "status",
                "render": function(data, type, row) {
                    let statusClass = data === 'publicado' ? 'btn-success' : 'btn-warning';
                    let nextStatus = data === 'publicado' ? 'borrador' : 'publicado';
                    
                    return `
                        <div class="d-flex justify-content-center w-100">
                            <button class="btn ${statusClass} btn-sm toggle-status" data-id="${row.post_id}" data-status="${nextStatus}">
                                ${data}
                            </button>
                        </div>`;
                }
            },
            { 
                "data": "post_id", 
                "render": function(data) {
                    return `
                        <div class="d-flex justify-content-center w-100">
                            <a href="text-editor.php?id=${data}" class="btn btn-primary btn-sm">
                                <i class="icon-pencil"></i> Editar
                            </a>
                        </div>`;
                }
            }
        ],
        "paging": true,
        "pageLength": 10,
        "lengthChange": false,
        "pagingType": "full_numbers",
        "language": {
            "search": "Buscar:",
            "lengthMenu": "Mostrar _MENU_ registros por página",
            "zeroRecords": "No se encontraron registros",
            "info": "Mostrando _START_ a _END_ de _TOTAL_ registros",
            "infoEmpty": "No hay registros disponibles",
            "infoFiltered": "(filtrado de _MAX_ registros en total)",
            "paginate": {
                "previous": "Anterior",
                "next": "Siguiente",
                "first": "Primero",
                "last": "Último"
            }
        }
    });

    // Delegación de eventos para los botones de status
    $('#miTabla').on('click', '.toggle-status', function() {
        let button = $(this);
        let postId = button.data('id');
        let newStatus = button.data('status').trim();
        let currentStatus = button.text().trim();

        swal({
            title: "¿Estás seguro?",
            text: `¿Quieres cambiar el estado de\n"${currentStatus}" a "${newStatus}"?`,
            type: "warning",
            buttons: {
              cancel: {
                visible: true,
                text: "Cancelar",
                className: "btn btn-danger",
              },
              confirm: {
                text: "Sí, cambiar",
                className: "btn btn-success",
              },
            },
          }).then((willChange) => {
            if (willChange) {
                $.ajax({
                    url: 'controllers/cambiar_estado_articulo.inc.php',
                    type: 'PUT',
                    data: { post_id: postId, new_status: newStatus },
                    success: function(response) {
                        $('#miTabla').DataTable().ajax.reload(null, false); // Recargar sin reiniciar la paginación
                    },
                    error: function(xhr) {
                        console.error("Error en la actualización:", xhr.responseText);
                    }
                });
            }
          });
    });
});
