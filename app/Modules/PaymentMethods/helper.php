<?php

/**
 *	PaymentMethods Helper  
 */

if(!function_exists('dataTablePayments')) {
    /**
     * @return array
     */
    function dataTablePayments()
    {
        return [
            'dTitle' => '',
            'dBtnNew' => route('payments.create'),
            'dUrl' => route('payments.dataTable'),
            'dColumns' => [
                ['label' => '#', 'field' => 'id', 'width' => '30px', 'class' => 'text-center'],
                ['label' => 'Forma de pagamento', 'field' => 'name', 'width' => '300px'],
                ['label' => 'Conta', 'field' => 'account_id'],
                ['label' => 'Alíquota', 'field' => 'aliquot'],
                ['label' => 'Dias entrada conta', 'field' => 'days_in_account'],
                ['label' => 'Ações', 'field' => 'actions', 'width' => '80px']
            ]
        ];
    }
}

if(!function_exists('actionsPayments')){

    /**
     * @param \App\Modules\PaymentMethods\Models\PaymentMethods $paymentMethods
     * @return string
     */
    function actionsPayments(\App\Modules\PaymentMethods\Models\PaymentMethods $paymentMethods)
    {
        return '
            <a href="'.url('formas-pagamento/editar').'/'.$paymentMethods->id.'" class="btn btn-warning m-btn m-btn--icon m-btn--air" title="Editar">
                <i class="fa fa-pencil"></i>
            </a>
            <a href="#" class="btn btn-danger m-btn m-btn--icon m-btn--air btn-delete-register" title="Excluir" data-title="Forma de pagamento" data-url-return="'.route('payments').'" data-delete-url="'.url('formas-pagamento/deletar/'.$paymentMethods->id).'" data-register-id="'.$paymentMethods->id.'" data-register-name="'.$paymentMethods->name.'">
                <i class="fa fa-trash"></i>
            </a>                 
        ';
    }
}