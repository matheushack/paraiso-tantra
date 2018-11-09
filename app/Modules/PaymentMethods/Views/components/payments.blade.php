<label>Forma de pagamento</label>
{!! Form::select('payment_id', ['' => 'Selecione'] + \App\Modules\PaymentMethods\Models\PaymentMethods::optionSelect(), (isset($payment_id) ? $payment_id : null), [
        'class' => 'form-control m-input m-bootstrap-select m_selectpicker',
        'id' => (isset($id) ? $id : 'payment_id'),
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