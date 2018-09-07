var DataTable = function() {

    var construct = function() {
        var table = $('#dataTable');
        var $columns = [];
        var $columnDefs = [];
        table.find('#columns-dataTable > th').each(function(key, item){
            $columns.push({
                data: $(item).data('field')
            });

            var defs = {};
            defs.targets = key;

            if(typeof $(item).data('width') != 'undefined')
                defs.width = $(item).data('width');

            if(typeof $(item).data('class') != 'undefined')
                defs.className = $(item).data('class');

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
            dom: `<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
			<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`,
            buttons: [
                'print',
                'copyHtml5',
                'excelHtml5',
                'pdfHtml5',
            ],
            ajax: table.data('url'),
            columns: $columns,
            columnDefs: $columnDefs
        });
    };

    return {
        init: function() {
            construct();
        },

    };

}();

jQuery(document).ready(function() {
    DataTable.init();
});