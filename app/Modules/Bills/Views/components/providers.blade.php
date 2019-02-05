<label>Fornecedor</label>
<div class="input-group">
    {!! Form::select('provider_id', \App\Modules\Bills\Models\Providers::optionSelect(), (isset($provider_id) ? $provider_id : null), [
            'class' => 'form-control m-input m-bootstrap-select m_selectpicker',
            'id' => 'provider_id',
            'required' => 'required',
            'data-live-search' => 'true'
    ]) !!}
</div>

@push('scripts')
    <script>
        $(document).ready(function(){
            $('.m_selectpicker').selectpicker();
        });
    </script>
@endpush