//DATATABLE CON SIMBOLO MAS
$(document).ready(function() {
    $('[data-toggle="tooltipTable"]').tooltip();
    $('#example').DataTable( {
        responsive: {
            details: {
                type: 'column'
            }
        },
        columnDefs: [ {
            className: 'control',
            orderable: false,
            targets:   0
        } ],
        order: [ 1, 'desc' ],
        drawCallback: function (settings) {
            console.log('drawCallback');
            $('[data-toggle="tooltipTable"]').tooltip();
        }
    });
    var table = $('#table1').DataTable({
        responsive: {
            details: {
                type: 'column'
            }
        },
        columnDefs: [ {
            className: 'control',
            orderable: false,
            targets:   0
        } ],
        order: [ 1, 'desc' ]

    });
    table.on( 'draw', function () {
        console.log('draw event');
        $('[data-toggle="tooltipTable"]').tooltip();
    } );
    var table2 = $('#table2').DataTable({
        responsive: {
            details: {
                type: 'column'
            }
        },
        columnDefs: [ {
            className: 'control',
            orderable: false,
            targets:   0
        } ],
        order: [ 1, 'desc' ]

    });
} );
// FIN DE DATATABLE CON SIMBOLO MAS
