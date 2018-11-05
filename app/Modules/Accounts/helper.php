<?php

/**
 *	Accounts Helper
 */

if(!function_exists('dataTableAccounts')) {
    /**
     * @return array
     */
    function dataTableAccounts()
    {
        return [
            'dTitle' => '',
            'dBtnNew' => route('accounts.create'),
            'dUrl' => route('accounts.dataTable'),
            'dColumns' => [
                ['label' => '#', 'field' => 'id', 'width' => '20px'],
                ['label' => 'Nome', 'field' => 'name'],
                ['label' => 'Tipo', 'field' => 'type'],
                ['label' => 'Banco', 'field' => 'bank_id'],
                ['label' => 'Tipo conta', 'field' => 'account_type'],
                ['label' => 'Ações', 'field' => 'actions', 'width' => '90px']
            ]
        ];
    }
}

if(!function_exists('actionsAccounts')){
    /**
     * @param \App\Modules\Users\Models\User $user
     * @return string
     */
    function actionsAccounts(\App\Modules\Accounts\Models\Accounts $account)
    {
        return '
            <a href="'.url('contas/editar').'/'.$account->id.'" class="btn btn-warning m-btn m-btn--icon m-btn--air" title="Editar">
                <i class="fa fa-pencil"></i>
            </a>
            <a href="#" class="btn btn-danger m-btn m-btn--icon m-btn--air btn-delete-register" title="Excluir" data-title="Contas" data-url-return="'.route('accounts').'" data-delete-url="'.url('contas/deletar/'.$account->id).'" data-register-id="'.$account->id.'" data-register-name="'.$account->name.'">
                <i class="fa fa-trash"></i>
            </a>                 
        ';
    }
}