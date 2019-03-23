var oldExportAction = function (self, e, dt, button, config) {
    if (button[0].className.indexOf('buttons-excel') >= 0) {
        if ($.fn.dataTable.ext.buttons.excelHtml5.available(dt, config)) {
            $.fn.dataTable.ext.buttons.excelHtml5.action.call(self, e, dt, button, config);
        }
        else {
            $.fn.dataTable.ext.buttons.excelFlash.action.call(self, e, dt, button, config);
        }
    } else if (button[0].className.indexOf('buttons-print') >= 0) {
        $.fn.dataTable.ext.buttons.print.action(e, dt, button, config);
    } else if (button[0].className.indexOf('buttons-pdf') >= 0) {
        if ($.fn.dataTable.ext.buttons.pdfHtml5.available(dt, config)) {
            $.fn.dataTable.ext.buttons.pdfHtml5.action.call(self, e, dt, button, config);
        }
        else {
            $.fn.dataTable.ext.buttons.pdfFlash.action.call(self, e, dt, button, config);
        }
    }
};

var newExportAction = function (e, dt, button, config) {
    var self = this;
    var oldStart = dt.settings()[0]._iDisplayStart;

    dt.one('preXhr', function (e, s, data) {
        // Just this once, load all data from the server...
        data.start = 0;
        data.length = 2147483647;

        dt.one('preDraw', function (e, settings) {
            // Call the original action function
            oldExportAction(self, e, dt, button, config);

            dt.one('preXhr', function (e, s, data) {
                // DataTables thinks the first item displayed is index 0, but we're not drawing that.
                // Set the property to what it was before exporting.
                settings._iDisplayStart = oldStart;
                data.start = oldStart;
            });

            // Reload the grid with the original page. Otherwise, API functions like table.cell(this) don't work properly.
            setTimeout(dt.ajax.reload, 0);

            // Prevent rendering of the full data to the DOM
            return false;
        });
    });

    // Requery the server with the new one-time export settings
    dt.ajax.reload();
};

var DataTable = function() {

    var construct = function() {
        var table = $('#dataTable');
        var $columns = [];
        var $columnDefs = [];
        var $length = $('#dataTable').data('length');
        var $dom = `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
			<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`;

        if(typeof $('#dataTable').data('dom') !== 'undefined') {
            $dom = $('#dataTable').data('dom');
        }

        table.find('#columns-dataTable > th').each(function(key, item){
            $columns.push({
                data: $(item).data('field')
            });

            var defs = {};
            defs.targets = key;

            if(typeof $(item).data('width') !== 'undefined') {
                defs.width = $(item).data('width');
            }

            if(typeof $(item).data('class') !== 'undefined') {
                defs.className = $(item).data('class');
            }

            $columnDefs.push(defs);
        });

        table.DataTable({
            responsive: true,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            oLanguage: {
                sEmptyTable: "Nenhum registro encontrado",
                sInfo: "Mostrando de _START_ até _END_ de _TOTAL_ registros",
                sInfoEmpty: "Mostrando 0 até 0 de 0 registros",
                sInfoFiltered: "(Filtrados de _MAX_ registros)",
                sInfoPostFix: "",
                sInfoThousands: ".",
                sLengthMenu: "_MENU_ resultados por página",
                sLoadingRecords: "Carregando...",
                sProcessing: "Processando...",
                sZeroRecords: "Nenhum registro encontrado",
                sSearch: "Pesquisar",
                oAria: {
                    sSortAscending: ": Ordenar colunas de forma ascendente",
                    sSortDescending: ": Ordenar colunas de forma descendente"
                },
                buttons: {
                    print: "<i class='fa fa-print'></i> Imprimir",
                    pdf: "<i class='fa fa-file-pdf-o'></i> PDF",
                    excel: "<i class='fa fa-file-excel-o'></i> Excel",
                    copy: "<i class='fa fa-copy'></i> Copiar",
                    copySuccess: {
                        1: "Copiado 1 linha para área de transferência",
                        _: "Copiado %d linhas para área de transferência"
                    },
                    copyTitle: 'Copiado',
                }
            },
            dom: $dom,
            buttons: [
                {
                    extend: 'print',
                    action: newExportAction
                },
                {
                    extend: 'excel',
                    action: newExportAction
                },
                {
                    extend: 'pdfHtml5',
                    action: newExportAction
                }
            ],
            ajax: {
                url: table.data('url'),
                type: table.data('type'),
                beforeSend: function(xhr, type) {
                    if (!type.crossDomain) {
                        xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                    }
                },
                data: function(d) {
                    if(table.data('form-filter')) {
                        var data = $("#" + table.data('form-filter')).serializeObject();
                        d.frm = data;
                    }
                }
            },
            drawCallback: function(settings){
                var json = settings.jqXHR.responseJSON;

                if(typeof json.bills !== 'undefined') {
                    var recipe = $('#bill-recipe');
                    var expense = $('#bill-expense');
                    var total = $('#bill-total');

                    recipe.find('.m-widget24__stats').html(json.bills.total_in_formatted);
                    expense.find('.m-widget24__stats').html(json.bills.total_out_formatted);
                    total.find('.m-widget24__stats').html(json.bills.total_formatted);

                    if(json.bills.total >= 0) {
                        total.find('.m-widget24__stats').removeClass('m--font-danger').addClass('m--font-success');
                        total.find('.progress-bar').removeClass('m--bg-danger').addClass('m--bg-success');
                    }else{
                        total.find('.m-widget24__stats').removeClass('m--font-success').addClass('m--font-danger');
                        total.find('.progress-bar').removeClass('m--bg-success').addClass('m--bg-danger');
                    }
                }
            },
            columns: $columns,
            columnDefs: $columnDefs,
            pageLength: $length
        });
    };


    var deleteButton = function(){
        $('body').on('click', '.btn-delete-register', function(e) {
            e.preventDefault();
            var name = $(this).data('register-name');
            var registerId = $(this).data('register-id');
            var deleteUrl = $(this).data('delete-url');
            var title = $(this).data('title');
            var urlReturn = $(this).data('url-return');

            swal({
                type: 'warning',
                title: 'Deletar registro',
                text: 'Deseja deletar o registro '+name+'?',
                showConfirmButton: true,
                showCancelButton: true,
                confirmButtonText: '<i class="fa fa-trash"></i> Sim',
                cancelButtonText: 'Não',
                confirmButtonClass: 'btn btn-danger m-btn m-btn--icon m-btn--air',
                cancelButtonClass: 'btn m-btn m-btn--icon m-btn--air',
            }).then((willDelete) => {
                    if (willDelete.value) {
                        $.ajax({
                            url: deleteUrl,
                            type: 'POST',
                            data: {id: registerId},
                            dataType: 'json',
                            beforeSend: function(xhr, type) {
                                if (!type.crossDomain) {
                                    xhr.setRequestHeader('X-CSRF-Token', $('meta[name="csrf-token"]').attr('content'));
                                }
                            },
                            success: function (data) {
                                if(data.deleted){
                                    swal({
                                        title: 'Deletar registro',
                                        text: data.message,
                                        type: 'success'
                                    }).then(results => {
                                        window.location = urlReturn;
                                    });
                                }else{
                                    swal({
                                        title: title,
                                        text: data.message,
                                        type: 'error'
                                    })
                                }
                            },
                            error: function(request, status, error)
                            {
                                swal({
                                    title: title,
                                    text: 'Não foi possível deletar o registro. Por favor, tente mais tarde!',
                                    type: 'error'
                                })
                            }
                        });
                    }
                }
            );
        });
    };

    return {
        init: function() {
            construct();
            deleteButton();
        },

    };

}();

jQuery(document).ready(function() {
    DataTable.init();
});
