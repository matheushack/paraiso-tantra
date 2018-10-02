<?php

/**
 *	Units Helper  
 */

if(!function_exists('dataTableUnits')) {
    /**
     * @return array
     */
    function dataTableUnits()
    {
        return [
            'dTitle' => '',
            'dBtnNew' => route('units.create'),
            'dUrl' => route('units.dataTable'),
            'dColumns' => [
                ['label' => '#', 'field' => 'id'],
                ['label' => 'CNPJ', 'field' => 'cnpj'],
                ['label' => 'Nome', 'field' => 'name', 'width' => '300px'],
                ['label' => 'Ações', 'field' => 'actions', 'width' => '50px']
            ]
        ];
    }
}

if(!function_exists('actionsUnits')){
    /**
     * @param \App\Modules\Users\Models\User $user
     * @return string
     */
    function actionsUnits(\App\Modules\Units\Models\Units $unity)
    {
        return '
            <a href="'.url('unidades/editar').'/'.$unity->id.'" class="btn btn-warning m-btn m-btn--icon m-btn--air" title="Editar">
                <i class="fa fa-pencil"></i>
            </a>
            <a href="#" class="btn btn-danger m-btn m-btn--icon m-btn--air btn-delete-register" title="Excluir" data-title="Usuário" data-url-return="'.route('units').'" data-delete-url="'.url('unidades/deletar/'.$unity->id).'" data-register-id="'.$unity->id.'" data-register-name="'.$unity->name.'">
                <i class="fa fa-trash"></i>
            </a>                 
        ';
    }
}