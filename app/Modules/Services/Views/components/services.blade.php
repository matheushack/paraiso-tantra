<label>Serviço</label>
@if(!empty($multiple))
    {!! Form::select('service_id', \App\Modules\Services\Models\Services::optionSelect(), (isset($id) ? $id : null), [
            'class' => 'form-control m-input m-bootstrap-select m_selectpicker',
            'id' => 'service_id',
            'required' => 'required',
            'data-live-search' => 'true',
            'multiple' => (isset($multiple) ? 'multiple' : '')
    ] + ((isset($disabled) ? ['disabled' => ''] : []))) !!}
@else
    {!! Form::select('service_id', \App\Modules\Services\Models\Services::optionSelect(), (isset($id) ? $id : null), [
            'class' => 'form-control m-input m-bootstrap-select m_selectpicker',
            'id' => 'service_id',
            'required' => 'required',
            'data-live-search' => 'true',
    ] + ((isset($disabled) ? ['disabled' => ''] : []))) !!}
@endif

@push('scripts')
    <script>
        $(document).ready(function(){
            $('.m_selectpicker').selectpicker();
        });
    </script>
@endpush