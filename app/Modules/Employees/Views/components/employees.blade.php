<label>Terapeutas</label>
<div>
    {!! Form::select('employees[]', (isset($options) ? \App\Modules\Employees\Models\Employees::optionSelect($options) : \App\Modules\Employees\Models\Employees::optionSelect()), (isset($id) ? $id : null), [
            'class' => 'form-control m-input m-select2',
            'id' => 'employees',
            'required' => 'required',
            'multiple' => 'multiple',
            'style' => 'width: 100%',
    ]) !!}
</div>

@push('scripts')
    <script>
        $(document).ready(function(){

            $('#employees').select2({
                placeholder: "{{!empty($placeholder) ? $placeholder : 'Selecionar os terapeutas para o atendimento'}}",
            });
        });
    </script>
@endpush