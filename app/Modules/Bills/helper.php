<?php

/**
 *	Bills Helper  
 */

if(!function_exists('dataTableBills')) {
    /**
     * @return array
     */
    function dataTableBills()
    {
        return [
            'dTitle' => '',
            'dBtnNew' => route('bills.create'),
            'dUrl' => route('bills.dataTable'),
            'dColumns' => [
                ['label' => '#', 'field' => 'id', 'width' => '20px'],
                ['label' => 'Nome', 'field' => 'name'],
                ['label' => 'Tipo', 'field' => 'type'],
                ['label' => 'Status', 'field' => 'status'],
                ['label' => 'Forma de pagamento', 'field' => 'payment_id'],
                ['label' => 'Conta', 'field' => 'account'],
                ['label' => 'Vencimento', 'field' => 'expiration_date'],
                ['label' => 'Ações', 'field' => 'actions', 'width' => '90px']
            ]
        ];
    }
}

if(!function_exists('actionsBills')){
    /**
     * @param \App\Modules\Users\Models\User $user
     * @return string
     */
    function actionsBills(\App\Modules\Bills\Models\Bills $bill)
    {
        return '
            <a href="'.url('contas-a-pagar/editar').'/'.$bill->id.'" class="btn btn-warning m-btn m-btn--icon m-btn--air" title="Editar">
                <i class="fa fa-pencil"></i>
            </a>
            <a href="#" class="btn btn-danger m-btn m-btn--icon m-btn--air btn-delete-register" title="Excluir" data-title="Contas" data-url-return="'.route('bills').'" data-delete-url="'.url('contas-a-pagar/deletar/'.$bill->id).'" data-register-id="'.$bill->id.'" data-register-name="'.$bill->name.'">
                <i class="fa fa-trash"></i>
            </a>                 
        ';
    }
}