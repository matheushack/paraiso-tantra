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
                'print',
                'copyHtml5',
                'excelHtml5',
                'pdfHtml5',
            ],
            ajax: table.data('url'),
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