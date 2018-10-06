<?php

/**
 *	Rooms Helper  
 */

if(!function_exists('dataTableRooms')) {
    /**
     * @return array
     */
    function dataTableRooms()
    {
        return [
            'dTitle' => '',
            'dBtnNew' => route('rooms.create'),
            'dUrl' => route('rooms.dataTable'),
            'dColumns' => [
                ['label' => '#', 'field' => 'id', 'width' => '50px'],
                ['label' => 'Sala', 'field' => 'name', 'width' => '150px'],
                ['label' => 'Unidade', 'field' => 'unity', 'width' => '150px'],
                ['label' => 'Em funcionamento', 'field' => 'is_active', 'width' => '135px'],
                ['label' => 'Ações', 'field' => 'actions', 'width' => '50px']
            ]
        ];
    }
}

if(!function_exists('actionsRooms')){
    /**
     * @param \App\Modules\Users\Models\User $user
     * @return string
     */
    function actionsRooms(\App\Modules\Rooms\Models\Rooms $rooms)
    {
        return '
            <a href="'.url('salas/editar').'/'.$rooms->id.'" class="btn btn-warning m-btn m-btn--icon m-btn--air" title="Editar">
                <i class="fa fa-pencil"></i>
            </a>
            <a href="#" class="btn btn-danger m-btn m-btn--icon m-btn--air btn-delete-register" title="Excluir" data-title="Usuário" data-url-return="'.route('rooms').'" data-delete-url="'.url('salas/deletar/'.$rooms->id).'" data-register-id="'.$rooms->id.'" data-register-name="'.$rooms->name.'">
                <i class="fa fa-trash"></i>
            </a>                 
        ';
    }
}