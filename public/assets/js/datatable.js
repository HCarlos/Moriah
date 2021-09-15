
$(document).ready(function() {

    $.ajaxSetup({
        headers: {
            'X-CSRF-Token': $("meta[name='csrf-token']").attr("content")
        }
    });

    if ( $(".table").length > 0 ){

        var nCols = $(".table").find("tbody > tr:first td").length;
        var aCol = [];

        aCol[nCols - 1] = {"sorting": false};
        if (aCol.length > 0 ){
            $(".table").DataTable({
                searching: true,
                paging: true,
                info: true,
                "pageLength": 10,
                "order": [[ 0, "desc" ]],
                "language": {
                    "lengthMenu":  "Mostrando _MENU_ entradas",
                    "sInfo":       "del _START_ al _END_ de un total de _TOTAL_ entradas",
                    "sInfoFiltered":  "(filtrado de un total de _MAX_ registros)",
                    "sInfoEmpty":  "Mostrando registros del 0 al 0 de un total de 0 registros",
                    "zeroRecords": "Busqueda sin resultados",
                    "sSearch":     "Buscar:",
                    "oPaginate": {
                        "sFirst":    "Primero",
                        "sLast":     "Último",
                        "sNext":     "Siguiente",
                        "sPrevious": "Anterior"
                    },
                    "info":        "Mostrando página _PAGE_ de _PAGES_"
                },
                "lengthMenu": [[10, 25, 50, -1], [10, 25, 50, "Todos"]],
                "aoColumns": aCol
            });
        }
    }


});
