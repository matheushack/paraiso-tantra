<label>Unidade</label>
@if(!empty($multiple))
    {!! Form::select('unity_id[]', \App\Modules\Units\Models\Units::optionSelect(), (isset($unity_id) ? $unity_id : null), [
            'class' => 'form-control m-input m-bootstrap-select m_selectpicker',
            'id' => (isset($id) ? $id : 'unity_id'),
            'required' => 'required',
            'data-live-search' => 'true',
            'multiple' => (isset($multiple) ? 'multiple' : '')
    ]) !!}
@else
    {!! Form::select('unity_id', \App\Modules\Units\Models\Units::optionSelect(), (isset($unity_id) ? $unity_id : null), [
            'class' => 'form-control m-input m-bootstrap-select m_selectpicker',
            'id' => (isset($id) ? $id : 'unity_id'),
            'required' => 'required',
            'data-live-search' => 'true'
    ]) !!}
@endif

@push('scripts')
    <script>
        $(document).ready(function(){
            $('.m_selectpicker').selectpicker();
        });
    </script>
@endpush