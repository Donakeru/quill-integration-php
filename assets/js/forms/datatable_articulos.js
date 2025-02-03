
    $(document).ready(function() {
        let user_id = JSON.parse(atob(sessionStorage.getItem('info'))).id;
        $('#miTabla').DataTable({
            "processing": true,  
            "serverSide": true,  
            "order": [[ 2, "desc" ]],
            "ajax": {
                "url": "controllers/obtener_listado_articulos.inc.php",  
                "type": "POST",
                "data": function(d) {
                    d.user_id = user_id; // Asegúrate de incluir el user_id
                },
                "error": function(xhr, error, thrown) {
                    console.error("Error en la petición:", xhr.responseText);
                }
            },
            "columns": [
                { "data": "post_id" },
                { 
                    data: 'title',
                    render: function(data, type, row) {
                        return `<span title="${data}" style="display:block; max-width:150px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${data}</span>`;
                    }
                },
                { 
                    data: 'created_at_formatted',
                    render: function(data, type, row) {
                        return `<span title="${data}" style="display:block; max-width:80px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${data}</span>`;
                    }
                },
                { 
                    data: 'preview',
                    render: function(data, type, row) {
                        return `<span title="${data}" style="display:block; max-width:250px; white-space:nowrap; overflow:hidden; text-overflow:ellipsis;">${data}</span>`;
                    }
                },
                { 
                    data: "status",
                    render: function(data, type, row) {
                        var statusClass = '';
                        var statusText = data;
                        
                        // Asignar clase y texto basado en el valor del estado
                        if (data === 'publicado') {
                            statusClass = 'btn-success';
                        } else if (data === 'borrador') {
                            statusClass = 'btn-warning';
                        } else {
                            statusClass = 'btn-warning';
                        }
                        
                        // Retornar el botón con el estilo correspondiente
                        return `<div class="d-flex justify-content-center w-100">
                                    <button class="btn ${statusClass} btn-sm" disabled>${statusText}</button>
                                </div>`;
                    }
                },
                { 
                    data: 'post_id', 
                    render: function(data, type, row) {
                        return `
                                <div class="d-flex justify-content-center w-100">
                                    <a href="text-editor.php?id=${data}" class="btn btn-primary btn-sm">
                                        <i class="icon-pencil"></i> Editar
                                    </a>
                                </div>`;
                    }
                }
            ],
            "paging": true,  // Habilita la paginación
            "pageLength": 10, // Define 10 registros por página
            "lengthChange": false, // Desactiva opción de cambiar el número de registros por página
            "pagingType": "full_numbers",  // Muestra paginación completa
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
    });   