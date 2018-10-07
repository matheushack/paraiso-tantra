<?php

/**
 *	Employees Helper  
 */

if(!function_exists('dataTableEmployees')) {
    /**
     * @return array
     */
    function dataTableEmployees()
    {
        return [
            'dTitle' => '',
            'dBtnNew' => route('employees.create'),
            'dUrl' => route('employees.dataTable'),
            'dColumns' => [
                ['label' => '#', 'field' => 'id', 'width' => '20px'],
                ['label' => 'Nome', 'field' => 'name', 'width' => '250px'],
                ['label' => 'Data de nascimento', 'field' => 'birth_date', 'width' => '160px'],
                ['label' => 'Cor', 'field' => 'color', 'class'=> 'text-center'],
                ['label' => 'Comissão', 'field' => 'commission', 'width' => '30px', 'class'=> 'text-center'],
                ['label' => 'Acesso sistema', 'field' => 'is_access_system', 'width' => '130px', 'class'=> 'text-center'],
                ['label' => 'Ações', 'field' => 'actions', 'width' => '90px']
            ]
        ];
    }
}

if(!function_exists('actionsEmployees')){
    /**
     * @param \App\Modules\Users\Models\User $user
     * @return string
     */
    function actionsEmployees(\App\Modules\Employees\Models\Employees $employee)
    {
        return '
            <a href="'.url('funcionarios/editar').'/'.$employee->id.'" class="btn btn-warning m-btn m-btn--icon m-btn--air" title="Editar">
                <i class="fa fa-pencil"></i>
            </a>
            <a href="#" class="btn btn-danger m-btn m-btn--icon m-btn--air btn-delete-register" title="Excluir" data-title="Funcionários" data-url-return="'.route('employees').'" data-delete-url="'.url('funcionarios/deletar/'.$employee->id).'" data-register-id="'.$employee->id.'" data-register-name="'.$employee->name.'">
                <i class="fa fa-trash"></i>
            </a>                 
        ';
    }
}