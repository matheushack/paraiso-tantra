<?php

/**
 *	Usuarios Helper  
 */

if(!function_exists('dataTableUsers')) {
    function dataTableUsers()
    {
        return [
            'dBtnNew' => route('usuarios.novo'),
            'dUrl' => route('usuarios.dataTable'),
            'dColumns' => [
                ['label' => '#', 'field' => 'id'],
                ['label' => 'Nome', 'field' => 'name'],
                ['label' => 'E-mail', 'field' => 'email'],
                ['label' => 'Data cadastro', 'field' => 'created_at'],
                ['label' => 'Ações', 'field' => 'actions']
            ]
        ];
    }
}