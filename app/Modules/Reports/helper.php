<?php

/**
 *	Reports Helper  
 */

if(!function_exists('dataTableCustomersReport')) {
    /**
     * @return array
     */
    function dataTableCustomersReport()
    {
        return [
            'dTitle' => '',
            'dUrl' => route('reports.customers.dataTable'),
            'dLength' => 999,
            'dDom' => "`<'row'<'col-sm-6 text-left'f><'col-sm-6 text-right'B>>
			<'row'<'col-sm-12'tr>>
			<'row'<'col-sm-12 col-md-5'i><'col-sm-12 col-md-7 dataTables_pager'lp>>`",
            'dColumns' => [
                ['label' => 'Data inicial', 'field' => 'start'],
                ['label' => 'Data final', 'field' => 'end'],
                ['label' => 'Serviço', 'field' => 'service'],
                ['label' => 'Cliente', 'field' => 'name'],
                ['label' => 'Telefone', 'field' => 'phone'],
                ['label' => 'Celular', 'field' => 'cell_phone'],
                ['label' => 'Terapeutas', 'field' => 'employees'],
                ['label' => 'Unidade', 'field' => 'unity'],
            ]
        ];
    }
}