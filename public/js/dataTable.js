var DataTable = function() {

    var construct = function() {
        var table = $('#dataTable');
        var $columns = [];
        table.find('#columns-dataTable > th').each(function(key, item){
            $columns.push({
                data: $(item).data('field')
            });
        });

        table.DataTable({
            responsive: true,
            searchDelay: 500,
            processing: true,
            serverSide: true,
            language: 'https://cdn.datatables.net/plug-ins/1.10.19/i18n/Portuguese-Brasil.json',
            ajax: table.data('url'),
            columns: $columns
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