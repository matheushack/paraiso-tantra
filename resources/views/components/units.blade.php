<label>
    Unidade
</label>
{!! Form::select('unity_id', \App\Modules\Units\Models\Units::optionSelect(), (isset($unity_id) ? $unity_id : null), [
        'class' => 'form-control m-input',
        'id' => 'unity_id',
        'required' => 'required'
]) !!}