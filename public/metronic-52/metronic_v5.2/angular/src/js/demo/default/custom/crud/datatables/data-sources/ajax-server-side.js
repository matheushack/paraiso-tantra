var DatatablesDataSourceAjaxServer = function() {

	var initTable1 = function() {
		var table = $('#m_table_1');

		// begin first table
		table.DataTable({
			responsive: true,
			searchDelay: 500,
			processing: true,
			serverSide: true,
			ajax: 'inc/api/datatables/demos/server.php',
			columns: [
				{data: 'RecordID'},
				{data: 'OrderID'},
				{data: 'Country'},
				{data: 'ShipCity'},
				{data: 'ShipAddress'},
				{data: 'CompanyAgent'},
				{data: 'CompanyName'},
				{data: 'ShipDate'},
				{data: 'Status'},
				{data: 'Type'},
				{data: 'Actions'},
			]
		});
	};

	return {

		//main function to initiate the module
		init: function() {
			initTable1();
		},

	};

}();

jQuery(document).ready(function() {
	DatatablesDataSourceAjaxServer.init();
});