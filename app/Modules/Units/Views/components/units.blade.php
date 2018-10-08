<label>Unidade</label>
{!! Form::select('unity_id', \App\Modules\Units\Models\Units::optionSelect(), (isset($unity_id) ? $unity_id : null), [
        'class' => 'form-control m-input m-bootstrap-select m_selectpicker',
        'id' => 'unity_id',
        'required' => 'required',
        'data-live-search' => 'true'
]) !!}

@push('scripts')
    <script>
        $(document).ready(function(){
            $('.m_selectpicker').selectpicker();
        });
    </script>
@endpush