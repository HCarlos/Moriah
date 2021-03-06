var BlankonHumanResourcesHrStructureTimeManagementTimeSheets = function () {

    return {

        // =========================================================================
        // CONSTRUCTOR APP
        // =========================================================================
        init: function () {
            BlankonHumanResourcesHrStructureTimeManagementTimeSheets.handleBtnAdd();
            BlankonHumanResourcesHrStructureTimeManagementTimeSheets.handleAllMyTimeSheets();
            BlankonHumanResourcesHrStructureTimeManagementTimeSheets.handleApprovedTimeSheets();
            BlankonHumanResourcesHrStructureTimeManagementTimeSheets.handlePendingTimeSheets();
        },

        // =========================================================================
        // BUTTON ADD
        // =========================================================================
        handleBtnAdd: function () {
            $('a[data-toggle="tab"]').on('shown.bs.tab', function (e) {
                var target = $(e.target).attr("href"); // activated tab
                if(target == '#tab-all-my-timesheets'){
                    $('.btn-add-all-my-timesheets').show();
                    $('.btn-add-approved-timesheets').hide();
                    $('.btn-add-pending-timesheets').hide();
                }
                if(target == '#tab-approved-timesheets'){
                    $('.btn-add-all-my-timesheets').hide();
                    $('.btn-add-approved-timesheets').show();
                    $('.btn-add-pending-timesheets').hide();
                }
                if(target == '#tab-pending-timesheets'){
                    $('.btn-add-all-my-timesheets').hide();
                    $('.btn-add-approved-timesheets').hide();
                    $('.btn-add-pending-timesheets').show();
                }
            });
        },

        // =========================================================================
        // ALL MY TIMESHEETS
        // =========================================================================
        handleAllMyTimeSheets: function () {
            var responsiveHelperAjax = undefined;
            var responsiveHelperDom = undefined;
            var breakpointDefinition = {
                tablet: 1024,
                phone : 480
            };
            var tableDom = $('#datatable-all-my-timesheets');

            // Using DOM
            // Remove arrow datatable
            $.extend( true, $.fn.dataTable.defaults, {
                "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 2,3 ] } ]
            } );
            tableDom.dataTable({
                autoWidth        : false,
                preDrawCallback: function () {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelperDom) {
                        responsiveHelperDom = new ResponsiveDatatablesHelper(tableDom, breakpointDefinition);
                    }
                },
                rowCallback    : function (nRow) {
                    responsiveHelperDom.createExpandIcon(nRow);
                },
                drawCallback   : function (oSettings) {
                    responsiveHelperDom.respond();
                }
            });
        },

        // =========================================================================
        // APPROVED TIMESHEETS
        // =========================================================================
        handleApprovedTimeSheets: function () {
            var responsiveHelperAjax = undefined;
            var responsiveHelperDom = undefined;
            var breakpointDefinition = {
                tablet: 1024,
                phone : 480
            };
            var tableDom = $('#datatable-approved-timesheets');

            // Using DOM
            // Remove arrow datatable
            $.extend( true, $.fn.dataTable.defaults, {
                "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 2, 3 ] } ]
            } );
            tableDom.dataTable({
                autoWidth        : false,
                preDrawCallback: function () {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelperDom) {
                        responsiveHelperDom = new ResponsiveDatatablesHelper(tableDom, breakpointDefinition);
                    }
                },
                rowCallback    : function (nRow) {
                    responsiveHelperDom.createExpandIcon(nRow);
                },
                drawCallback   : function (oSettings) {
                    responsiveHelperDom.respond();
                }
            });
        },

        // =========================================================================
        // PENDING TIMESHEETS
        // =========================================================================
        handlePendingTimeSheets: function () {
            var responsiveHelperAjax = undefined;
            var responsiveHelperDom = undefined;
            var breakpointDefinition = {
                tablet: 1024,
                phone : 480
            };
            var tableDom = $('#datatable-pending-timesheets');

            // Using DOM
            // Remove arrow datatable
            $.extend( true, $.fn.dataTable.defaults, {
                "aoColumnDefs": [ { "bSortable": false, "aTargets": [ 1,2,4 ] } ]
            } );
            tableDom.dataTable({
                autoWidth        : false,
                preDrawCallback: function () {
                    // Initialize the responsive datatables helper once.
                    if (!responsiveHelperDom) {
                        responsiveHelperDom = new ResponsiveDatatablesHelper(tableDom, breakpointDefinition);
                    }
                },
                rowCallback    : function (nRow) {
                    responsiveHelperDom.createExpandIcon(nRow);
                },
                drawCallback   : function (oSettings) {
                    responsiveHelperDom.respond();
                }
            });
        }

    };

}();

// Call main app init
BlankonHumanResourcesHrStructureTimeManagementTimeSheets.init();