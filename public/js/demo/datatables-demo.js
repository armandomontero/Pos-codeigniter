// Call the dataTables jQuery plugin
$(document).ready(function() {
  $('#dataTable').DataTable({
        language: {
            "emptyTable": "No hay registros",
            "lengthMenu": "Mostrando _MENU_ registros",
            "info": "Mostrando _START_ hasta _END_ de _TOTAL_ registros",
            "infoEmpty": "Mostrando 0 hasta 0 de 0 registros",
            "search": "Buscar:",
            "paginate": {
                "first": "Primero",
                "last": "Último",
                "next": "Sig",
                "previous": "Ant"
            },
        },
          order: []
    });
});
