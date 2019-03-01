<div class="form-group m-form__group row">
    <div class="col-lg-4">
        <label>
            Banco
        </label>
        {!! Form::select('bank_id', \App\Models\Banks::optionSelect(), (isset($bank_id) ? $bank_id : null), [
                'class' => 'form-control m-input m-bootstrap-select m_selectpicker',
                'id' => (isset($id) ? $id : 'bank_id'),
                'data-live-search' => 'true'
        ]) !!}
    </div>
    <div class="col-lg-4">
        <label for="">Tipo conta</label>
        <div class="m-radio-inline">
            <label class="m-radio">
                <input type="radio" name="account_type" value="C" {{isset($account) && $account->account_type == \App\Modules\Accounts\Constants\AccountTypes::CHECKING_ACCOUNT ? 'checked="checked"' : ''}}> Corrente
                <span></span>
            </label>
            <label class="m-radio">
                <input type="radio" name="account_type" value="P" {{isset($account) && $account->account_type == \App\Modules\Accounts\Constants\AccountTypes::SAVINGS_ACCOUNT ? 'checked="checked"' : ''}}> Poupança
                <span></span>
            </label>
        </div>
    </div>
    <div class="col-lg-2">
        <label>
            Agência
        </label>
        <input name="agency_number" type="text" class="form-control m-input" id="agency_number" placeholder=""  value="{{isset($account) ? $account->agency_number : ''}}">
    </div>
    <div class="col-lg-2">
        <label>
            Conta
        </label>
        <input name="account_number" type="text" class="form-control m-input" id="account_number" placeholder=""  value="{{isset($account) ? $account->account_number : ''}}">
    </div>
</div>

@push('scripts')
    <script>
        $(document).ready(function(){
            $('.m_selectpicker').selectpicker();
        });
    </script>
@endpush