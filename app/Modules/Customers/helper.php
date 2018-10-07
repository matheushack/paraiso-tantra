<?php

/**
 *	Customers Helper  
 */

if(!function_exists('dataTableCustomers')) {
    /**
     * @return array
     */
    function dataTableCustomers()
    {
        return [
            'dTitle' => '',
            'dBtnNew' => route('customers.create'),
            'dUrl' => route('customers.dataTable'),
            'dColumns' => [
                ['label' => '#', 'field' => 'id', 'width' => '20px'],
                ['label' => 'Cliente', 'field' => 'name', 'width' => '250px'],
                ['label' => 'Telefone', 'field' => 'phone'],
                ['label' => 'Celular', 'field' => 'cell_phone'],
                ['label' => 'Ações', 'field' => 'actions', 'width' => '70px']
            ]
        ];
    }
}

if(!function_exists('actionsCustomers')){
    /**
     * @param \App\Modules\Users\Models\User $user
     * @return string
     */
    function actionsCustomers(\App\Modules\Customers\Models\Customers $customers)
    {
        return '
            <a href="'.url('clientes/editar').'/'.$customers->id.'" class="btn btn-warning m-btn m-btn--icon m-btn--air" title="Editar">
                <i class="fa fa-pencil"></i>
            </a>
            <a href="#" class="btn btn-danger m-btn m-btn--icon m-btn--air btn-delete-register" title="Excluir" data-title="Clientes" data-url-return="'.route('customers').'" data-delete-url="'.url('clientes/deletar/'.$customers->id).'" data-register-id="'.$customers->id.'" data-register-name="'.$customers->name.'">
                <i class="fa fa-trash"></i>
            </a>                 
        ';
    }
}