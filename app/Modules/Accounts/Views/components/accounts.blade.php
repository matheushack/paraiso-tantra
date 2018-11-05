<label>Conta</label>
<div>
    {!! Form::select('account_id', (isset($options) ? \App\Modules\Accounts\Models\Accounts::optionSelect($options) : \App\Modules\Accounts\Models\Accounts::optionSelect()), (isset($account_id) ? $account_id : null), [
            'class' => 'form-control m-input m-bootstrap-select m_selectpicker',
            'id' => 'account_id',
            'required' => 'required',
            'style' => 'width: 100%',
    ]) !!}
</div>

@push('scripts')
    <script>
        $(document).ready(function(){
            $('.m_selectpicker').selectpicker();
        });
    </script>
@endpush