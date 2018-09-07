<?php

/**
 *	User Helper
 */

if(!function_exists('dataTableUsers')) {
    /**
     * @return array
     */
    function dataTableUsers()
    {
        return [
            'dTitle' => '',
            'dBtnNew' => route('users.create'),
            'dUrl' => route('users.dataTable'),
            'dColumns' => [
                ['label' => '#', 'field' => 'img_profile', 'width' => '100px', 'class' => 'text-center'],
                ['label' => 'E-mail', 'field' => 'email', 'width' => '300px'],
                ['label' => 'Data cadastro', 'field' => 'created_at', 'width' => '110px'],
                ['label' => 'Ações', 'field' => 'actions', 'width' => '50px']
            ]
        ];
    }
}

if(!function_exists('imgProfile')){
    /**
     * @param \App\Modules\Users\Models\User $user
     * @return string
     */
    function imgProfileUsers(\App\Modules\Users\Models\User $user)
    {
        return '
        <div class="m-card-user m-card-user--sm">
            <div class="m-card-user__pic">
                <div class="m-card-user__no-photo m--bg-fill-brand"><span><img src="'.url($user->img_profile).'"></span></div>
            </div>
            <div class="m-card-user__details">
                <span class="m-card-user__name">'.$user->name.'</span>
                <a href="" class="m-card-user__email m-link">Perfil: Administrador</a>
            </div>
        </div>';
    }
}

if(!function_exists('actionsUsers')){
    /**
     * @param \App\Modules\Users\Models\User $user
     * @return string
     */
    function actionsUsers(\App\Modules\Users\Models\User $user)
    {
        return '
            <a href="#" class="btn btn-warning m-btn m-btn--icon m-btn--air" title="Editar">
                <i class="fa fa-pencil"></i>
            </a>
            <a href="#" class="btn btn-danger m-btn m-btn--icon m-btn--air" title="Excluir">
                <i class="fa fa-trash"></i>
            </a>                 
        ';
    }
}