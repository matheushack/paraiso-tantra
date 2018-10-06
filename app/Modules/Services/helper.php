<?php

/**
 *	Services Helper  
 */

if(!function_exists('dataTableServices')) {
    /**
     * @return array
     */
    function dataTableServices()
    {
        return [
            'dTitle' => '',
            'dBtnNew' => route('services.create'),
            'dUrl' => route('services.dataTable'),
            'dColumns' => [
                ['label' => '#', 'field' => 'id', 'width' => '20px'],
                ['label' => 'Serviço', 'field' => 'name', 'width' => '250px'],
                ['label' => 'Valor', 'field' => 'amount'],
                ['label' => 'Duração', 'field' => 'duration'],
                ['label' => 'Ativo', 'field' => 'is_active', 'width' => '30px'],
                ['label' => 'Ações', 'field' => 'actions', 'width' => '70px']
            ]
        ];
    }
}

if(!function_exists('actionsServices')){
    /**
     * @param \App\Modules\Users\Models\User $user
     * @return string
     */
    function actionsServices(\App\Modules\Services\Models\Services $services)
    {
        return '
            <a href="'.url('servicos/editar').'/'.$services->id.'" class="btn btn-warning m-btn m-btn--icon m-btn--air" title="Editar">
                <i class="fa fa-pencil"></i>
            </a>
            <a href="#" class="btn btn-danger m-btn m-btn--icon m-btn--air btn-delete-register" title="Excluir" data-title="Usuário" data-url-return="'.route('services').'" data-delete-url="'.url('servicos/deletar/'.$services->id).'" data-register-id="'.$services->id.'" data-register-name="'.$services->name.'">
                <i class="fa fa-trash"></i>
            </a>                 
        ';
    }
}